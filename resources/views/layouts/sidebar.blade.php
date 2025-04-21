<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('adminlte/dist/img/Faishal.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="" class="d-block">Faishal Harist</a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">Data User</li>
            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link {{ $activeMenu == 'user' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>User</p>
                </a>
            </li>
            <li class="nav-header">Data Buku</li>
            <li class="nav-item">
                <a href="{{ url('/books') }}" class="nav-link {{ $activeMenu == 'books' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-book"></i>
                    <p>Buku</p>
                </a>
            </li>
            <li class="nav-header">Transaksi</li>
            <li class="nav-item">
                <a href="{{ url('/rentals') }}" class="nav-link {{ $activeMenu == 'rentals' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-handshake"></i>
                    <p>Rental</p>
                </a>
            </li>
        </ul>
    </nav>
</div>