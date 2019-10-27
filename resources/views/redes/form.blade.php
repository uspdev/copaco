<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" value="{{ $rede->nome ?? old('nome')  }}" placeholder="Ex: Departamento de Música" required >
</div>

<div class="form-group">
    <label for="iprede">IP Rede</label>
    <input type="text" class="form-control" name="iprede" value="{{ $rede->iprede ?? old('iprede') }}" placeholder="Ex: 143.107.75.0" required >
</div>

<div class="form-group">
    <label for="cidr">Cidr</label>
    <input type="text" class="form-control" name="cidr" value="{{ $rede->cidr ?? old('cidr') }}" placeholder="Ex: 29" required >
</div>

<div class="form-group">
    <label for="gateway">Gateway</label>
    <input type="text" class="form-control" name="gateway" value="{{ $rede->gateway ?? old('gateway') }}" placeholder="Ex: 143.107.75.1" required >
</div>

<div class="form-group">
    <label for="vlan">VLAN</label>
    <input type="text" class="form-control" name="vlan" value="{{ $rede->vlan ?? old('vlan') }}" placeholder="Ex: 1587">
</div>

<div class="panel panel-default">
    <div class="panel-heading">Configurações Opcionais para DHCP</div>
        <div class="panel-body">
            <div class="form-group">
                <label for="netbios">Netbios</label>
                <input type="text" class="form-control" name="netbios" value="{{ $rede->netbios ?? old('netbios') }}" placeholder="Ex: 10.0.0.4, 10.3.3.2">
            </div>

            <div class="form-group">
                <label for="ntp">NTP</label>
                <input type="text" class="form-control" name="ntp" value="{{ $rede->ntp ?? old('ntp') }}" placeholder="Ex: 143.107.40.8, 172.16.0.28">
            </div>

            <div class="form-group">
                <label for="dns">DNS</label>
                <input type="text" class="form-control" name="dns" value="{{ $rede->dns ?? old('dns') }}" placeholder="Ex: 143.107.253.3, 143.107.253.3">
            </div>

            <div class="form-group">
                <label for="ad_domain">Domain Active Directory</label>
                <input type="text" class="form-control" name="ad_domain" value="{{ $rede->ad_domain ?? old('ad_domain') }}"placeholder="Ex: mydomain.usp.br">
            </div>

            <div class="form-group">
                <label for="unknown_clients">Entregar IP para hosts desconhecidos? (allow unknown-clients)</label>
                <input type="checkbox" class="" name="unknown_clients" value="1"
                @if (isset($rede->id) and ($rede->unknown_clients === 1))
                    checked
                @elseif (old('unknown_clients') == 1)
                    checked
                @endif >
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Enviar Dados">
            </div>
        </div>
    </div>
</div>
