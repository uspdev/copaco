<div class="card">
    <div class="card-header">Configurações para DHCP</div>
    <div class="card-body">
        <small class="form-text text-muted">
            Essa é uma configuração extra caso seja necessário subir um servidor dhcp de emergência com todos
            Mac-Address cadastrados nesse sistema em um rede especifíca definida aqui. Neste caso todos IPs 
            alocados para cada Mac-Address no sistema serão ignorados e o sistema definirá aleatóriamente IPs.
            Foi criar essa opção para depuração e para possíveis situações de desastre.
        </small>
        <br>
        <div class="row form-group">
            <div class="col-sm form-group">

                <label for="iprede">IP Rede</label>

                @if(!is_null($configs->where('key','unique_iprede')->first()))
                    <input type="text" class="form-control" name="unique_iprede" value="{{$configs->where('key','unique_iprede')->first()->value}}">
                @else
                    <input type="text" class="form-control" name="unique_iprede">
                @endif
            </div>

            <div class="col-smform-group">
                <label for="gateway">Gateway</label>

                @if(!is_null($configs->where('key','unique_gateway')->first()))
                    <input type="text" class="form-control" name="unique_gateway" value="{{$configs->where('key','unique_gateway')->first()->value}}">
                @else
                    <input type="text" class="form-control" name="unique_gateway">
                @endif

            </div>

            <div class="col-sm form-group">
                <label for="cidr">Cidr</label>

                @if(!is_null($configs->where('key','unique_cidr')->first()))
                    <input type="text" class="form-control" name="unique_cidr" value="{{$configs->where('key','unique_cidr')->first()->value}}">
                @else
                    <input type="text" class="form-control" name="unique_cidr">
                @endif

            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm form-group">
                <label for="ips_reservados">IPs reservados desta rede (separados por vírgula)</label>

                @if(!is_null($configs->where('key','ips_reservados')->first()))
                    <input type="text" class="form-control" name="ips_reservados" value="{{$configs->where('key','ips_reservados')->first()->value}}">
                @else
                    <input type="text" class="form-control" name="ips_reservados">
                @endif
            </div>
        </div>
        <small class="form-text text-muted">Caso queira também gerar um dhcpd.conf sem segmentação de rede
        preencha os dados dessa única rede</small>
        <br>

    </div>
</div>