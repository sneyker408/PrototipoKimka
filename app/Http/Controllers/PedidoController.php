<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pedidos');
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
            $pedido = new Pedido();
            $pedido->nombre = $request->nombre;
            $pedido->descripcion = $request->descripcion;
            $pedido->estado = $request->estado;
            $pedido->fecha_pedido = $request->fecha_pedido;
            $pedido->fecha_entrega = $request->fecha_entrega;
            $pedido->cliente_id = $request->cliente_id;
            $pedido->user_id = $request->user_id;
            if($pedido->save()>=1){
            return response()->json(['status'=>'ok','data'=>$pedido],201);
            }
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
        try{
            $pedidos = Pedido::join('clientes','pedidos.cliente_id','=','clientes.id')
            ->join('users','pedidos.user_id','=','users.id')
            ->select('pedidos.id','pedidos.codigo','pedidos.nombre','pedidos.descripcion','pedidos.fecha_pedido','pedidos.fecha_entrega','pedidos.estado','pedidos.cliente_id','clientes.nombre as cliente','pedidos.user_id','users.nombre as user')
            ->orderBy('pedidos.id','DESC')->get();
            //$pedidos = Pedido::All();
            return $pedidos;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            $pedido = Pedido::findOrfail($request->id);
            $pedido->nombre = $request->nombre;
            $pedido->descripcion = $request->descripcion;
            $pedido->estado = $request->estado;
            $pedido->fecha_pedido = $request->fecha_pedido;
            $pedido->fecha_entrega = $request->fecha_entrega;
            $pedido->cliente_id = $request->cliente_id;
            $pedido->user_id = $request->user_id;
            if($pedido->save()>=1){
            return response()->json(['status'=>'ok','data'=>$pedido],202);
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $pedido = Pedido::findOrfail($request->id);
            $pedido->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
