@extends('master')

@section('content_header')
    <h1>Cadastrar Grupo</h1>
@stop

@section('content')
@include('messages.flash')
@include('messages.errors')
<div class="card">    
        <div class="card-header">Cadastrar Grupo</div>
        <div class="card-body">
            <form method="post" action="{{ url('roles') }}">
                {{ csrf_field() }}
                @include('roles.form')
            </form>
        </div>
    </div>

@stop
