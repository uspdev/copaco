@extends('adminlte::page')

@section('content_header')
    <h1>Pessoas</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>nome</th>
                <th>email</th>
                <th>método de autenticação</th>
                <th>grupos</th>
                <th colspan="1">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td><a href="/users/{{ $user->id }}">{{ $user->id }}</a></td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <ul>
                        @if($user->username_senhaunica)
                            <li> <i>Senha Única </i>-  Número USP: {{$user->username_senhaunica}}</li>
                        @endif
                        @if($user->username_ldap)
                            <li>ldap</li>
                        @endif
                    </ul>
                </td>
                <td>
                    <ul>
                    @forelse ( $user->roles()->get() as $role)        
                        <li><a href="/roles/{{ $role->id }}"> {{ $role->nome }} </a></li>
                    @empty
                        <li>Sem grupo</li>
                    @endforelse
                    </ul>
                </td>

                <td>
                    <a href="{{action('UserController@edit', $user->id)}}" class="btn btn-warning">Editar</a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop

