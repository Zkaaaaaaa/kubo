@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
@if(auth()->user()->role == 'admin')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="text-center">Welcome, {{ auth()->user()->name }}!</h1>
                    <p class="text-center text-muted">Selamat bekerja boss!</p>
                </div>
            </div>
            <!-- Notification Bell -->
            <div class="row mb-4">
                <div class="col-12 text-right">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge badge-light" id="notificationCount">{{ auth()->user()->unreadNotifications->count() }}</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown" id="notificationList">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <a class="dropdown-item" href="{{ route('admin.order.show', $notification->data['order_id']) }}">
                                    {{ $notification->data['message'] }}
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </a>
                            @empty
                                <a class="dropdown-item">No new notifications</a>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-6 col-xl-4 mb-3">
                    <!-- Total Users -->
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Total Users</h5>
                                    <h3>{{ $users }}</h3>
                                </div>
                                <div>
                                    <i class="ion-person-add display-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('admin.user.index') }}" class="text-white">
                                More Info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@elseif(auth()->user()->role == 'employee')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="text-center">Welcome, {{ auth()->user()->name }}!</h1>
                    <p class="text-center text-muted">kerja kerja kerja</p>
                </div>
            </div>
            <!-- Notification Bell -->
            <div class="row mb-4">
                <div class="col-12 text-right">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge badge-light" id="notificationCount">{{ auth()->user()->unreadNotifications->count() }}</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown" id="notificationList">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <a class="dropdown-item" href="{{ route('employee.orders.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-shopping-cart mr-2 text-primary"></i>
                                        <div>
                                            {{ $notification->data['message'] }}
                                            <br>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <a class="dropdown-item">Tidak ada notifikasi baru</a>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-6 col-xl-6 mb-3">
                    <!-- Total Categories -->
                    <div class="card bg-info text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Total Categories</h5>
                                    <h3>{{ $categories }}</h3>
                                </div>
                                <div>
                                    <i class="ion ion-bag display-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('employee.category.index') }}" class="text-white">
                                More Info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6 mb-3">
                    <!-- Total Products -->
                    <div class="card bg-warning text-dark shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Total Products</h5>
                                    <h3>{{ $products }}</h3>
                                </div>
                                <div>
                                    <i class="ion ion-bag display-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('employee.product.index') }}" class="text-dark">
                                More Info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6 mb-3">
                    <!-- Process Orders -->
                    <div class="card bg-info text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Process Orders</h5>
                                    <h3>{{ $histories['process'] }}</h3>
                                </div>
                                <div>
                                    <i class="ion ion-gear-a display-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('employee.history.index') }}" class="text-white">
                                More Info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6 mb-3">
                    <!-- Completed Orders -->
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Completed Orders</h5>
                                    <h3>{{ $histories['done'] }}</h3>
                                </div>
                                <div>
                                    <i class="ion ion-checkmark-circled display-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('employee.history.index') }}" class="text-white">
                                More Info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

@push('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
    });

    var channel = pusher.subscribe('new-order');
    channel.bind('App\\Events\\NewOrder', function(data) {
        // Update notification count
        var count = parseInt($('#notificationCount').text()) + 1;
        $('#notificationCount').text(count);

        // Add new notification to dropdown
        var notificationHtml = `
            <a class="dropdown-item mark-as-read" href="/employee/orders" data-id="${data.order_id}">
                <div class="d-flex align-items-center">
                    <i class="fas fa-shopping-cart mr-2 text-primary"></i>
                    <div>
                        ${data.message}
                        <br>
                        <small class="text-muted">Baru saja</small>
                    </div>
                </div>
            </a>
        `;
        $('#notificationList').prepend(notificationHtml);

        // Show toast notification
        toastr.success(data.message);

        // Play notification sound
        var audio = new Audio('/assets/sounds/notification.mp3');
        audio.play();
    });

    // Mark notification as read when clicked
    $(document).on('click', '.mark-as-read', function(e) {
        e.preventDefault();
        var notificationId = $(this).data('id');
        var link = $(this).attr('href');
        
        $.ajax({
            url: `/employee/notifications/${notificationId}/mark-as-read`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                window.location.href = link;
            }
        });
    });

    // Update notification count periodically
    setInterval(function() {
        $.get('/employee/notifications/unread-count', function(data) {
            $('#notificationCount').text(data.count);
        });
    }, 30000); // Update every 30 seconds
</script>
@endpush
@endsection
