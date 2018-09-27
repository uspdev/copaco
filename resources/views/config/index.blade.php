@extends('adminlte::page')

@section('content_header')
    <h1>Configurações</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <form action="/dhcpd.conf" method="post">
        {{csrf_field()}}
        <input type="hidden" name="consumer_deploy_key" value="{{ $consumer_deploy_key }}">
        <button class="btn btn-success" type="submit">Gerar dhcpd.conf</button>
    </form>
</div>

<br />

<div>
    <form action="/freeradius/authorize-file" method="post">
        {{csrf_field()}}
        <input type="hidden" name="consumer_deploy_key" value="{{ $consumer_deploy_key }}">
        <button class="btn btn-success" type="submit">Gerar authorize para freeradius</button>
    </form>
</div>

<br />

<div>
    <form action="/freeradius/sincronize" method="post">
        {{csrf_field()}}
        <button class="btn btn-success" type="submit">Sincronizar com Freeradius</button>
    </form>
</div>

@stop
