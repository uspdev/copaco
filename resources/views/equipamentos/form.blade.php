<div class="form-group">
  <div class="row">
    <div class="col-sm">
      <label for="patrimonio">Patrimônio</label>
      <input type="text" class="form-control" id="patrimonio" name="patrimonio" placeholder="008.0051544" value="{{ $equipamento->patrimonio ?? old('patrimonio') }}">
    </div>

    <div class="col-sm">
      <label  for="vencimento">Vencimento</label>
      <input type="text" class="form-control datepicker" name="vencimento" value="{{ $equipamento->vencimento ?? old('vencimento')  }}" autocomplete="off"> 
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
  </div>
</div>

<div class="form-group">
  <div class="row">

    <div class="col-sm">
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

    <div class="col-sm-4">
        <label class="col-form-label" for="ip"></label>
        <input type="text" class="form-control form-control-lg" id="ip" name="ip" value="{{ $equipamento->ip ?? old('ip')  }}" placeholder="Ex: 192.168.0.1">
        <small>Deixe em branco para atribuição de IP automática ou defina um manualmente IP</small>
    </div>
  </div>
</div>

<div class="form-group">
  <div class="row">
    <div class="col-sm">
      <label for="descricao">Descrição</label>
      <textarea class="form-control" id="descricao" name="descricao" rows="7">{{ $equipamento->descricao ?? old('descricao') }}</textarea>
    </div>
  </div>
</div>

<button type="submit" class="btn btn-primary">Enviar</button>

