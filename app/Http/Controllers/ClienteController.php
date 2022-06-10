<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.clientes');
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
            $cliente = new Cliente();
            $cliente->nombre = $request->nombre;
            $cliente->telefono = $request->telefono;
            $cliente->save();
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
     * Actualizar clientes
     */
    public function update(Request $request)
    {
        try {
            $cliente = Cliente::findORFail($request->id);
            $cliente->nombre = $request->nombre;
            $cliente->telefono = $request->telefono;
            $cliente->save();
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
            $cliente = Cliente::findORFail($request->id);
            $cliente->delete();
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show()
    {
        try {
            $clientes = Cliente::orderBy('id','DESC')->get();
            return $clientes;
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}