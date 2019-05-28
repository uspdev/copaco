@extends('master')

@section('content_header')
    <h1>Cadastrar Equipamento</h1>
@stop

@section('content')
    <div class="row">
        @include('messages.flash')
        @include('messages.errors')

        <div class="col-md-6">
            <form action="{{ url('equipamentos') }}" method="post">
            {{ csrf_field() }}
            @include('equipamentos.form')
            </form>
        </div>
    </div>
@stop

@section('css')
    @include('equipamentos.css')
@stop

@section('js')
    @include('equipamentos.js')
@stop
