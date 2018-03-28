@extends('dashboard.master')

@section('content')

<h3>Equipamento: {{ $equipamento->descricaosempatrimonio or $equipamento->patrimonio }} </h3>

<div class="card">
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><b>Patrimoniado:</b> {{ $equipamento->naopatrimoniado ? "Sim" : "Não" }}</li>
    <li class="list-group-item"><b>Mac Address:</b> {{ $equipamento->macaddress }}</li>
    <li class="list-group-item"><b>Local:</b> {{ $equipamento->local }}</li>
    <li class="list-group-item"><b>Vencimento:</b> {{ \Carbon\Carbon::CreateFromFormat('Y-m-d', $equipamento->vencimento)->format('d/m/Y') }}</li>
    <li class="list-group-item"><b>Rede:</b> {{ $equipamento->rede->nome }}</li>
    <li class="list-group-item"><b>IP:</b> {{ $equipamento->ip }}</li>
  </ul>
</div>

<hr>
<a href="{{ url()->previous() }}" class="btn btn-primary">Voltar</a>

@endsection

