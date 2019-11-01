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
                <label for="dhcp_global">Opções para subnet do dhcp</label>

                @isset($rede->dhcpd_subnet_options)
                    <textarea rows="4" cols="50" class="form-control" name="dhcpd_subnet_options">{{ $rede->dhcpd_subnet_options ?? old('dhcpd_subnet_options') }}</textarea>
                @else
                    <textarea rows="4" cols="50" class="form-control" name="dhcpd_subnet_options">{{ "deny unknown-clients;" ?? old('dhcpd_subnet_options') }}</textarea>
                @endisset
            </div> 

            <div class="form-group">
                <label for="shared_network">shared-network</label>
                <select name="shared_network" class="form-control">
                    <option value="default" selected="">Escolha uma shared-network:</option>
                    @foreach($shared_networks as $shared_network)
                        @if(old('shared_network')=='' and isset($rede->shared_network))
                            <option value="{{ $shared_network }}" {{ ( $rede->shared_network == $shared_network) ? 'selected' : ''}}>
                                {{ $shared_network}}
                            </option>                
                        @else
                            <option value="{{ $shared_network }}" {{ (old('shared_network') == $shared_network) ? 'selected' : ''}}>
                                {{ $shared_network}}
                            </option>   
                        @endif

                    @endforeach()
                </select>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Enviar Dados">
            </div>

        </div>
    </div>
</div>
