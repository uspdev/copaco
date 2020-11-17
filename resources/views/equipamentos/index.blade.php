@extends('master')

@section('content_header')
    <h1>Cadastrar Equipamento</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="row">
    <div class="col-sm float-left">
        <a href="{{ route('equipamentos.create') }}" class="btn btn-success">
            Adicionar Equipamento
        </a>
    </div>
    <div class="col-auto float-right">
        <a href="/excel?vencidos={{ request()->vencidos }}&naoalocados={{ request()->naoalocados }}&rede={{ request()->rede }}&rede_id={{ request()->rede_id }}&search={{ request()->search }}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Exportar para Excel</a>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header">Filtros</div>
    <div class="card-body">
        <form method="get" action="/equipamentos">
            <div>
                <label class="checkbox-inline"><input type="checkbox" name="vencidos" value="true" @if(Request()->vencidos == 'true') checked @endif> Vencidos</label>
                <label class="checkbox-inline"><input type="checkbox" name="naoalocados" value="true" @if(Request()->naoalocados == 'true') checked @endif> Não Alocados</label>
                <select name="rede_id" class="form-control-sm" id="rede_id">
                    <option value="" selected="">Escolha uma Rede</option>
                    @foreach($redes->sortBy('nome') as $rede)
                        @if(old('rede_id')=='' and isset($equipamento->rede_id))
                            <option value="{{ $rede->id }}" {{ ( $equipamento->rede_id == $rede->id) ? 'selected' : ''}}>
                                {{ $rede->nome }} | {{ $rede->iprede . '/' . $rede->cidr }}
                            </option>                
                        @else
                            <option value="{{ $rede->id }}" {{ (Request()->rede_id == $rede->id) ? 'selected' : ''}}>
                                {{ $rede->nome }} | {{ $rede->iprede . '/' . $rede->cidr }}
                            </option>   
                        @endif
                    @endforeach()
                </select>
            </div>
            <br>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Patrimônio, Mac Address, IP, Local ou descrição" value="{{ Request()->search}}" name="search">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success"> Buscar </button>
                </span>
            </div><!-- /input-group -->
        </form>
    </div>
</div>

<br>
<b>Nº de Equipamentos Cadastrados:</b> {{$equipamentos->count()}}
<br><br>
    {{ $equipamentos->appends(request()->query())->links() }}
<br>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>MAC Address</th>
                <th>Patrimônio</th>
                <th>Descrição</th>
                <th>IP</th>
                <th>Rede</th>
                <th>Vencimento</th>
                <th>Responsável</th>
                <th colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipamentos as $equipamento)
            <tr>
                <td><a href="/equipamentos/{{ $equipamento->id }}"> {{ $equipamento->macaddress }}</a></td>
                <td>{{ $equipamento->patrimonio }}</td>
                <td>{{ $equipamento->descricao }}</td>
                <td>{{ $equipamento->ip ?? '' }}</td>
                <td><i>{{ $equipamento->rede->nome ?? '' }}</i>
                    @isset ($equipamento->rede->iprede)
                        @can('admin')
                            <a href="/redes/{{$equipamento->rede->id}}">{{ $equipamento->rede->iprede ?? '' }}/{{ $equipamento->rede->cidr ?? '' }}</a>
                        @elsecannot('admin')
                            {{ $equipamento->rede->iprede ?? '' }}/{{ $equipamento->rede->cidr ?? '' }}
                        @endcan
                    @endisset
                </td>

                <td>{{ \Carbon\Carbon::CreateFromFormat('Y-m-d', $equipamento->vencimento)->format('d/m/Y') }}</td>

                <td>
                    @can('admin')
                        <a href="/users/{{$equipamento->user->username}}">{{ $equipamento->user->name ?? '' }}</a>
                    @elsecannot('admin')
                        {{ $equipamento->user->name ?? '' }}
                    @endcan
                </td>

                <td>
                    <a href="{{action('App\Http\Controllers\EquipamentoController@edit', $equipamento->id)}}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                </td>
                <td>
                    <form action="{{action('App\Http\Controllers\EquipamentoController@destroy', $equipamento->id)}}" method="post">
                      {{csrf_field()}} {{ method_field('delete') }}
                      <button class="delete-item btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                  </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $equipamentos->appends(request()->query())->links() }}
</div>

@stop
