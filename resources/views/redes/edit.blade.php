@extends('master')

@section('content_header')
    <h1>Editar Rede</h1>
@stop


@section('content')

    @include('messages.flash')
    @include('messages.errors')
    
<div class="card">
    <div class="card-header">Editar Rede</div>
    <div class="card-body">
        <form method="post" action="{{ action('App\Http\Controllers\RedeController@update', $rede->id) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            @include('redes.form')
        </form>
    </div>
</div>

@stop
