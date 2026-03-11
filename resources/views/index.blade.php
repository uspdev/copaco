@extends('master')

@section('content_header')
    <h1>Sistema COntrole do PArque COmputacional</h1>
@stop

@section('content')   
        @auth
            <div class="card">
                <div class="card-header"><b>{{ Auth::user()->name }}</b>
                  @can('admin')
                    ( você é super administrador )
                  @endcan
                </div>
            </div>

        @else
            Você ainda não fez seu login. <a href="/login"> login USP </a> ou <a href="/loginlocal"> login local </a>!
        @endauth
    
@stop
