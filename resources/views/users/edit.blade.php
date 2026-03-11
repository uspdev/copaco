@extends('master')

@section('content_header')

@stop

@section('content')
@include('messages.flash')
@include('messages.errors')
    <div class="card">
        <div class="card-header">Editar Usuário</div>
        <div class="card-body">
            <form action="{{ url('users'). '/' . $user->codpes }}" method='post'>
                {{ csrf_field() }} 
                {{ method_field('patch') }}
                @include('users.form')
            </form>
        </div>
    </div>

@endsection

