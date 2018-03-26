<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" value="{{ $rede->nome or old('nome')  }}" required>
    <small class="form-text text-muted">Ex: Departamento de Música</small>
</div>

<div class="form-group">
    <label for="iprede">IP Rede</label>
    <input type="text" class="form-control" name="iprede" value="{{ $rede->iprede or old('iprede') }}" required>
    <small class="form-text text-muted">Ex: 143.107.75.0</small>
</div>

<div class="form-group">
    <label for="cidr">Cidr</label>
    <input type="text" class="form-control" name="cidr" value="{{ $rede->cidr or old('cidr') }}" required>
    <small class="form-text text-muted">Ex: 29</small>
</div>

<div class="form-group">
    <label for="gateway">Gateway</label>
    <input type="text" class="form-control" name="gateway" value="{{ $rede->gateway or old('gateway') }}" required>
    <small class="form-text text-muted">Ex: 143.107.75.1</small>
</div>

<div class="form-group">
    <label for="netbios">Netbios</label>
    <input type="text" class="form-control" name="netbios" value="{{ $rede->netbios or old('netbios') }}">
    <small class="form-text text-muted">Ex: ad.eca.usp.br</small>
</div>

<div class="form-group">
    <label for="ntp">NTP</label>
    <input type="text" class="form-control" name="ntp" value="{{ $rede->ntp or old('ntp') }}">
    <small class="form-text text-muted">Ex: ntp.usp.br</small>
</div>


 <div class="form-group">
    <label for="vlan">VLAN</label>
    <input type="text" class="form-control" name="vlan" value="{{ $rede->vlan or old('vlan') }}">
    <small class="form-text text-muted">Ex: 1587</small>
</div>

<div class="form-group">
    <label for="dns">DNS</label>
    <input type="text" class="form-control" name="dns" value="{{ $rede->dns or old('dns') }}">
    <small class="form-text text-muted">Ex: 143.107.253.3, 143.107.253.5</small>
</div>


<div class="form-group row">
    <div class="col-md-0"></div>
    <input type="submit" class="btn btn-primary">
</div>
