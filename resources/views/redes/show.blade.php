@extends('dashboard.master')

@section('content')

<h3>Rede: {{ $rede->nome }} </h3>

<div class="card">
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><b>Rede</b>: {{ $rede->iprede }}/{{ $rede->cidr }}</li>
    <li class="list-group-item"><b>Gateway</b>: {{ $rede->gateway }}</li>
    <li class="list-group-item"><b>DNS</b>: {{ $rede->dns }}</li>
    <li class="list-group-item"><b>VLAN</b>: {{ $rede->vlan }}</li>
    <li class="list-group-item"><b>Domain Active Directory</b>: {{ $rede->ad_domain }}</li>
    <li class="list-group-item"><b>NTP</b>: {{ $rede->ntp }}</li>
    <li class="list-group-item"><b>Netbios</b>: {{ $rede->netbios }}</li>
    <li class="list-group-item"><b>Cadastrado por:</b> {{ $rede->user_id }} em {{ $rede->created_at }}</li>
    <li class="list-group-item"><b>Modificado por:</b> {{ $rede->last_modify_by }} em {{ $rede->updated_at }}</li>

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


