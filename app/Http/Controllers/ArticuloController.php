<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;

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
        try {
            $articulo = new Articulo();
            $articulo->codigo = $request->codigo;
            $articulo->nombre = $request->nombre;
            $articulo->talla = $request->talla;
            $articulo->descripcion = $request->descripcion;
            $articulo->estado = $request->estado;
            $articulo->categoria_id = $request->categoria_id;
            if($articulo->save()>=1) {
                return response()->json(['status'=>'ok', 'data'=>$articulo],201);
            }
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * Actualizar Articulos
     */
    public function update(Request $request)
    {
        try {
            $articulo = Articulo::findOrFail($request->id);
            $articulo->codigo = $request->codigo;
            $articulo->talla = $request->talla;
            $articulo->descripcion = $request->descripcion;
            //$articulo->estado = $request->estado;
            $articulo->categoria_id = $request->categoria_id;
            if ($articulo->save()>=1) {
                return response()->json(['status'=>'ok', 'data'=>$articulo],202);
            }
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\
     * 
     * Eliminar cateogrias
     */
    public function destroy(Request $request)
    {
        try {
            $articulo = Articulo::findORFail($request->id);
            $articulo->delete();
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show()
    {
        try {
            $articulos = Articulo::join('categorias','articulos.categoria_id','=','categorias.id')
            ->select('articulos.id','articulos.codigo','articulos.talla','articulos.descripcion','articulos.estado','articulos.categoria_id','categorias.nombre as categoria')
            ->orderBy('articulos.id','DESC')->get();
            return $articulos;
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}
