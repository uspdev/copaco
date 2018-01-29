@extends('base')

@section('content')
<h1>Editar Equipamento</h1>

<form action="{{ url('equipamento'). '/' . $equipamento->id }}" method='post'>
    {{ csrf_field() }} {{ method_field('patch') }}
    <div>
        Patrimoniado: <input name="patrimoniado" value="{{ $equipamento->patrimoniado }}">
    </div>

    <div>
        Patrimônio: <input name="patrimonio" value="{{ $equipamento->patrimonio }}">
    </div>

    <div>
        Mac Address: <input name="macaddress" value="{{ $equipamento->macaddress }}">
    </div>

    <div>
        Local: <input name="local" value="{{ $equipamento->local }}">
    </div>

    <div>
        Vencimento: <input name="vencimento" value="{{ $equipamento->vencimento }}">
    </div>

    <div>
        IP: <input name="ip" value="{{ $equipamento->ip }}">
    </div>

    <div>
        rede: <input name="rede_id" value="{{ $equipamento->rede_id }}">
    </div>

    <button type="submit"  value="alterar">Submit</button>

</form>

@endsection
