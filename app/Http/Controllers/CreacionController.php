<?php

namespace App\Http\Controllers;

use App\Models\Creacion;
use Illuminate\Http\Request;

class CreacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.creaciones');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Creacion  $creacion
     * @return \Illuminate\Http\Response
     */
    public function show(Creacion $creacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Creacion  $creacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Creacion $creacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Creacion  $creacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Creacion $creacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Creacion  $creacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Creacion $creacion)
    {
        //
    }
}
