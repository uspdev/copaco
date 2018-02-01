@extends('dashboard.master')

@section('content')
<h1>Cadastrar Equipamento</h1>

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="fechar">&times;</a></p>
        @endif
    @endforeach
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif  

</div> <!-- end .flash-message -->

<form action="{{ url('equipamentos') }}" method="post">
    {{ csrf_field() }}

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="patrimoniado">Patrimoniado</label>
        <div class="col-sm-7">
            <input name="patrimoniado">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="patrimonio">Patrimônio</label>
        <div class="col-sm-7">
            <input name="patrimonio">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="macaddress">Mac Address</label>
        <div class="col-sm-7">
            <input id="macaddress" name="macaddress">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="local">Local</label>
        <div class="col-sm-7">
            <input name="local">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="vencimento">Vencimento</label>
        <div class="col-sm-7">
            <input name="vencimento">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="ip">IP</label>
        <div class="col-sm-7">
            <input name="ip">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="rede_id">Rede</label>
        <div class="col-sm-7">
            <input name="rede_id">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-0"></div>
        <input type="submit" class="btn btn-primary">
    </div>

</form>
<script>
    
    var macAddress = document.getElementById("macaddress");

    function formatMAC(e) {
        var r = /([a-f0-9]{2})([a-f0-9]{2})/i,
            str = e.target.value.replace(/[^a-f0-9]/ig, "");

        while (r.test(str)) {
            str = str.replace(r, '$1' + ':' + '$2');
        }

        e.target.value = str.slice(0, 17);
    };

    macAddress.addEventListener("keyup", formatMAC, false);
    
</script>
@endsection
