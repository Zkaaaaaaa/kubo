@extends('layouts.admin.app')

@section('title', 'History')

@section('content')
    <!-- Bagian konten utama -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Container card untuk tabel history -->
                    <div class="card shadow-sm">
                        <!-- Header card dengan judul dan tombol export -->
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">Order History</h3>
                            <div id="table-buttons"></div>
                        </div>
                        <div class="card-body">
                            <!-- Komponen pesan alert untuk notifikasi -->
                            @include('components.alert-message')

                            <!-- Container tabel responsif -->
                            <div class="table-responsive">
                                <!-- Tabel history utama dengan inisialisasi DataTables -->
                                <table id="historyTable" class="table table-bordered table-striped table-hover">
                                    <!-- Header tabel dengan nama kolom -->
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
                                        <!-- Inisialisasi penghitung total -->
                                        @php
                                            $totalQuantity = 0;
                                            $totalAmount = 0;
                                        @endphp
                                        <!-- Perulangan untuk setiap record history -->
                                        @foreach ($histories as $history)
                                            <!-- Akumulasi total -->
                                            @php
                                                $totalQuantity += $history['quantity'];
                                                $totalAmount += $history['total'];
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $history['date'] ?? '-' }}</td>
                                                <td>{{ $history['token'] ?? '-' }}</td>
                                                <td>{{ $history['user_id'] ?? '-' }}</td>
                                                <td>{{ $history['quantity'] ?? '-' }}</td>
                                                <td>Rp {{ number_format($history['total'], 0, ',', '.') }}</td>
                                                <td>
                                                    <!-- Konfigurasi badge status -->
                                                    @php
                                                        // Mendefinisikan kelas untuk setiap status
                                                        $statusClasses = [
                                                            'cart' => 'badge-warning',
                                                            'process' => 'badge-primary',
                                                            'done' => 'badge-success',
                                                            'default' => 'badge-danger'
                                                        ];
                                                        // Mendefinisikan label untuk setiap status
                                                        $statusLabels = [
                                                            'cart' => 'Cart',
                                                            'process' => 'Process',
                                                            'done' => 'Done',
                                                            'default' => 'No Status'
                                                        ];
                                                        // Mendapatkan kelas dan label yang sesuai berdasarkan status
                                                        $statusClass = $statusClasses[$history['status'] ?? 'default'];
                                                        $statusLabel = $statusLabels[$history['status'] ?? 'default'];
                                                    @endphp
                                                    <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <!-- Footer tabel dengan total -->
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td colspan="4" class="text-end fw-bold">Total:</td>
                                            <td class="fw-bold">{{ $totalQuantity }}</td>
                                            <td class="fw-bold">Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
            // Inisialisasi DataTable dengan konfigurasi
            const table = $("#historyTable").DataTable({
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                paging: true,
                dom: 'Bfrtip',
                // Konfigurasi tombol export
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger btn-sm',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        },
                        // Kustomisasi PDF
                        customize: function (doc) {
                            doc.content[1].table.widths = 
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                            doc.styles.tableHeader = {
                                fillColor: '#343a40',
                                color: '#ffffff',
                                bold: true
                            };
                            doc.styles.tableFooter = {
                                fillColor: '#f8f9fa',
                                bold: true
                            };
                            doc.defaultStyle.alignment = 'center';
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-primary btn-sm',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        },
                        // Kustomisasi print
                        customize: function(win) {
                            $(win.document.body).find('table tfoot tr')
                                .css('background-color', '#f8f9fa')
                                .css('font-weight', 'bold');
                        }
                    }
                ],
                // Konfigurasi bahasa untuk pencarian
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search...",
                },
                // Callback footer untuk perhitungan total dinamis
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();
                    
                    // Fungsi pembantu untuk mengkonversi nilai string ke integer
                    var intVal = function (i) {
                        if (typeof i === 'string') {
                            return parseInt(i.replace(/[^\d]/g, '')) || 0;
                        }
                        return typeof i === 'number' ? i : 0;
                    };

                    // Menghitung total kuantitas untuk halaman saat ini
                    var totalQty = api
                        .column(4, { page: 'current' })
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Menghitung total jumlah untuk halaman saat ini
                    var totalAmount = api
                        .column(5, { page: 'current' })
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Memperbarui sel footer dengan total yang dihitung
                    $(api.column(4).footer()).html(totalQty);
                    $(api.column(5).footer()).html('Rp ' + totalAmount.toLocaleString('id-ID'));
                }
            });

            // Menambahkan tombol ke container yang ditentukan
            table.buttons().container().appendTo('#table-buttons');
        });
    </script>

    <!-- Library DataTables dan library terkait yang diperlukan -->
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
