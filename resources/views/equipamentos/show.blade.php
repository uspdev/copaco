@extends('master')

@section('content_header')
  <h1>Equipamento: {{ $equipamento->descricaosempatrimonio or $equipamento->patrimonio }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="card">
  <ul class="list-group list-group-flush">
    @if($equipamento->naopatrimoniado)
      <li class="list-group-item"> <b>Patrimônio:</b> {{$equipamento->patrimonio}}
        <br><i>Dados no mercúrio:</i>
        <ul>        
          <li>Material: {{ $info_patrimonio['Nomsgpitmmat'] }}</li>
          <li>Responsável: {{ $info_patrimonio['Nompes'] }}</li>
          <li>Centro de despesa: {{ $info_patrimonio['Nomcendsp'] }}</li>
          <li>Localização: {{ $info_patrimonio['Idfloc'] }}</li>
        </ul>
      </li>
    @else
      <li class="list-group-item"> <b>Descrição:</b> {{$equipamento->descricaosempatrimonio}} </li>
    @endif

    <li class="list-group-item"><b>Mac Address:</b> {{ $equipamento->macaddress }}</li>
    <li class="list-group-item"><b>Local:</b> {{ $equipamento->local }}</li>
    <li class="list-group-item"><b>Vencimento:</b> {{ \Carbon\Carbon::CreateFromFormat('Y-m-d', $equipamento->vencimento)->format('d/m/Y') }}</li>
    <li class="list-group-item"><b>Rede:</b> {{ $equipamento->rede->nome or '' }}</li>
    <li class="list-group-item"><b>IP:</b> {{ $equipamento->ip or '' }}</li>
    <li class="list-group-item"><b>Responsável</b>: {{ $equipamento->user->name }}</li>
    <li class="list-group-item"><b>Cadastrado em:</b> {{ \Carbon\Carbon::CreateFromFormat('Y-m-d H:i:s', $equipamento->created_at)->format('d/m/Y - H:i:s') }}</li>
    <li class="list-group-item"><b>Modificado em: </b> {{ \Carbon\Carbon::CreateFromFormat('Y-m-d H:i:s', $equipamento->updated_at)->format('d/m/Y - H:i:s') }}</li>
  </ul>
</div>

<div>
    <a href="{{ url()->previous() }}" class="btn btn-primary">Voltar</a>
</div>

<br>

<div>
    <a href="{{action('EquipamentoController@edit', $equipamento->id)}}" class="btn btn-warning">Editar</a>
</div>

<br>

<form action="{{action('EquipamentoController@destroy', $equipamento->id)}}" method="post">
    {{csrf_field()}} {{ method_field('delete') }}
    <button class="delete-item btn btn-danger" type="submit">Deletar</button>
</form>

@stop

