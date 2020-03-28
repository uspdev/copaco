@extends('master')

@section('content_header')
    <h1>Cadastrar Equipamento</h1>
@stop

@section('content')
@include('messages.flash')
@include('messages.errors')
        
    <div class="row">


        <div class="col-md-6">
            <form action="{{ url('equipamentos') }}" method="post">
            {{ csrf_field() }}
            @include('equipamentos.form')
            </form>
        </div>
    </div>
@stop
