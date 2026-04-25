<div class="h-100" data-simplebar>

    <!--- Sidemenu -->
    <div id="sidebar-menu">

        <div class="logo-box">
            <a href="{{ route('dashboard') }}" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{ asset('assets/images/logo-medina-new.png') }}" alt="" height="80">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/logo-medina-new.png') }}" alt="" height="80">
                </span>
            </a>
            <a href="{{ route('dashboard') }}" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{ asset('assets/images/logo-medina-new.png') }}" alt="" height="80">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/logo-medina-new.png') }}" alt="" height="80">
                </span>
            </a>
        </div>

        <ul id="side-menu">
            <li class="mt-3">
                <a href="{{ route('dashboard') }}"  class="nav-links {{ (request()->is('dashboard')) ? 'active' : ''}}">
                    <i data-feather="home"></i>
                    <span> Dashboard </span>

                </a>
            </li>

            @if (auth()->user()->role == 'admin')
                <li class=" menu-title">Master Data</li>
                <li>
                    <a href="{{ route('user.index') }}" class="nav-links {{ (request()->is('user.index')) ? 'active' : '' }}" >
                     <i class="fa-solid fa-user"></i>
                        <span> Data User </span>

                    </a>
                </li>

                <li>
                    <a href="{{ route('type.index') }}" class="nav-links {{ (request()->is('type.index')) ? 'active' : '' }} " >
                        <i class="fa-solid fa-layer-group"></i>
                        <span> Type Unit </span>

                    </a>
                </li>

                <li>
                    <a href="{{ route('kawasan.index') }}" class="nav-links {{ (request()->is('kawasan.index')) ? 'active' : '' }}">
                       <i class="fa-solid fa-map-location-dot"></i>
                        <span> Kawasan</span>

                    </a>
                </li>

                <li>
                    <a href="{{ route('supplier.index') }}" class="nav-links{{ (request()->is('supplier.index')) ? 'active' : '' }}">
                       <i class="fa-solid fa-map-location-dot"></i>
                        <span> Supplier</span>

                    </a>
                </li>

                <li>
                    <a href="{{ route('material.index') }}" class="nav-links{{ (request()->is('material.index')) ? 'active' : '' }}" >
                       <i class="fa-solid fa-boxes-stacked"></i>
                        <span> Material </span>
                    </a>
                </li>
            @endif



            <li class=" menu-title">Transaksi</li>

            <li>
                <a href= "{{ route('material_masuk.index') }}" class="nav-links{{ (request()->is('material_masuk.index')) ? 'active' : '' }}">
                   <i class="fa-solid fa-right-to-bracket"></i>
                    <span> Material Masuk </span>
                </a>
            </li>

            <li>
                <a href= >
                 <i class="fa-solid fa-box-open"></i>
                    <span> Material Terpakai </span>

                </a>
            </li>

            @if (auth()->user()->role == 'admin')
                <li>
                    <a href= >
                       <i class="fa-solid fa-file"></i>
                        <span> laporan </span>

                    </a>
                </li>
            @endif

              {{-- <li>
                <a href= data-bs-toggle ="collapse">
                    <i class="fa-solid fa-address-book"></i>
                    <span> Profile </span>

                </a> --}}
            </li>
        </ul>
    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
