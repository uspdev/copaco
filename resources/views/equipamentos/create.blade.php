@extends('dashboard.master')

@section('content')
<h1>Cadastrar Equipamento</h1>

@include('messages.flash')
@include('messages.errors')

<div class="row">
    <div class="col-lg-4">
        <form action="{{ url('equipamentos') }}" method="post">
        {{ csrf_field() }}
        @include('equipamentos.form')
        </form>
    </div>
</div>


@endsection
