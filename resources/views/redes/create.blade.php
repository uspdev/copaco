@extends('dashboard.master')

@section('content')
<h1>Cadastrar Rede</h1>

@include('messages.flash')
@include('messages.errors')

<div class="row">
    <div class="col-lg-3">
        <form method="post" action="{{ url('redes') }}">
            {{csrf_field()}}
            @include('redes.form')
        </form>
    </div>
</div>

@endsection
