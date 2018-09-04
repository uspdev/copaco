@extends('adminlte::page')

@section('content_header')
    <h1>Editar Equipamento</h1>
@stop

@section('content')
    <div class="row">
    @include('messages.flash')
    @include('messages.errors')


    <div class="col-md-6">
        <form action="{{ url('equipamentos'). '/' . $equipamento->id }}" method='post'>
            {{ csrf_field() }} 
            {{ method_field('patch') }}
            @include('equipamentos.form')
        </form>
    </div>
</div>

@endsection

@section('css')
    @include('equipamentos.css')
@stop

@section('js')
    @include('equipamentos.js')
@stop
