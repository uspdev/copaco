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
        @foreach($redes->sortBy('nome', SORT_NATURAL|SORT_FLAG_CASE) as $rede)
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

<div class="form-group row">
    <div class="col-sm-7">
        <label class="col-form-label" for="ip">IP, deixe em branco para atribuição automática</label>
        <input type="text" class="form-control form-control-lg" id="ip" name="ip" value="{{ $equipamento->ip ?? old('ip')  }}" placeholder="Ex: 192.168.0.1">
    </div>
</div>


<button type="submit" class="btn btn-primary">Enviar</button>

