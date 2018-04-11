@extends ('dashboard.master')

@section ('content')

@include ('messages.flash')
@include ('messages.errors')

<h1>Sistema COntrole do PArque COmputacional</h1>

    @auth
        <h3><b>Olá {{ Auth::user()->name }},</b></h3>
        Acesse as opções no menu ao lado
    @else
        Você ainda não fez seu login com a senha única USP <a href="/login"> Faça seu Login! </a>
    @endauth
    <h3>Com o Copaco você pode</h3>
    <ul>
        <li>Cadastrar computadores, APs, switches </li>
        <li>Cadastrar rede...</li>
        <li>...</li>
    </ul>

@endsection
