@extends('dashboard.master')

@section('content')
<h1>Editar Equipamento</h1>

@include('messages.flash')
@include('messages.errors')

<div class="row">
    <div class="col-lg-4">
        <form action="{{ url('equipamentos'). '/' . $equipamento->id }}" method='post'>
            {{ csrf_field() }} 
            {{ method_field('patch') }}
            @include('equipamentos.form')
        </form>
    </div>
</div>

@endsection
