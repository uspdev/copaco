@extends('dashboard.master')

@section('content')
<h1>Cadastrar Rede</h1>

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))

    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="fechar">&times;</a></p>
    @endif
    @endforeach
</div> <!-- end .flash-message -->

<form method="post" action="{{ url('redes') }}">
    {{csrf_field()}}
    <div class="form-group row">
        <label class="col-sm-2  col-form-label" for="nome">Nome</label>
        <div class="col-sm-7">
            <input type="text" name="nome">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2  col-form-label" for="iprede">IP Rede</label>
        <div class="col-sm-7">
            <input type="text" name="iprede">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2  col-form-label" for="cidr">Cidr</label>
        <div class="col-sm-7">
            <input type="text" name="cidr">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-0"></div>
        <input type="submit" class="btn btn-primary">
    </div>
</form>

@endsection
