@extends('master')

@section('content_header')
    <h1>Editar Rede</h1>
@stop


@section('content')

    @include('messages.flash')
    @include('messages.errors')
    
<div class="row">

    <div class="col-md-6">
        <form method="post" action="{{ action('RedeController@update', $rede->id) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            @include('redes.form')
        </form>
    </div>
</div>

@stop
