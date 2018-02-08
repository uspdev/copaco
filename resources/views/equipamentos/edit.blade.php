@extends('dashboard.master')

@section('content')
<h1>Editar Equipamento</h1>

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))

    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="fechar">&times;</a></p>
    @endif
    @endforeach
</div> <!-- end .flash-message -->

<form action="{{ url('equipamentos'). '/' . $equipamento->id }}" method='post'>
    {{ csrf_field() }} {{ method_field('patch') }}

    <div class="form-group row">
      <label class="col-sm-1 col-form-label">Possui Patrimônio?</label>
        <div class="form-check form-check-inline">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="naopatrimoniado" id="check-sim" value="1" @if ($equipamento->naopatrimoniado === 1) checked="checked" @endif > Sim
          </label>
        </div>
        <div class="form-check form-check-inline">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="naopatrimoniado" id="check-nao" value="0" @if ($equipamento->naopatrimoniado === 0) checked="checked" @endif > Não
          </label>
        </div>
    </div>

    <div class="form-group row" id="sempatrimonio" @if ($equipamento->naopatrimoniado === 1) hidden @endif >
        <label class="col-sm-1 col-form-label" for="descricaosempatrimonio">Descrição para não patrimoniados</label>
        <div class="col-sm-7">
            <input name="descricaosempatrimonio" value="{{ $equipamento->descricaosempatrimonio }}">
        </div>
    </div>

    <div class="form-group row" id="compatrimonio" @if ($equipamento->naopatrimoniado === 0) hidden @endif >
        <label class="col-sm-1 col-form-label" for="patrimonio">Patrimônio</label>
            <div class="col-sm-7">
            <input name="patrimonio" value="{{ $equipamento->patrimonio }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="macaddress">Mac Address</label>
        <div class="col-sm-7">
            <input name="macaddress" value="{{ $equipamento->macaddress }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="local">Local</label>
        <div class="col-sm-7">
            <input name="local" value="{{ $equipamento->local }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="vencimento">Vencimento</label>
        <div class="col-sm-7">
            <input name="vencimento" value="{{ $equipamento->vencimento }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="ip">IP</label>
        <div class="col-sm-7">
            <input name="ip" value="{{ $equipamento->ip }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="rede_id">Rede</label>
        <div class="col-sm-7">
            <input name="rede_id" value="{{ $equipamento->rede_id }}">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-0"></div>
        <input type="submit" class="btn btn-primary">
    </div>

</form>

@endsection
