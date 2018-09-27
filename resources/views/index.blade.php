@extends('adminlte::page')

@section('title', 'USPdev - COPACO')

@section('content_header')
    <h1>Sistema COntrole do PArque COmputacional</h1>
@stop

@section('content')
    
    @include ('messages.flash')
    @include ('messages.errors')
    
        @auth
            <div class="panel panel-default">
              <div class="panel-heading"><b>{{ Auth::user()->name }}</b>
                @can('admin')
                  ( você é super administrador )
                @endcan
              </div>

                <div class="panel-body">
                    <b>Meus grupos:</b>
                    <ul class="list-group">
    
                        @forelse (Auth::user()->roles()->get() as $role)
                            <li class="list-group-item"> {{ $role->nome }} </li>
                        @empty
                            <li class="list-group-item">Não está em nenhum grupo </li>
                        @endforelse
                    </ul>

                </div>
            </div>
            <h4></h4>


        @else
            Você ainda não fez seu <a href="/login"> login</a>!
        @endauth
    
@stop
