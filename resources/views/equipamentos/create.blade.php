@extends('dashboard.master')

@section('content')
<form action="{{ url('equipamentos') }}" method="post">
    {{ csrf_field() }}

    <div>
        Patrimoniado: <input name="patrimoniado">
    </div>

    <div>
        Patrimônio: <input name="patrimonio">
    </div>

    <div>
        Mac Address: <input name="macaddress">
    </div>

    <div>
        Local: <input name="local">
    </div>

    <div>
        Vencimento: <input name="vencimento">
    </div>

    <div>
        IP: <input name="ip">
    </div>

    <div>
        rede: <input name="rede_id">
    </div>

    <button type="submit"  value="Submit">Submit</button>

</form>

@endsection
