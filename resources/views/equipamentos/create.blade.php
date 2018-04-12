@extends('adminlte::page')

@section('content_header')
    <h1>Cadastrar Equipamento</h1>
@stop

@section('content')
    <div class="row">
        @include('messages.flash')
        @include('messages.errors')

        <div class="col-md-6">
            <form action="{{ url('equipamentos') }}" method="post">
            {{ csrf_field() }}
            @include('equipamentos.form')
            </form>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.pt-BR.min.js"></script>
    <script src="{{asset('js/app.js')}}"></script>
@stop
