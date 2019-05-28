@extends('adminlte::page')

@section('title', 'COPACO')

@section('content')
    <div class="row">
        @include('messages.flash')
        @include('messages.errors')
    </div>
@stop
