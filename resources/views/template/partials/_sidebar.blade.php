  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          @if (Auth::user()->hasRole('kasir'))
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-power-off"></i>
              <p>
                Sign Out
              </p>
            </a>
          <form id="logout-form" style="display:none;" action="{{route('logout')}}" method="post">
          @csrf
          </form>
          </li>
          @else
          <li class="nav-item">
            <a href="{{ route('category.index') }}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>Category</p>
          </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('product.category')}}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>Product</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('order.index')}}" class="nav-link">
            <i class="nav-icon fas fa-money-bill-alt"></i>
            <p>Penjualan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('report.index')}}" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Laporan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('profile.index')}}" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Setting</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-power-off"></i>
              <p>
                Sign Out
              </p>
            </a>
          <form id="logout-form" style="display:none;" action="{{route('logout')}}" method="post">
          @csrf
          </form>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>