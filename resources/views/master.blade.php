@extends('laravel-usp-theme::master')

@section('title', 'COPACO')

@section('content')
    <div class="row">
        @include('messages.flash')
        @include('messages.errors')
    </div>
@stop

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/css/copaco.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
@stop

@section('javascripts_bottom')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="{{ asset('assets/js/copaco.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {
        $(".delete-item").on("click", function(){
            return confirm("Tem certeza?");
        });
    });
</script>

@stop
