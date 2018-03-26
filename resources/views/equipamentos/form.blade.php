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
    <input name="patrimonio" type="text" class="form-control" value="{{ $equipamento->patrimonio or old('patrimonio') }}" required>
    <small class="form-text text-muted">Ex: 001.586985</small>
</div>

<div class="form-group" id="sempatrimonio" hidden>
    <label for="descricaosempatrimonio">Descrição para não patrimoniados</label>
    <input name="descricaosempatrimonio" type="text" class="form-control" 
           value="{{ $equipamento->descricaosempatrimonio or old('descricaosempatrimonio') }}">
    <small class="form-text text-muted">Ex: Professor visitante Joãozinho</small>
</div>

<div class="form-group">
    <label for="macaddress">Mac Address</label>
    <input type="text" class="form-control" id="macaddress" name="macaddress" 
           value="{{ $equipamento->macaddress or old('macaddress') }}">
    <small class="form-text text-muted">Ex: 00:45:8A:AA:90:88</small>
</div>

<div class="form-group">
    <label for="local">Local</label>
    <input type="text" class="form-control" id="local" name="local" value="{{ $equipamento->local or old('local') }}">
    <small class="form-text text-muted">Ex: Sala 10</small>
</div>

<div class="form-group">
    <label  for="vencimento">Vencimento</label>
    <input type="text" class="form-control" id="datepicker" name="vencimento" 
           value="{{ $equipamento->vencimento or old('vencimento')  }}">
</div>

<div class="form-group">
    <label for="rede_id">Rede</label>
    <select name="rede_id" class="form-control" required>
        <option value="" selected="">Escolha uma Rede</option>
        @foreach($redes as $rede)
            <option value="{{ $rede->id }}" {{ $equipamento->rede_id or old('rede_id') == $rede->id ? 'selected' : ''}}>
                {{ $rede->nome }} | {{ $rede->iprede . '/' . $rede->cidr }}
            </option>
        @endforeach()
    </select>
</div>

<div class="form-group">
    <label>Definir IP manualmente?</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="fixarip" id="check-fixarip-sim" value="1">
        <label class="form-check-label" for="fixarip">Sim</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="fixarip" id="check-fixarip-nao" value="0" checked="checked">
        <label class="form-check-label" for="fixarip">Não</label>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="ip">IP</label>
    <div class="col-sm-7">
        <input type="text" class="form-control form-control-lg" id="ip" name="ip" value="{{ $equipamento->ip or old('ip')  }}">
    </div>
</div>


<button type="submit" class="btn btn-primary">Enviar</button>

