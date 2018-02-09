@extends('dashboard.master')

@section('content')
<h1>Cadastrar Equipamento</h1>

@include('messages.flash')
@include('messages.errors')

<form action="{{ url('equipamentos') }}" method="post">
    {{ csrf_field() }}

    <div class="form-group row">
      <label class="col-sm-1 col-form-label">Possui Patrimônio?</label>
        <div class="form-check form-check-inline">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="naopatrimoniado" id="check-sim" value="1" checked="checked"> Sim
          </label>
        </div>
        <div class="form-check form-check-inline">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="naopatrimoniado" id="check-nao" value="0"> Não
          </label>
        </div>
    </div>

    <div class="form-group row" id="sempatrimonio" hidden >
        <label class="col-sm-1 col-form-label" for="descricaosempatrimonio">Descrição para não patrimoniados</label>
        <div class="col-sm-7">
            <input name="descricaosempatrimonio">
        </div>
    </div>

    <div class="form-group row" id="compatrimonio">
        <label class="col-sm-1 col-form-label" for="patrimonio">Patrimônio</label>
        <div class="col-sm-7">
            <input name="patrimonio" required>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="macaddress">Mac Address</label>
        <div class="col-sm-7">
            <input type="text" class="form-control form-control-lg" id="macaddress" name="macaddress">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="local">Local</label>
        <div class="col-sm-7">
            <input type="text" class="form-control form-control-lg" id="local" name="local">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="vencimento">Vencimento</label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-lg" id="datepicker" name="vencimento">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="ip">IP</label>
        <div class="col-sm-7">
            <input type="text" class="form-control form-control-lg" id="ip" name="ip">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="rede_id">Rede</label>
        <div class="col-sm-7">
            <!-- <input name="rede_id"> -->
            <select name="rede_id">
                <option value="" selected="">Escolha uma Rede</option>
                
                @foreach($redes as $rede)
                
                    <option value="{{ $rede->id }}">
                        {{ $rede->nome }} | {{ $rede->iprede . '/' . $rede->cidr }}
                    </option>
                
                @endforeach()
                
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-0"></div>
        <input type="submit" class="btn btn-primary" value="Cadastrar Equipamento">
    </div>

</form>

@endsection
