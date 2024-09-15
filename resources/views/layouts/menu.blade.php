<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
    <div class="container-xxl d-flex h-100">
      <ul class="menu-inner">
        <!-- Dashboards -->
        {{-- <li class="menu-item @if (Request::is('/')) active @endif ">
          <a href="{{ url('/') }}" class="menu-link">
            <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
            <div data-i18n="Dashboard">Dashboards</div>
          </a>
        </li> --}}

        <li class="menu-item @if (Request::is('category')) active @endif ">
          <a href="{{ route('category') }}" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-folder"></i>
              <div data-i18n="Kategori">Kategori</div>
          </a>
      </li>
      
      <li class="menu-item @if (Request::is('item')) active @endif ">
          <a href="{{ route('item') }}" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-cube-outline"></i>
              <div data-i18n="Barang">Barang</div>
          </a>
      </li>
      
      <li class="menu-item @if (Request::is('transaction')) active @endif ">
          <a href="{{ route('transaction') }}" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-swap-horizontal"></i>
              <div data-i18n="Transaksi">Transaksi</div>
          </a>
      </li>
      
      </ul>
    </div>
  </aside>