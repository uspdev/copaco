@extends('master')

@section('content_header')
    <h1>Configurações</h1>
@stop

@section('content')
    @parent

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

<div>

<br>
<form action="/config" method="post">
{{csrf_field()}}
<div class="panel panel-default">
    <div class="panel-heading">Configurações para DHCP</div>
        <div class="panel-body">
            <div class="form-group">
                <label for="dhcp_global">Parâmetros globais</label>

                @if(!is_null($configs->where('key','dhcp_global')->first()))
                    <textarea rows="4" cols="50" class="form-control" name="dhcp_global">{{$configs->where('key','dhcp_global')->first()->value}}</textarea>
                @else
                    <textarea rows="4" cols="50" class="form-control" name="dhcp_global">ddns-update-style none;
default-lease-time 86400;
max-lease-time 86400;
authoritative;</textarea>
                @endif
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Enviar Dados">
            </div>
        </div>
    </div>
</div>
</form>

@stop
