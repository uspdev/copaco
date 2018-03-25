@extends('dashboard.master')

@section('content')

<h3>Rede: {{ $rede->nome }} </h3>

<div class="card">
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><b>rede</b>: {{ $rede->iprede }}/{{ $rede->cidr }}</li>
    <li class="list-group-item"><b>gateway</b>: {{ $rede->gateway }}</li>
    <li class="list-group-item"><b>ntp</b>: {{ $rede->ntp }}</li>
  </ul>
</div>

<hr>
<h4> Equipamentos alocados nesta rede: </h4>

<table class="table">
  <thead>
    <tr>
      <th scope="col">MacAddress</th>
      <th scope="col">IP</th>
    </tr>
  </thead>
  <tbody>
  @foreach($rede->equipamentos as $equipamento)
    <tr>
      <th><a href="/equipamentos/{{ $equipamento->id }}"> {{ $equipamento->macaddress}}</a></th>
      <th>{{ $equipamento->ip}}</th>
    </tr>
    @endforeach
  </tdoby>
</table>

@endsection


