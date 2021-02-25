<div class="card">
    <div class="card-header">Configurações para DHCP</div>
    <div class="card-body">
        <div class="row form-group">
            <div class="col-sm form-group">
                <label for="dhcp_global">Parâmetros globais</label>
                @if(!is_null($configs->where('key','dhcp_global')->first()))
                    <textarea rows="4" cols="50" class="form-control" name="dhcp_global">{{$configs->where('key','dhcp_global')->first()->value}}</textarea>
                @else
                    <textarea rows="4" cols="50" class="form-control" name="dhcp_global">
                        ddns-update-style none;
                        default-lease-time 86400;
                        max-lease-time 86400;
                        authoritative;
                    </textarea>
                @endif
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm form-group">
                <label for="dhcp_global">shared-networks (além da default):</label>
                @if(!is_null($configs->where('key','shared_network')->first()))
                    <input class="form-control" name="shared_network" value="{{$configs->where('key','shared_network')->first()->value}}">
                @else
                    <input class="form-control" name="shared_network">
                @endif
                <small id="emailHelp" class="form-text text-muted">Por padrão todas subnet são agrupadas em 
                    uma mesma shared-network chamada default. Esta opção serve para criar outras shared-network.
                    Use vírgula para separar as shared-networks. 
                    Exemplo: labs, externos 
                </small>
            </div>
        </div>

    </div>
</div>
