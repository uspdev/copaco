@extends('master')

@section('content_header')
  <h1>Rede: {{ $rede->nome }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{action('RedeController@edit', $rede->id)}}" class="btn btn-success">Editar</a>
</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Rede</b>: {{ $rede->iprede }}/{{ $rede->cidr }}</li>
        <li class="list-group-item"><b>Gateway</b>: {{ $rede->gateway }}</li>
        <li class="list-group-item"><b>VLAN</b>: {{ $rede->vlan }}</li>

<div class="panel panel-default">
    <div class="panel-heading">Configurações Opcionais para DHCP</div>
        <div class="panel-body">
        <li class="list-group-item"><b>Netbios</b>: {{ $rede->netbios }}</li>
        <li class="list-group-item"><b>NTP</b>: {{ $rede->ntp }}</li>
        <li class="list-group-item"><b>DNS</b>: {{ $rede->dns }}</li>
        <li class="list-group-item"><b>Domain Active Directory</b>: {{ $rede->ad_domain }}</li>
        <li class="list-group-item"><b>Opções dhcp da subnet: </b>: {{ $rede->dhcpd_subnet_options }} </li>
        <li class="list-group-item"><b>shared_network</b>: {{ $rede->shared_network }}</li>
    </div>
</div>


    <li class="list-group-item"><b>Responsável</b>: {{ $rede->user->name }}</li>
        <li class="list-group-item"><b>Grupos com permissão nessa rede:</b>
            <ul>
                @foreach ( $rede->roles()->get() as $role)        
                    <li><a href="/roles/{{ $role->id }}"> {{ $role->nome }} </a></li>
                @endforeach
            </ul>
         </li>
    </ul>
</div>
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
      <th>{{ $equipamento->ip }}</th>
    </tr>
    @endforeach
  </tdoby>
</table>

<h2>Alterações nessa rede</h2>
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


