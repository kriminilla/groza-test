<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-light shadow sticky-top p-0" style="background-color:#181717;">
    <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <img src="{{ asset('img/logoGroza.png') }}" loading="lazy" style="width:auto; height: 30px;" alt="Groza Indonesia">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="{{ url('/') }}" 
               class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">
               BERANDA
            </a>

            <a href="{{ route('products') }}" 
               class="nav-item nav-link {{ Request::routeIs('products', 'catalog.subcategories', 'products.detail') ? 'active' : '' }}">
               PRODUK
            </a>

            <div class="nav-item dropdown">
                <a href="{{ route('partner.list') }}" 
                   class="nav-link dropdown-toggle {{ Request::routeIs('partner.list', 'distributor.list') ? 'active' : '' }}" 
                   data-bs-toggle="dropdown">
                   LOKASI
                </a>
                <div class="dropdown-menu border-0 shadow-sm rounded-0" style="background-color: #181717;">
                    <a href="{{ route('partner.list') }}" class="dropdown-item text-white" style="transition: background 0.3s;">LOKASI MITRA</a>
                    <a href="{{ route('distributor.list') }}" class="dropdown-item text-white" style="transition: background 0.3s;">LOKASI DISTRIBUTOR</a>
                </div>
            </div>

            <!-- Dropdown: Tentang Kami -->
            <div class="nav-item dropdown">
                <a href="{{ route('about') }}" 
                   class="nav-link dropdown-toggle {{ Request::routeIs('about', 'articles.list', 'events.list') ? 'active' : '' }}" 
                   data-bs-toggle="dropdown">
                   TENTANG KAMI
                </a>
                <div class="dropdown-menu border-0 shadow-sm rounded-0" style="background-color: #181717;">
                    <a href="{{ route('about') }}" class="dropdown-item text-white" style="transition: background 0.3s;">TENTANG KAMI</a>
                    <a href="{{ route('articles.list') }}" class="dropdown-item text-white" style="transition: background 0.3s;">ARTIKEL</a>
                    <a href="{{ route('events.list') }}" class="dropdown-item text-white" style="transition: background 0.3s;">EVENT</a>
                </div>
            </div>
            <!-- End Dropdown -->

            <a href="{{ route('catalog') }}" 
               class="nav-item nav-link {{ Request::routeIs('catalog') ? 'active' : '' }}">
               KATALOG
            </a>

            <a href="https://www.instagram.com/groza.indonesia/"  
               target="_blank" 
               class="btn btn-instagram">
               <i class="fab fa-instagram me-2"></i> Instagram
            </a>
        </div>
    </div>
</nav>
<!-- Navbar End -->

<!-- Tambahkan gaya tambahan kecil -->
<style>
    .navbar .dropdown-item:hover {
        background-color: #f6805d !important;
        color: #fff !important;
    }
    .navbar .dropdown-toggle::after {
        margin-left: 0.4rem;
        vertical-align: middle;
    }
</style>
