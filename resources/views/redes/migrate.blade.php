@extends('master')

@section('content_header')
    <h1>Cadastrar Rede</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')
    
    <div class="card">
        <div class="card-header">Migração de equipamentos entre redes</div>
        <div class="card-body">
            <form method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="from">Rede de origem:</label>
                    <select name="from" class="form-control">
                        <option value="" selected="">Selecione</option>
                        @foreach($redes->sortBy('nome') as $rede)
                            <option value="{{ $rede->id }}" {{ (old('from') == $rede->id) ? 'selected' : ''}}>
                            {{ $rede->iprede}}/{{$rede->cidr}} - {{$rede->nome  }} (Equipamentos: {{$rede->equipamentos->count()}})
                            </option>                
                        @endforeach
                    </select>
                </div>
                

                <div class="form-group">
                    <label for="to">Rede de destino:</label>
                    <select name="to" class="form-control">
                        <option value="" selected="">Selecione</option>
                        @foreach($redes->sortBy('nome') as $rede)
                            <option value="{{ $rede->id }}" {{ (old('to') == $rede->id) ? 'selected' : ''}}>
                                {{ $rede->iprede}}/{{$rede->cidr}} - {{$rede->nome  }} (Disponíveis: {{ \App\Utils\NetworkOps::numberAvailableIPs($rede) }})
                            </option>                
                        @endforeach
                    </select>
                </div>

                <br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Enviar">
                </div>

            </form>
        </div>
    </div>

@stop
