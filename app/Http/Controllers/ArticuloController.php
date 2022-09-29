<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.articulos');
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
            $articulo = new Articulo();
            $articulo->codigo = $request->codigo;
            $articulo->nombre = $request->nombre;
            $articulo->descripcion = $request->descripcion;
            $articulo->tipo = $request->tipo;
            $articulo->precio = $request->precio;
            $articulo->existencia = $request->existencia;
            $articulo->estado = $request->estado;
            $articulo->categoria_id = $request->categoria_id;
            $articulo->color_id = $request->color_id;
            if($articulo->save()>=1){
            return response()->json(['status'=>'ok','data'=>$articulo],201);
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
            $articulos = Articulo::join('categorias','articulos.categoria_id','=','categorias.id')
            ->join('colores','articulos.color_id','=','colores.id')
            ->select('articulos.id','articulos.codigo','articulos.nombre','articulos.descripcion','articulos.tipo','articulos.precio','articulos.existencia','articulos.estado','articulos.categoria_id','categorias.nombre as categoria','articulos.color_id','colores.nombre as color')
            ->orderBy('articulos.id','DESC')->get();
            //$articulos = Articulo::All();
            return $articulos;
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
            $articulo = Articulo::findOrfail($request->id);
            $articulo->codigo = $request->codigo;
            $articulo->nombre = $request->nombre;
            $articulo->descripcion = $request->descripcion;
            $articulo->tipo = $request->tipo;
            $articulo->precio = $request->precio;
            $articulo->existencia = $request->existencia;
            $articulo->estado = $request->estado;
            $articulo->categoria_id = $request->categoria_id;
            $articulo->color_id = $request->color_id;
            if($articulo->save()>=1){
            return response()->json(['status'=>'ok','data'=>$articulo],202);
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
            $articulo = Articulo::findOrfail($request->id);
            $articulo->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
