@extends('master')

@section('content_header')

@stop

@section('content')
    <div class="row">
    @include('messages.flash')
    @include('messages.errors')

    <div class="col-md-6">
        <form action="{{ url('users'). '/' . $user->username }}" method='post'>
            {{ csrf_field() }} 
            {{ method_field('patch') }}
            @include('users.form')
        </form>
    </div>
</div>

@endsection

