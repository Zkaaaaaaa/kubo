@extends('layouts.admin.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Notifikasi</h1>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-primary float-right" id="markAllAsRead">
                        <i class="fas fa-check-double"></i> Tandai Semua Sudah Dibaca
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Pesan</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notifications as $notification)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if(isset($notification->data['type']) && $notification->data['type'] == 'order')
                                                    <i class="fas fa-shopping-cart mr-2 text-primary"></i>
                                                @elseif(isset($notification->data['type']) && $notification->data['type'] == 'system')
                                                    <i class="fas fa-cog mr-2 text-info"></i>
                                                @else
                                                    <i class="fas fa-bell mr-2 text-warning"></i>
                                                @endif
                                                {{ $notification->data['message'] }}
                                            </div>
                                        </td>
                                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                                        <td>
                                            @if($notification->read_at)
                                                <span class="badge badge-success">Sudah Dibaca</span>
                                            @else
                                                <span class="badge badge-warning">Belum Dibaca</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ $notification->data['link'] }}" class="btn btn-sm btn-primary mark-as-read" data-id="{{ $notification->id }}">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada notifikasi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark single notification as read
        document.querySelectorAll('.mark-as-read').forEach(function(element) {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                const notificationId = this.getAttribute('data-id');
                const link = this.getAttribute('href');
                
                fetch(`/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                }).then(() => {
                    window.location.href = link;
                });
            });
        });

        // Mark all notifications as read
        document.getElementById('markAllAsRead').addEventListener('click', function() {
            fetch('/notifications/mark-all-as-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                window.location.reload();
            });
        });
    });
</script>
@endpush 