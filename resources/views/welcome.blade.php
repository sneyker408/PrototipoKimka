@extends('adminlte::page')

@section('title', 'Creaciones')

@section('content_header')
    <h1>Inicio</h1>
@stop

@section('content')
<div display: inline-block; class="card" style="width: 18rem;">
  <img src="https://www.ecommercenews.pe/wp-content/uploads/2017/07/tienda-online.png" class="card-img-top" alt="...">
  <div class="card-body">
    <p class="card-text">Categorias</p>
    <a href="categorias" class="btn btn-primary stretched-link">Vamos</a>
  </div>
</div>   

<div class="card" style="width: 18rem;">
  <img src="https://blog.comparasoftware.com/wp-content/uploads/2021/02/tipos-de-clientes-de-ecommerce-1.png" class="card-img-top" alt="...">
  <div class="card-body">
    <p class="card-text">Clientes</p>
    <a href="clientes" class="btn btn-primary stretched-link">Vamos</a>
  </div>
</div> 
<div class="card" style="width: 18rem;">
  <img src="https://eominternacional.com/wp-content/uploads/2019/12/articulos-cientificos.jpg" class="card-img-top" alt="...">
  <div class="card-body">
    <p class="card-text">Articulos</p>
    <a href="articulos" class="btn btn-primary stretched-link">Vamos</a>
  </div>
</div> 
<div class="card" style="width: 18rem; ">
  <img src="https://imborrable.com/wp-content/uploads/2021/01/psicologia-del-color-significados.png" class="card-img-top" alt="...">
  <div class="card-body">
    <p class="card-text">Colores</p>
    <a href="colores" class="btn btn-primary stretched-link">Vamos</a>
  </div>
</div> 
<div class="card" style="width: 18rem;">
  <img src="https://i.ytimg.com/vi/iwWNW4JWnFw/maxresdefault.jpg" class="card-img-top" alt="...">
  <div class="card-body">
    <p class="card-text">Creaciones</p>
    <a href="creaciones" class="btn btn-primary stretched-link">Vamos</a>
  </div>
</div> 
<div class="card" style="width: 18rem;">
  <img src="https://encolombia.com/wp-content/uploads/2018/05/Claves-Aumentar-Ventas.png" class="card-img-top" alt="...">
  <div class="card-body">
    <p class="card-text">Ventas</p>
    <a href="ventas" class="btn btn-primary stretched-link">Vamos</a>
  </div>
</div> 
<div class="card" style="width: 18rem;">
  <img src="https://escuelainenka.com/wp-content/uploads/proveedores.jpg" class="card-img-top" alt="...">
  <div class="card-body">
    <p class="card-text">Proveedores</p>
    <a href="proveedores" class="btn btn-primary stretched-link">Vamos</a>
  </div>
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