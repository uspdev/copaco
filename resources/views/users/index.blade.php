@extends('master')

@section('content_header')
    <h1>Pessoas</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<b>Nº de Usuários Cadastrados:</b> {{$users->count()}}
<br><br>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome de Usuário</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th colspan="1">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td><a href="/users/{{ $user->codpes }}">{{ $user->codpes }}</a></td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                <td>
                    <a href="{{action('App\Http\Controllers\UserController@edit', $user->codpes)}}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $users->appends(request()->query())->links() }}
@stop

