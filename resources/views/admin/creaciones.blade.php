@extends('adminlte::page')

@section('title', 'Creaciones')

@section('content_header')
    <h1>Creaciones</h1>
@stop

@section('content')
    <div id="app">
        <Creaciones></Creaciones>
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