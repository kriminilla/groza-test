<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('img/logoGroza-admin.png') }}" class="brand-image img-circle elevation-3" style="opacity: .8" alt="Groza Logo">
        <span class="brand-text font-weight-light"><img src="{{ asset('img/textGroza-admin.png') }}" alt="Logo Groza" style="height: 35px; width: auto;"></span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('img/admin.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    {{ auth('admin')->user()->name ?? 'Admin' }}
                </a>
            </div>
        </div> 

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

        
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                {{-- BUTTON DASHBOARD --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{-- END BUTTON DASHBOARD --}}

                {{-- MENU LIST ADMIN (khusus superadmin) --}}
                @php
                    $isListAdminActive = request()->routeIs('admin.list');
                    @endphp
                    @if(auth('admin')->check() && auth('admin')->user()->role->name === 'superadmin')
                        <li class="nav-item {{ $isListAdminActive ? 'menu-open' : '' }}">
                            <a href="{{ route('admin.list') }}" 
                               class="nav-link {{ $isListAdminActive ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>List Admin</p>
                            </a>
                        </li>
                    @endif
                {{-- END MENU LIST ADMIN --}}

                {{-- MENU KONTEN --}}
                @php
                    $isKontenActive = request()->routeIs('heroimage.index', 'iframe.index', 'heroproduct.index', 'headerimage.index');
                @endphp
                <li class="nav-item {{ $isKontenActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $isKontenActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Konten
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('heroimage.index') }}" class="nav-link {{ request()->routeIs('heroimage.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Konten Hero Carousel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('heroproduct.index') }}" class="nav-link {{ request()->routeIs('heroproduct.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hero Image Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('iframe.index') }}" class="nav-link {{ request()->routeIs('iframe.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>IFrame YouTube</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('headerimage.index') }}" class="nav-link {{ request()->routeIs('headerimage.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Header Subkategori</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- END MENU KONTEN --}}

                {{-- MENU PRODUK --}}
                @php
                    $isProdukActive = request()->routeIs('product.index', 'category.index', 'subcategory.index', 'color.index','size.index');
                @endphp
                <li class="nav-item {{ $isProdukActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $isProdukActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-motorcycle"></i>
                        <p>
                            Produk
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('product.index') }}" class="nav-link {{ request()->routeIs('product.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('category.index') }}" class="nav-link {{ request()->routeIs('category.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('subcategory.index') }}" class="nav-link {{ request()->routeIs('subcategory.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sub-Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('color.index') }}" class="nav-link {{ request()->routeIs('color.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Opsi Warna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('size.index') }}" class="nav-link {{ request()->routeIs('size.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ukuran</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- END MENU PRODUK --}}

                {{-- MENU LOKASI --}}
                @php
                    $isLokasiActive = request()->routeIs('partnerlist.index', 'distributorlist.index', 'province.index', 'city.index');
                @endphp
                <li class="nav-item {{ $isLokasiActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $isLokasiActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map"></i>
                        <p>
                            Lokasi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('partnerlist.index') }}" class="nav-link {{ request()->routeIs('partnerlist.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Lokasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('distributorlist.index') }}" class="nav-link {{ request()->routeIs('distributorlist.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Lokasi Distributor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('province.index') }}" class="nav-link {{ request()->routeIs('province.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Provinsi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('city.index') }}" class="nav-link {{ request()->routeIs('city.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kota</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- END MENU LOKASI --}}


                {{-- MENU ARTIKEL --}}
                @php
                    $isArtikelActive = request()->routeIs('article.index', 'article.show' ,'article.create', 'article.edit');
                @endphp
                <li class="nav-item {{ $isArtikelActive ? 'menu-open' : '' }}">
                    <a href="article.index" class="nav-link {{ $isArtikelActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Artikel
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('article.index') }}" class="nav-link {{ request()->routeIs('article.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Artikel</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- END MENU ARTIKEL --}}

                {{-- MENU EVENT --}}
                @php
                    $isEventActive = request()->routeIs('event.index','eventcategory.index', 'event.create', 'event.edit');
                @endphp
                <li class="nav-item {{ $isEventActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $isEventActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Event
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route ('event.index') }}" class="nav-link {{ request()->routeIs('event.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Event</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route ('eventcategory.index') }}" class="nav-link {{ request()->routeIs('eventcategory.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Event</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- END MENU EVENT --}}

                {{-- BUTTON LOG-OUT --}}
                <li class="nav-item">
                    <a href="#" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Log-Out</p>
                    </a>
                
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>                
                {{-- END BUTTON LOG-OUT --}}
                
            </ul>
        </nav>
    </div>
</aside>