@extends('dashboard.master')

@section('content')
<h1>Cadastrar Equipamento</h1>

@include('messages.flash')
@include('messages.errors')

<form action="{{ url('equipamentos') }}" method="post">
    {{ csrf_field() }}

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="patrimoniado">Patrimoniado</label>
        <div class="col-sm-7">
            <input name="patrimoniado">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="patrimonio">Patrimônio</label>
        <div class="col-sm-7">
            <input name="patrimonio">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="macaddress">Mac Address</label>
        <div class="col-sm-7">
            <input name="macaddress">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="local">Local</label>
        <div class="col-sm-7">
            <input name="local">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="vencimento">Vencimento</label>
        <div class="col-sm-7">
            <input name="vencimento" id="datepicker">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="ip">IP</label>
        <div class="col-sm-7">
            <input name="ip">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="rede_id">Rede</label>
        <div class="col-sm-7">
            <input name="rede_id">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-0"></div>
        <input type="submit" class="btn btn-primary">
    </div>

</form>

@endsection
