@extends('master')

@section('content_header')
    <h1>Editar Equipamento</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')
    
    <div class="row">

        <div class="col-md-6">
            <form action="{{ url('equipamentos'). '/' . $equipamento->id }}" method='post'>
                {{ csrf_field() }} 
                {{ method_field('patch') }}
                @include('equipamentos.form')
            </form>
        </div>
    </div>

@endsection

