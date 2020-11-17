<div class="form-group">
  <div class="row">
    <div class="col-sm">
      <label for="patrimonio">Patrimônio</label>
      <input type="text" class="form-control" id="patrimonio" name="patrimonio" placeholder="008.0051544" value="{{ $equipamento->patrimonio ?? old('patrimonio') }}">
    </div>

    <div class="col-sm">
      <label for="descricao">Descrição</label>
      <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Computador do Fulano" value="{{ $equipamento->descricao ?? old('descricao') }}">
    </div>

    <div class="col-sm">
      <label for="macaddress">Mac Address</label>
      <input type="text" class="form-control" id="macaddress" name="macaddress" placeholder="Ex: 00:45:8A:AA:90:88" value="{{ $equipamento->macaddress ?? old('macaddress') }}">
    </div>
  </div>
</div>

<div class="form-group">
  <div class="row">
    <div class="col-sm">
      <label for="local">Local</label>
      <input type="text" class="form-control" id="local" name="local" value="{{ $equipamento->local ?? old('local') }}" placeholder="Ex: Sala 10">
    </div>

    <div class="col-sm">
      <label  for="vencimento">Vencimento</label>
      <input type="text" class="form-control datepicker" name="vencimento" value="{{ $equipamento->vencimento ?? old('vencimento')  }}" autocomplete="off"> 
    </div>
  </div>
</div>

<div class="form-group">
    <label for="rede_id">Rede</label>
    <select name="rede_id" class="form-control">
        <option value="" selected="">Escolha uma Rede</option>
        @foreach($redes->sortBy('nome') as $rede)
            @if(old('rede_id')=='' and isset($equipamento->rede_id))
                <option value="{{ $rede->id }}" {{ ( $equipamento->rede_id == $rede->id) ? 'selected' : ''}}>
                    {{ $rede->nome }} | {{ $rede->iprede . '/' . $rede->cidr }}
                </option>                
            @else
                <option value="{{ $rede->id }}" {{ (old('rede_id') == $rede->id) ? 'selected' : ''}}>
                    {{ $rede->nome }} | {{ $rede->iprede . '/' . $rede->cidr }}
                </option>   
            @endif

        @endforeach()
    </select>
</div>

<div class="form-group">
    <label>Definir IP manualmente?</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="fixarip" id="check-fixarip-sim" value="1"
            @if (isset($equipamento->id) and ($equipamento->fixarip === 1))
                checked
            @elseif ((old('fixarip') != null) and (old('fixarip') == 1))
                checked
            @endif >
        <label class="form-check-label" for="check-fixarip-sim">Sim</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="fixarip" id="check-fixarip-nao" value="0"
            @if (isset($equipamento->id) and ($equipamento->fixarip === 0))
                checked
            @elseif ((old('fixarip') == null) and (!isset($equipamento->id)))
                checked
            @elseif ((old('fixarip') != null) and (old('fixarip') == 0))
                checked
            @endif >
        <label class="form-check-label" for="check-fixarip-nao">Não</label>
    </div>
</div>

<div class="form-group row" id="equipamento_ip"
    @if (isset($equipamento->id) and ($equipamento->fixarip === 0))
        hidden
    @elseif (((old('fixarip') == 0)) and (!isset($equipamento->id)))
        hidden
    @endif >
    <div class="col-sm-7">
        <label class="col-sm-2 col-form-label" for="ip">IP</label>
        <input type="text" class="form-control form-control-lg" id="ip" name="ip" value="{{ $equipamento->ip ?? old('ip')  }}" placeholder="Ex: 192.168.0.1">
    </div>
</div>


<button type="submit" class="btn btn-primary">Enviar</button>

