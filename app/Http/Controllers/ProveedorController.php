<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;


class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.proveedores');
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
        try {
            $proveedor = new Proveedor();
            $proveedor->nombre = $request->nombre;
            $proveedor->correo = $request->correo;
            $proveedor->telefono = $request->telefono;
            $proveedor->save();
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
     * Actualizar proveedores
     */
    public function update(Request $request)
    {
        try {
            $proveedor = Proveedor::findORFail($request->id);
            $proveedor->nombre = $request->nombre;
            $proveedor->correo = $request->correo;
            $proveedor->telefono = $request->telefono;
            $proveedor->save();
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
            $proveedor = Proveedor::findORFail($request->id);
            $proveedor->delete();
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show()
    {
        try {
            $proveedores = Proveedor::orderBy('id','DESC')->get();
            return $proveedores;
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}