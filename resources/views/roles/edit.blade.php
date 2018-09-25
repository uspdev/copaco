@extends('adminlte::page')

@section('content_header')
    <h1>Editar Grupo</h1>
@stop


@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

    <div class="col-md-6">
        <form method="post" action="{{ action('RoleController@update', $role->id) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            @include('roles.form')
        </form>
    </div>
</div>

@stop
