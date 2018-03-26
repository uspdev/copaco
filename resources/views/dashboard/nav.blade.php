<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <!-- Organization Name -->
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href=" {{ url('/') }}">USPdev CoPaCo</a>
    
    <form class="form-control form-control-dark" method="GET" action="{{ action('EquipamentoController@search') }}">
        <input class="form-control form-control-dark w-100" type="text" name="pesquisar" placeholder="Pesquisar Mac Address" aria-label="Search">
    </form>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">Sair</a>
        </li>
    </ul>
</nav>
