@extends('master')

@section('content_header')
  <h1>Grupo:{{ $role->nome }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{action('App\Http\Controllers\RoleController@edit', $role->id)}}" class="btn btn-warning">Editar</a>
</div>
<br>

<div class="card">
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><b>Grupo</b>: {{ $role->nome }}</li>
            <li class="list-group-item"><b>Tipo</b>:
            @if($role->grupoadmin)
                Grupo administrativo
            @else
                Grupo comum
            @endif

            </li>
            <li class="list-group-item"><b>Pessoas</b>: 
                <ul>
                @foreach($role->users()->get() as $user)
                <li> <a href="/users/{{ $user->username }}">{{ $user->name }}</a></li>
                @endforeach
                </ul>
            </li>
            <li class="list-group-item"><b>Redes</b>: 
                <ul>
                @foreach($role->redes()->get() as $rede)
                <li> <a href="/redes/{{ $rede->id }}">{{ $rede->nome }}</a></li>
                @endforeach
                </ul>
            </li>
        </ul>
    </div>
</div>

@stop


