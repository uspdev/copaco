@extends('dashboard.master')

@section('content')
<h1>Cadastrar Rede</h1>

@include('messages.flash')
@include('messages.errors')
<div class="row">
    <div class="col-lg-3">
        <form method="post" action="{{ url('redes') }}">
            {{csrf_field()}}
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome">
            </div>

            <div class="form-group">
                <label for="iprede">IP Rede</label>
                <input type="text" class="form-control" name="iprede">
            </div>

            <div class="form-group">
                <label for="gateway">Gateway</label>
                <input type="text" class="form-control" name="gateway">
            </div>

            <div class="form-group">
                <label for="dns">DNS</label>
                <input type="text" class="form-control" name="dns">
            </div>

           <div class="form-group">
                <label for="cidr">Cidr</label>
                <input type="text" class="form-control" name="cidr">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Rede</button>
        </form>
    </div>
</div>

@endsection
