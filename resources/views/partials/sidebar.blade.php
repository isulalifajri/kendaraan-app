<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="" class="app-brand-link">
        <span class="app-brand-logo demo img-icons">
          <img src="{{ asset('no-images.jpg') }}" 
               alt="default" 
               class="img-fluid h-100">
        </span>
        <span class="app-brand-text demo menu-text fw-bold ms-2">TES</span>
      </a>
  
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>
  
    <div class="menu-inner-shadow"></div>
  
    <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item {{ Request::is('/') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Dashboards">Dashboards</div>
        </a>
      </li>

      @if(auth()->user()->role == 'admin')
  
      <!-- Layouts -->
      <li class="menu-item {{ Request::is('masterData*') ? 'active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Data Master">Data Master</div>
        </a>
  
        <ul class="menu-sub">
          <li class="menu-item  {{ Request::is('masterData/user*') ? 'active' : '' }}">
            <a href="{{ route('user.index') }}" class="menu-link">
              <div data-i18n="user">User</div>
            </a>
          </li>
        </ul>

        <ul class="menu-sub">
          <li class="menu-item  {{ Request::is('masterData/kendaraan*') ? 'active' : '' }}">
            <a href="{{ route('kendaraan.index') }}" class="menu-link">
              <div data-i18n="kendaraan">Kendaraan</div>
            </a>
          </li>
        </ul>

        <ul class="menu-sub">
          <li class="menu-item  {{ Request::is('masterData/driver*') ? 'active' : '' }}">
            <a href="{{ route('driver.index') }}" class="menu-link">
              <div data-i18n="driver">Driver</div>
            </a>
          </li>
        </ul>

      </li>

      <li class="menu-item {{ Request::segment(1) === 'pemesanan' ? 'active' : '' }}">
        <a href="{{ route('pemesanan.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-cart-alt"></i>
          <div data-i18n="Pesanan">Pemesanan</div>
        </a>
      </li>

      @endif

      @if(auth()->user()->role == 'penyetuju')

      <li class="menu-item {{ Request::segment(1) === 'approval' ? 'active' : '' }}">
        <a href="{{ route('approval.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-collection"></i>
          <div data-i18n="Persetujuan">Persetujuan</div>
        </a>
      </li>

      @endif

      @if(auth()->user()->role == 'admin')

      <li class="menu-item {{ Request::segment(1) === 'bbm' ? 'active' : '' }}">
        <a href="{{ route('bbm.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-collection"></i>
          <div data-i18n="Konsumsi BBM">Konsumsi BBM</div>
        </a>
      </li>

      @endif
      
    </ul>
  </aside>