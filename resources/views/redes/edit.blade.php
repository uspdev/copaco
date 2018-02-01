@extends('dashboard.master')

@section('content')
<h1>Editar Rede</h1>

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))

    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="fechar">&times;</a></p>
    @endif
    @endforeach
</div> <!-- end .flash-message -->

<form method="post" action="{{ action('RedeController@update', $rede->id) }}">
    {{csrf_field()}}
<<<<<<< HEAD
    {{method_field('patch')}}
    <div class="form-group row>
        <label class="col-form-label" for="nome">Nome</label>
=======
    <input name="_method" type="hidden" value="PATCH">
    <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="nome">Nome</label>
>>>>>>> upstream/master
        <div class="col-sm-7">
            <input type="text" name="nome" value="{{ $rede->nome }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-1  col-form-label" for="iprede">IP Rede</label>
        <div class="col-sm-7">
            <input type="text" name="iprede" value="{{ $rede->iprede }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-1  col-form-label" for="cidr">Cidr</label>
        <div class="col-sm-7">
            <input type="text" name="cidr" value="{{ $rede->cidr }}">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-0"></div>
        <input type="submit" class="btn btn-primary">
    </div>
</form>

@endsection
