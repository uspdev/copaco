<div class="form-group">
    <label>Possui Patrimônio?</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="naopatrimoniado" id="check-sim" value="1"
            @if (isset($equipamento->id) and ($equipamento->naopatrimoniado === 1))
                checked
            @elseif ((old('naopatrimoniado') == null) or (old('naopatrimoniado') == 1))
                checked 
            @endif >
        <label class="form-check-label" for="check-sim">Sim</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="naopatrimoniado" id="check-nao" value="0"
            @if (isset($equipamento->id) and ($equipamento->naopatrimoniado === 0))
                checked
            @elseif ((old('naopatrimoniado') != null) and (old('naopatrimoniado') == 0))
                checked 
            @endif >
        <label class="form-check-label" for="check-nao">Não</label>
    </div>
</div>

<div class="form-group" id="compatrimonio"
    @if (isset($equipamento->id) and ($equipamento->naopatrimoniado === 0))
        hidden
    @elseif ((old('naopatrimoniado') != null) and (old('naopatrimoniado') == 0))
        hidden
    @endif >
    <label for="patrimonio">Patrimônio</label>
    <input name="patrimonio" type="text" class="form-control" value="{{ $equipamento->patrimonio or old('patrimonio') }}" placeholder="Ex: 001.586985"
        @if (isset($equipamento->id) and ($equipamento->naopatrimoniado === 1))
            required
        @elseif (((old('naopatrimoniado') == null) or (old('naopatrimoniado') == 1)) and (!isset($equipamento->id)))
            required
        @endif >
</div>

<div class="form-group" id="sempatrimonio"
    @if (isset($equipamento->id) and ($equipamento->naopatrimoniado === 1))
        hidden
    @elseif (((old('naopatrimoniado') == null) or (old('naopatrimoniado') == 1)) and (!isset($equipamento->id)))
        hidden
    @endif >
    <label for="descricaosempatrimonio">Descrição para não patrimoniados</label>
    <input name="descricaosempatrimonio" type="text" class="form-control"
        value="{{ $equipamento->descricaosempatrimonio or old('descricaosempatrimonio') }}" placeholder="Ex: Professor visitante Joãozinho"
        @if (isset($equipamento->id) and ($equipamento->naopatrimoniado === 0))
            required
        @elseif ((old('naopatrimoniado') != null) and (old('naopatrimoniado') == 0))
            required
        @endif >
</div>

<div class="form-group">
    <label for="macaddress">Mac Address</label>
    <input type="text" class="form-control" id="macaddress" name="macaddress" placeholder="Ex: 00:45:8A:AA:90:88" 
           value="{{ $equipamento->macaddress or old('macaddress') }}">
</div>

<div class="form-group">
    <label for="local">Local</label>
    <input type="text" class="form-control" id="local" name="local" value="{{ $equipamento->local or old('local') }}" placeholder="Ex: Sala 10">
</div>

<div class="form-group">
    <label  for="vencimento">Vencimento</label>
    <input type="text" class="form-control" id="datepicker" name="vencimento" 
           value="{{ $equipamento->vencimento or old('vencimento')  }}">
</div>

<div class="form-group">
    <label for="rede_id">Rede</label>
    <select name="rede_id" class="form-control">
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
        <input class="form-check-input" type="radio" name="fixarip" id="check-fixarip-sim" value="1"
            @if (isset($equipamento->id) and ($equipamento->fixarip === 1))
                checked
            @endif >
        <label class="form-check-label" for="check-fixarip-sim">Sim</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="fixarip" id="check-fixarip-nao" value="0"
            @if (isset($equipamento->id) and ($equipamento->fixarip === 0))
                checked
            @elseif ((old('fixarip') != null) and (old('fixarip') == 0))
                checked
            @endif >
        <label class="form-check-label" for="check-fixarip-nao">Não</label>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="ip">IP</label>
    <div class="col-sm-7">
        <input type="text" class="form-control form-control-lg" id="ip" name="ip" value="{{ $equipamento->ip or old('ip')  }}" placeholder="Ex: 192.168.0.1">
    </div>
</div>


<button type="submit" class="btn btn-primary">Enviar</button>

