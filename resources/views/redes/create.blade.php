@extends('adminlte::page')

@section('content_header')
    <h1>Cadastrar Rede</h1>
@stop

@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

        <div class="col-md-6">
            <form method="post" action="{{ url('redes') }}">
                {{ csrf_field() }}
                @include('redes.form')
            </form>
        </div>
    </div>

@stop
