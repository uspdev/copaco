@extends('master')

@section('content_header')
    <h1>Cadastrar novo Grupo</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<a href="{{ route('roles.create') }}" class="btn btn-success">
    Adicionar Grupo
</a>
<br><br>
<b>Nº de Grupos Cadastrados:</b> {{$roles->count()}}
<br><br>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td><a href="/roles/{{ $role->id }}">{{ $role->nome }}</a></td>
                <td>
                    <a href="{{action('RoleController@edit', $role->id)}}" class="btn btn-warning">Editar</a>
                </td>
                <td>
                    <form action="{{action('RoleController@destroy', $role->id)}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $roles->appends(request()->query())->links() }}
@stop

@section('js')
<script type="text/javascript">
    $(function () {
        $(".delete-item").on("click", function(){
            return confirm("Tem certeza?");
        });
    });
</script>
@stop
