@extends('dashboard.master')

@section('content')
<h1>Cadastrar Rede</h1>

@include('messages.flash')
@include('messages.errors')

<form method="post" action="{{ url('redes') }}">
    {{csrf_field()}}
    <div class="form-group row">
        <label class="col-sm-1  col-form-label" for="nome">Nome</label>
        <div class="col-sm-7">
            <input type="text" name="nome" value="{{ old('nome') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-1  col-form-label" for="iprede">IP Rede</label>
        <div class="col-sm-7">
            <input type="text" name="iprede" value="{{ old('iprede') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-1  col-form-label" for="gateway">Gateway</label>
        <div class="col-sm-7">
            <input type="text" name="gateway" value="{{ old('gateway') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-1  col-form-label" for="cidr">Cidr</label>
        <div class="col-sm-7">
            <input type="text" name="cidr" value="{{ old('cidr') }}">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-0"></div>
        <input type="submit" class="btn btn-primary">
    </div>
</form>

@endsection
