@extends('adminlte::page')

@section('content_header')
    <h1>Cadastrar Rede</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<a href="{{ route('redes.create') }}" class="btn btn-success">
    Adicionar Rede
</a>


<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>IP Rede</th>
                <th>Gateway</th>
                <th>CIDR</th>
                <th >Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($redes as $rede)
            <tr>
                <td>{{ $rede->id }}</td>
                <td><a href="/redes/{{ $rede->id }}">{{ $rede->nome }}</a></td>
                <td>{{ $rede->iprede }}</td>
                <td>{{ $rede->gateway }}</td>
                <td>{{ $rede->cidr }}</td>
                <td>
                    <a href="{{action('RedeController@edit', $rede->id)}}" class="btn btn-warning">Editar</a>
                </td>
                <td>
                    <form action="{{action('RedeController@destroy', $rede->id)}}" method="post">
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
