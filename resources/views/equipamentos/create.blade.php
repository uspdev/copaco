@extends('dashboard.master')

@section('content')
<h1>Cadastrar Equipamento</h1>

@include('messages.flash')
@include('messages.errors')

<div class="row">
    <div class="col-lg-4">
        <form action="{{ url('equipamentos') }}" method="post">
        {{ csrf_field() }}
            <!-- Radios... -->
            <div class="form-group">
                <label>Possui Patrimônio?</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="naopatrimoniado" id="check-sim" value="1" checked="checked">
                    <label class="form-check-label" for="naopatrimoniado">Sim</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="naopatrimoniado" id="check-nao" value="0">
                    <label class="form-check-label" for="naopatrimoniado">Não</label>
                </div>
            </div>

            <div class="form-group" id="compatrimonio">
                <label for="patrimonio">Patrimônio</label>
                <input name="patrimonio" type="text" class="form-control" required>
            </div>

            <div class="form-group" id="sempatrimonio" hidden>
                <label for="descricaosempatrimonio">Descrição para não patrimoniados</label>
                <input name="descricaosempatrimonio" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label for="macaddress">Mac Address</label>
                <input type="text" class="form-control" id="macaddress" name="macaddress">
            </div>

            <div class="form-group">
                <label for="local">Local</label>
                <input type="text" class="form-control" id="local" name="local">
            </div>

            <div class="form-group">
                <label  for="vencimento">Vencimento</label>
                <input type="text" class="form-control" id="datepicker" name="vencimento">
            </div>
            
            <div class="form-group">
                <label for="rede_id">Rede</label>
                    <select name="rede_id" class="form-control">
                        <option value="" selected="">Escolha uma Rede</option>
                        @foreach($redes as $rede)
                        
                            <option value="{{ $rede->id }}">
                                {{ $rede->nome }} | {{ $rede->iprede . '/' . $rede->cidr }}
                            </option>
                        
                        @endforeach()
                    </select>
            </div>
            <div class="form-group">
                <label>Fixar IP?</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="fixarip" id="check-fixarip-sim" value="1">
                    <label class="form-check-label" for="fixarip">Sim</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="fixarip" id="check-fixarip-nao" value="0" checked="checked">
                    <label class="form-check-label" for="fixarip">Não</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Equipamento</button>
    
        </form>
    </div>
</div>


@endsection
