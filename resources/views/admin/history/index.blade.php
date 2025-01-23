@extends('layouts.admin.app')

@section('title', 'History')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header text-black d-flex justify-content-between align-items-center">
                        <h3 class="card-title">History</h3>
                        <div id="table-buttons"></div>
                    </div>
                    <div class="card-body">
                        @include('components.alert-message')

                        <!-- Tabel -->
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead class="bg-secondary text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Order Number</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($histories as $history)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $history['date'] ?? '-' }}</td>
                                            <td>{{ $history['token'] ?? '-' }}</td>
                                            <td>{{ $history['user_id'] ?? '-' }}</td>
                                            <td>{{ $history['quantity'] ?? '-' }}</td>
                                            <td>{{ $history['total'] ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $statusClasses = [
                                                        'cart' => 'badge-warning',
                                                        'process' => 'badge-primary',
                                                        'done' => 'badge-success',
                                                        'default' => 'badge-danger'
                                                    ];
                                                    $statusLabels = [
                                                        'cart' => 'Cart',
                                                        'process' => 'Process',
                                                        'done' => 'Done',
                                                        'default' => 'No Status'
                                                    ];
                                                    $statusClass = $statusClasses[$history['status'] ?? 'default'];
                                                    $statusLabel = $statusLabels[$history['status'] ?? 'default'];
                                                @endphp
                                                <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            const table = $("#example1").DataTable({
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                paging: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger btn-sm'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-primary btn-sm'
                    }
                ]
            });

            table.buttons().container().appendTo('#table-buttons');
        });
    </script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.77/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.77/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
@endsection