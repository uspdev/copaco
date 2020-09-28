@extends('master')

@section('content_header')
    <h1>Editar Grupo</h1>
@stop


@section('content')
@include('messages.flash')
@include('messages.errors')
<div class="card">
    <div class="card-header">Editar Grupo</div>
    <div class="card-body">
        <form method="post" action="{{ action('App\Http\Controllers\RoleController@update', $role->id) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            @include('roles.form')
        </form>
    </div>
</div>

@stop
