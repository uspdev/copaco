@extends('master')

@section('content_header')
    <h1>Cadastrar Equipamento</h1>
@stop

@section('content')
        
    <div class="card">
        <div class="card-header">Cadastro de Equipamento</div>
        <div class="card-body">
            <form action="{{ url('equipamentos') }}" method="post">
            {{ csrf_field() }}
            @include('equipamentos.form')
            </form>
        </div>
    </div>
@stop
