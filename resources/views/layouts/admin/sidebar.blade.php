<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @if (Auth::user()->role == 'admin')
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/dist/img/logokubo.jpg') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Kubo Kopi Dashboard</span>
    </a>
    @elseif (Auth::user()->role == 'employee')
    <a href="{{ route('employee.dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/dist/img/logokubo.jpg') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Kubo Kopi Dashboard</span>
    </a>
    @endif

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('profile.edit') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                
                @if (Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.user.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Employee</p>
                    </a>
                    </li>
                    @elseif(Auth::user()->role == 'employee')
                    <li class="nav-item">
                        <a href="{{ route('employee.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('employee.promo.edit') }}" class="nav-link">
                            <i class="nav-icon fas fa-tag"></i>
                            <p>Promo</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('employee.product.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Product</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('employee.category.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('employee.history.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-history"></i>
                            <p>History</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('employee.orders.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Orders</p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-danger btn-block text-left"
                            style="color: white; border: none;">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
