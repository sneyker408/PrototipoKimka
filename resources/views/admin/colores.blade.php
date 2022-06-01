@extends('adminlte::page')

@section('title', 'Colores')

@section('content_header')
    <h1>Colores</h1>
@stop

@section('content')
    <div id="app">
        <Colores></Colores>
    </div>
@stop

@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
@stop

@section('js')
    <!-- <script> console.log('Hi!'); </script> -->
    <script src="{{asset('js/app.js')}}"></script>
@stop