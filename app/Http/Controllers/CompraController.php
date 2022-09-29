<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use Iluminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.compras');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
                $errors = 0;
                DB::beginTransaction();
                $compra = new Compra();
                $compra->factura = $request->factura;
                $compra->fecha_compra = $request->fechaCompra;
                $compra->tipo_compra = $request->tipoCompra;
                $compra->iva = $request->iva;
                $compra->total = $request->total;
                $compra->correlativo = $this->postCorrelativo();
                $compra->user_id = $request->user['id'];
                if($compra->save()<=0){
                    $errors++;
                }
                $detalle = $request->productos;
                foreach($detalle as $key => $det){
                    $detCompra = new DetalleCompra();
                    $detCompra->user_id = $det['producto']['id'];
                    $detCompra->user_id = $compra->id;
                    if($detCompra->save()<=0){
                        $errors++;
                    };
                }
                if($errors==0){
                    DB::commit();
                    return response()->json(['status'=>'ok', 'data'=>$prestamo],201);
                }else{
                    DB::rollBack();
                    return response()->json(['status'=>'fail', 'data'=>$prestamo],409);
                }
            }catch(\Exception $e){
                DB::rollBack();
                return $e->getMessage();
        }
    }

    public function changeState(Request $request){
        try{
            $compra = Compra::findOrfail($request->$id);
            $compra->$estado = $request->$estado;
            $compra->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $state = $request->state;
            $compras = Compra::join('users','compras.user_id','=','users.id')
            ->select('compras.id','compras.correlativo','compras.fecha_compra','compras.estado','users.name')
            ->where('compras.estado','=', $state)
            ->orderBy('compras.id','desc')->get();
            return $compras;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCorrelativo(){
        $result = DB::select("SELECT CONCAT(TRIM(YEAR(CURDATE())),LPAD(TRIM(MONTH(CURDATE())),2,0),LPAD(IFNULL(MAX(TRIM(SUBSTRING(correlativo,7,4))),0)+1,4,0)) as correlativo FROM prestamos WHERE SUBSTRING(correlativo,1,6) = CONCAT(TRIM(YEAR(CURDATE())),LPAD(TRIM(MONTH(CURDATE())),2,0))");
        return $result[0]->correlativo;
        }
}