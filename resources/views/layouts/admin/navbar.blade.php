<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fas fa-th-large"></i>
        </a>
      </li>

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{ auth()->user()->unreadNotifications->count() }} Notifikasi</span>
          <div class="dropdown-divider"></div>
          @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
            <a href="{{ $notification->data['link'] }}" class="dropdown-item mark-as-read" data-id="{{ $notification->id }}">
              @if(isset($notification->data['type']) && $notification->data['type'] == 'order')
                <i class="fas fa-shopping-cart mr-2 text-primary"></i>
              @elseif(isset($notification->data['type']) && $notification->data['type'] == 'system')
                <i class="fas fa-cog mr-2 text-info"></i>
              @else
                <i class="fas fa-bell mr-2 text-warning"></i>
              @endif
              <div class="d-flex flex-column">
                <span>{{ $notification->data['message'] }}</span>
                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
              </div>
            </a>
            <div class="dropdown-divider"></div>
          @empty
            <a href="#" class="dropdown-item">
              <i class="fas fa-info-circle mr-2 text-muted"></i> Tidak ada notifikasi baru
            </a>
          @endforelse
          <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Mark notification as read when clicked
      document.querySelectorAll('.mark-as-read').forEach(function(element) {
        element.addEventListener('click', function(e) {
          e.preventDefault();
          const notificationId = this.getAttribute('data-id');
          const link = this.getAttribute('href');
          
          // Send AJAX request to mark as read
          fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Content-Type': 'application/json'
            }
          }).then(() => {
            // Redirect to the notification link
            window.location.href = link;
          });
        });
      });
    });
  </script>
  @endpush