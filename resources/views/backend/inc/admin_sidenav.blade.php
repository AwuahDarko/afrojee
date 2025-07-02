<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
  id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
      aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 py-3 m-0" href="{{ route('admin.dashboard') }}">
      <img src="{{ asset('img/logo-ct-dark.png') }}" class="navbar-brand-img" width="26" height="26" alt="main_logo">
      <span class="ms-1 text-sm text-dark">Afrojee</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0 mb-2">
  <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.dashboard') }}">
          <i class="material-symbols-rounded opacity-5">dashboard</i>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.categories') || request()->routeIs('admin.category*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.categories') }}">
          <i class="material-symbols-rounded opacity-5">table_view</i>
          <span class="nav-link-text ms-1">Categories</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.products') }}">
          <i class="material-symbols-rounded opacity-5">receipt_long</i>
          <span class="nav-link-text ms-1">Products</span>
        </a>
      </li>

       <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.orders') }}">
          <i class="material-symbols-rounded opacity-5">table_view</i>
          <span class="nav-link-text ms-1">Orders</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.reviews*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.reviews') }}">
          <i class="material-symbols-rounded opacity-5">table_view</i>
          <span class="nav-link-text ms-1">Reviews</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.countries*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.countries') }}">
          <i class="material-symbols-rounded opacity-5">receipt_long</i>
          <span class="nav-link-text ms-1">Countries</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.shipment') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.shipment') }}">
          <i class="material-symbols-rounded opacity-5">table_view</i>
          <span class="nav-link-text ms-1">Add Shipment</span>
        </a>
      </li>

       <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.promos') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.promos') }}">
          <i class="material-symbols-rounded opacity-5">table_view</i>
          <span class="nav-link-text ms-1">Promos</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.tables') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.tables') }}">
          <i class="material-symbols-rounded opacity-5">table_view</i>
          <span class="nav-link-text ms-1">Tables</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.billing') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.billing') }}">
          <i class="material-symbols-rounded opacity-5">receipt_long</i>
          <span class="nav-link-text ms-1">Billing</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.icons') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.icons') }}">
          <i class="material-symbols-rounded opacity-5">receipt_long</i>
          <span class="nav-link-text ms-1">Icons</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.vr') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.vr') }}">
          <i class="material-symbols-rounded opacity-5">view_in_ar</i>
          <span class="nav-link-text ms-1">Virtual Reality</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.rtl') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.rtl') }}">
          <i class="material-symbols-rounded opacity-5">format_textdirection_r_to_l</i>
          <span class="nav-link-text ms-1">RTL</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.notification') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.notification') }}">
          <i class="material-symbols-rounded opacity-5">notifications</i>
          <span class="nav-link-text ms-1">Notifications</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.profile') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
          href="{{ route('admin.profile') }}">
          <i class="material-symbols-rounded opacity-5">person</i>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>

    </ul>
  </div>
</aside>