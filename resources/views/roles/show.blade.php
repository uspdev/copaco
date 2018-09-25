@extends('adminlte::page')

@section('content_header')
  <h1>Grupo:{{ $role->nome }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{action('RoleController@edit', $role->id)}}" class="btn btn-success">Editar</a>
</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Grupo</b>: {{ $role->nome }}</li>
    </ul>
</div>

@stop


