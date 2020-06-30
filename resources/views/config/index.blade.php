@extends('master')

@section('content_header')
    <h1>Configurações</h1>
@stop

@section('content')
    @parent

<div>
    <form action="/api/dhcpd.conf" method="post">
        <input type="hidden" name="consumer_deploy_key" value="{{ $consumer_deploy_key }}">
        <button class="btn btn-success" type="submit">Gerar dhcpd.conf com subnets</button>
    </form>
</div>

<br />

<div>
    <form action="/api/uniquedhcpd.conf" method="post">
        <input type="hidden" name="consumer_deploy_key" value="{{ $consumer_deploy_key }}">
        <button class="btn btn-success" type="submit">Gerar dhcpd.conf único (sem subnets)</button>
    </form>
</div>

<br />

<div>
    <form action="/api/freeradius/authorize_file" method="post">
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
                <label for="dhcp_global">shared-networks (além da default):</label>

                @if(!is_null($configs->where('key','shared_network')->first()))
                    <input class="form-control" name="shared_network" value="{{$configs->where('key','shared_network')->first()->value}}">
                @else
                    <input class="form-control" name="shared_network">
                @endif
            <small id="emailHelp" class="form-text text-muted">Por padrão todas subnet são agrupadas em 
            uma mesma shared-network chamada default. Esta opção serve para criar outras shared-network.
            Use vírgula para separar as shared-networks. 
            Exemplo: labs, externos </small>
            </div>

<div class="row">
    <div class="col-sm form-group">
        <label for="iprede">IP Rede</label>

        @if(!is_null($configs->where('key','unique_iprede')->first()))
            <input type="text" class="form-control" name="unique_iprede" value="{{$configs->where('key','unique_iprede')->first()->value}}">
        @else
            <input type="text" class="form-control" name="unique_iprede">
        @endif
    </div>

    <div class="col-smform-group">
        <label for="gateway">Gateway</label>

        @if(!is_null($configs->where('key','unique_gateway')->first()))
            <input type="text" class="form-control" name="unique_gateway" value="{{$configs->where('key','unique_gateway')->first()->value}}">
        @else
            <input type="text" class="form-control" name="unique_gateway">
        @endif

    </div>

    <div class="col-sm form-group">
        <label for="cidr">Cidr</label>

        @if(!is_null($configs->where('key','unique_cidr')->first()))
            <input type="text" class="form-control" name="unique_cidr" value="{{$configs->where('key','unique_cidr')->first()->value}}">
        @else
            <input type="text" class="form-control" name="unique_cidr">
        @endif

    </div>

</div>
    <div class="form-group">
        <label for="ips_reservados">IPs reservados desta rede (separados por vírgula)</label>

        @if(!is_null($configs->where('key','ips_reservados')->first()))
            <input type="text" class="form-control" name="ips_reservados" value="{{$configs->where('key','ips_reservados')->first()->value}}">
        @else
            <input type="text" class="form-control" name="ips_reservados">
        @endif

    </div>
<small class="form-text text-muted">Caso queira também gerar um dhcpd.conf sem segmentação de rede
preencha os dados dessa única rede</small>

<br>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Enviar Dados">
</div>

        </div>
    </div>
</div>
</form>

@stop
