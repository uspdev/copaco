@extends('dashboard.master')

@section('content')
<h1>Cadastrar Rede</h1>

@include('messages.flash')
@include('messages.errors')
<div class="row">
    <div class="col-lg-3">
        <form method="post" action="{{ url('redes') }}">
            {{csrf_field()}}
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" value="{{ old('nome') }}">
            </div>

            <div class="form-group">
                <label for="iprede">IP Rede</label>
                <input type="text" class="form-control" name="iprede" value="{{ old('iprede') }}">
            </div>

            <div class="form-group">
                <label for="cidr">Cidr</label>
                <input type="text" class="form-control" name="cidr" value="{{ old('cidr') }}">
            </div>

            <div class="form-group">
                <label for="gateway">Gateway</label>
                <input type="text" class="form-control" name="gateway" value="{{ old('gateway') }}">
            </div>

            <div class="form-group">
                <label for="netbios">Netbios</label>
                <input type="text" class="form-control" name="netbios" value="{{ old('netbios') }}">
            </div>

            <div class="form-group">
                <label for="ntp">NTP</label>
                <input type="text" class="form-control" name="ntp" value="{{ old('ntp') }}">
            </div>

             <div class="form-group">
                <label for="vlan">VLAN</label>
                <input type="text" class="form-control" name="vlan" value="{{ old('vlan') }}">
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar Rede</button>
        </form>
    </div>
</div>

@endsection
