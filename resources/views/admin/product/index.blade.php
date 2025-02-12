@extends('layouts.admin.app')

@section('title', 'Product Management')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold text-black">Product Management</h3>
                        <div class="card-tools">
                            @include('admin.product.create')
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @include('components.alert-message')
                        <table id="productTable" class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 15%">Category</th>
                                    <th style="width: 20%">Name</th>
                                    <th style="width: 15%">Price</th>
                                    <th style="width: 25%">Description</th>
                                    <th style="width: 10%">Photo</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->category->name ?? '-' }}</td>
                                        <td>{{ $product->name ?? '-' }}</td>
                                        <td>{{ $product->price ?? '-' }}</td>
                                        <td>{{ $product->description ?? '-' }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . $product->photo) }}" width="50px" height="50px" alt="Photo">
                                        </td>
                                        <td class="text-center">
                                            @include('admin.product.edit')
                                            @include('admin.product.delete')
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</section>
<!-- /.content -->
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#productTable').DataTable({
            responsive: true,
            autoWidth: false,
        });
    });
</script>
@endpush
