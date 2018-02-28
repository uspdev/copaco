<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            Recursos
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('redes') }}">
                    Redes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('equipamentos') }}">
                    Equipamentos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    dhcpd.conf
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Relatórios</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Equipamentos Vencidos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Equipamentos não alocados
                </a>
            </li>
        </ul>
    </div>
</nav>
