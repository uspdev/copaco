@extends('master')

@section('content_header')
    <h1>Cadastrar Rede</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')
    
    <div class="card">
        <div class="card-header">Cadastrar Rede</div>
        <div class="card-body">
            <form method="post" action="{{ url('redes') }}">
                {{ csrf_field() }}
                @include('redes.form')
            </form>
        </div>
    </div>

@stop
