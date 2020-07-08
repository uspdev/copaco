@extends('master')

@section('content_header')
    <h1>Sistema COntrole do PArque COmputacional</h1>
@stop

@section('content')
    @parent
    
        @auth
            <div class="card">
                <div class="card-header"><b>{{ Auth::user()->name }}</b>
                  @can('admin')
                    ( você é super administrador )
                  @endcan
                </div>

                <div class="card-body">
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

        @else
            Você ainda não fez seu <a href="/login"> login</a>!
        @endauth
    
@stop
