<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;


class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.colores');
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
            $color = new Color();
            $color->nombre = $request->nombre;
            $color->save();
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
     * Actualizar colores
     */
    public function update(Request $request)
    {
        try {
            $color = Color::findORFail($request->id);
            $color->nombre = $request->nombre;
            $color->save();
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
            $color = Color::findORFail($request->id);
            $color->delete();
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show()
    {
        try {
            $colores = Color::orderBy('id','DESC')->get();
            return $colores;
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}