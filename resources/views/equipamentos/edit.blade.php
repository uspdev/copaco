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
        <label class="col-sm-1 col-form-label" for="patrimoniado">Patrimoniado</label>
        <div class="col-sm-7">
            <input name="patrimoniado" value="{{ $equipamento->patrimoniado }}">
        </div>
    </div>

    <div class="form-group row">
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
