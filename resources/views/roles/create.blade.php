@extends('master')

@section('content_header')
    <h1>Cadastrar Grupo</h1>
@stop

@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

        <div class="col-md-6">
            <form method="post" action="{{ url('roles') }}">
                {{ csrf_field() }}
                @include('roles.form')
            </form>
        </div>
    </div>

@stop
