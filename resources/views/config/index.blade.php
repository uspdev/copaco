@extends('master')

@section('content_header')
    <h1>Configurações</h1>
@stop

@section('content')
        <div>
            <form action="/api/dhcpd.conf" method="post">
                {{csrf_field()}}
                <input type="hidden" name="consumer_deploy_key" value="{{ $consumer_deploy_key }}">
                <button class="btn btn-success" type="submit">Gerar dhcpd.conf com subnets</button>
            </form>
        </div>

        <br />

        <div>
            <form action="/api/freeradius/authorize_file" method="post">
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

        <br />

        <div>
            <form action="/api/uniquedhcpd.conf" method="post">
                {{csrf_field()}}
                <input type="hidden" name="consumer_deploy_key" value="{{ $consumer_deploy_key }}">
                <button class="btn btn-info" type="submit">Gerar dhcpd.conf único (sem subnets - depuração)</button>
            </form>
        </div>

        <div>

            <br>
            <form action="/config" class="form-group" method="post">
                {{csrf_field()}}

                @include('config.partials.dhcp')
                <br>
                @include('config.partials.dhcp_sem_subnets')
                <br>

                <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Enviar Dados">
                </div>

            </form>
        </div>

@stop
