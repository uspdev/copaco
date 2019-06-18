@extends('adminlte::page')

@section('title', 'COPACO')

@section('content')
    <div class="row">
        @include('messages.flash')
        @include('messages.errors')
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/copaco.css') }}s">
@stop

@section('js')
    <script src="{{ asset('assets/js/copaco.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {
        $(".delete-item").on("click", function(){
            return confirm("Tem certeza?");
        });
    });
</script>

@stop
