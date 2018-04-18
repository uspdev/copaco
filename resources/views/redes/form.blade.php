<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" value="{{ $rede->nome or old('nome')  }}" placeholder="Ex: Departamento de Música" required >
</div>

<div class="form-group">
    <label for="iprede">IP Rede</label>
    <input type="text" class="form-control" name="iprede" value="{{ $rede->iprede or old('iprede') }}" placeholder="Ex: 143.107.75.0" required >
</div>

<div class="form-group">
    <label for="cidr">Cidr</label>
    <input type="text" class="form-control" name="cidr" value="{{ $rede->cidr or old('cidr') }}" placeholder="Ex: 29" required >
</div>

<div class="form-group">
    <label for="gateway">Gateway</label>
    <input type="text" class="form-control" name="gateway" value="{{ $rede->gateway or old('gateway') }}" placeholder="Ex: 143.107.75.1" required >
</div>

<div class="form-group">
    <label for="netbios">Netbios</label>
    <input type="text" class="form-control" name="netbios" value="{{ $rede->netbios or old('netbios') }}" placeholder="Ex: ad.eca.usp.br">
</div>

<div class="form-group">
    <label for="ntp">NTP</label>
    <input type="text" class="form-control" name="ntp" value="{{ $rede->ntp or old('ntp') }}" placeholder="Ex: ntp.usp.br">
</div>


 <div class="form-group">
    <label for="vlan">VLAN</label>
    <input type="text" class="form-control" name="vlan" value="{{ $rede->vlan or old('vlan') }}" placeholder="Ex: 1587">
</div>

<div class="form-group">
    <label for="dns">DNS</label>
    <input type="text" class="form-control" name="dns" value="{{ $rede->dns or old('dns') }}" placeholder="Ex: 143.107.253.3, 143.107.253.5">
</div>

<div class="form-group">
    <label for="ad_domain">Domain Active Directory</label>
    <input type="text" class="form-control" name="ad_domain" value="{{ $rede->ad_domain or old('ad_domain') }}"placeholder="mydomain.usp.br">
</div>

<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Enviar Dados">
</div>
