@extends('dashboard.master')

@section('content')
<h1>Cadastrar Equipamento</h1>

@include('messages.flash')
 
<p>
    <a href="{{ route('equipamentos.create') }}" class="btn btn-success">
        Adicionar Equipamento
    </a>
</p>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>MAC Address</th>
                <th>Data de Vencimento</th>
                <th colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipamentos as $equipamento)
            <tr>
                <td>{{ $equipamento->macaddress }}</td>
                <td>{{ Carbon\Carbon::parse($equipamento->vencimento)->format('d/m/Y') }}</td>
                <td>
                    <a href="{{action('EquipamentoController@edit', $equipamento->id)}}" class="btn btn-warning">Editar</a>
                </td>
                <td>
                    <form action="{{action('EquipamentoController@destroy', $equipamento->id)}}" method="post">
                      {{csrf_field()}} {{ method_field('delete') }}
                      <button class="delete-item btn btn-danger" type="submit">Deletar</button>
                  </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
