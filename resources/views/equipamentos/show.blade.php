@extends('master')

@section('content_header')
  <h1>Equipamento: {{ $equipamento->descricaosempatrimonio ?? $equipamento->patrimonio }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="card">
  <ul class="list-group list-group-flush">
    @if($equipamento->naopatrimoniado)
      <li class="list-group-item"> <b>Patrimônio:</b> {{$equipamento->patrimonio}}
{{--
        <br><i>Dados no mercúrio:</i>
        <ul>        
          <li>Material: {{ $info_patrimonio['Nomsgpitmmat'] }}</li>
          <li>Responsável: {{ $info_patrimonio['Nompes'] }}</li>
          <li>Centro de despesa: {{ $info_patrimonio['Nomcendsp'] }}</li>
          <li>Localização: {{ $info_patrimonio['Idfloc'] }}</li>
        </ul>
      </li>
--}}
    @else
      <li class="list-group-item"> <b>Descrição:</b> {{$equipamento->descricaosempatrimonio}} </li>
    @endif

    <li class="list-group-item"><b>Mac Address:</b> {{ $equipamento->macaddress }}</li>
    <li class="list-group-item"><b>Local:</b> {{ $equipamento->local }}</li>
    <li class="list-group-item"><b>Vencimento:</b> {{ \Carbon\Carbon::CreateFromFormat('Y-m-d', $equipamento->vencimento)->format('d/m/Y') }}</li>
    <li class="list-group-item"><b>Rede:</b> {{ $equipamento->rede->nome ?? '' }}</li>
    <li class="list-group-item"><b>IP:</b> {{ $equipamento->ip ?? '' }}</li>
    <li class="list-group-item"><b>Responsável</b>: {{ $equipamento->user->name }}</li>

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

<h2>Alterações nesse equipamento</h2>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Data</th>
      <th scope="col">Usuário(a)</th>
    </tr>
  </thead>
  <tbody>
  @foreach($changes as $change)
    <tr>
      <th> {{ $change['when'] }} </th>
      <th> {{ $change['username'] }} - {{ $change['name'] }}</th>
    </tr>
    @endforeach
  </tdoby>
</table>

@stop

