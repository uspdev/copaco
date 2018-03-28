@extends('dashboard.master')

@section('content')
<h1>Editar Rede</h1>

@include('messages.flash')
@include('messages.errors')

<div class="row">
    <div class="col-lg-3">
        <form method="post" action="{{ action('RedeController@update', $rede->id) }}">
            {{csrf_field()}}
            {{method_field('patch')}}
            @include('redes.form')
        </form>
    </div>
</div>




@endsection
