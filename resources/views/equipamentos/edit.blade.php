@extends('dashboard.master')

@section('content')
<h1>Editar Equipamento</h1>

@include('messages.flash')
@include('messages.errors')

<form action="{{ url('equipamentos'). '/' . $equipamento->id }}" method='post'>
    {{ csrf_field() }} {{ method_field('patch') }}
    
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="patrimoniado">Patrimoniado</label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-lg" id="patrimoniado" name="patrimoniado" value="{{ $equipamento->patrimoniado }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="patrimonio">Patrimônio</label>
        <div class="col-sm-7">
            <input type="text" class="form-control form-control-lg" id="patrimonio" name="patrimonio"  value="{{ $equipamento->patrimonio }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="macaddress">Mac Address</label>
        <div class="col-sm-7">
            <input type="text" class="form-control form-control-lg" id="macaddress" name="macaddress" value="{{ $equipamento->macaddress }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="local">Local</label>
        <div class="col-sm-7">
            <input type="text" class="form-control form-control-lg" id="local" name="local" value="{{ $equipamento->local }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="vencimento">Vencimento</label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-lg" id="datepicker" name="vencimento" value="{{ Carbon\Carbon::parse($equipamento->vencimento)->format('d/m/Y') }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="ip">IP</label>
        <div class="col-sm-7">
            <input type="text" class="form-control form-control-lg" id="ip" name="ip" value="{{ $equipamento->ip }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="rede_id">Rede</label>
        <div class="col-sm-7">
            <input type="text" class="form-control form-control-lg" id="rede_id" name="rede_id" value="{{ $equipamento->rede_id }}">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-0"></div>
        <input type="submit" class="btn btn-primary">
    </div>

</form>

@endsection
