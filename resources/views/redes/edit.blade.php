@extends('dashboard.master')

@section('content')
<h1>Editar Rede</h1>

@include('messages.flash')
@include('messages.errors')
<div class="row">
    <div class="col-lg-3">
        <form method="post" action="{{ action('RedeController@update', $rede->id) }}">
            {{csrf_field()}}
            {{method_field('patch')}}
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" value="{{ $rede->nome }}">
            </div>
            <div class="form-group">
                <label for="iprede">IP Rede</label>
                <input type="text" class="form-control" name="iprede" value="{{ $rede->iprede }}">
            </div>

            <div class="form-group">
                <label for="cidr">Cidr</label>
                <input type="text" class="form-control" name="cidr" value="{{ $rede->cidr }}">
            </div>

            <div class="form-group">
                <label for="gateway">Gateway</label>
                <input type="text" class="form-control" name="gateway" value="{{ $rede->gateway }}">
            </div>

            <div class="form-group">
                <label for="netbios">Netbios</label>
                <input type="text" class="form-control" name="netbios" value="{{ $rede->netbios }}">
            </div>

            <div class="form-group">
                <label for="ntp">NTP</label>
                <input type="text" class="form-control" name="ntp" value="{{ $rede->ntp }}">
            </div>

                <div class="form-group">
                <label for="vlan">VLAN</label>
                <input type="text" class="form-control" name="vlan" value="{{ $rede->vlan }}">
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Rede</button>
        </form>
    </div>
</div>


@endsection
