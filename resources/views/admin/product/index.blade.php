@extends('layouts.admin.app')

@section('title', 'Product Management')


@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        @include('components.alert-message')
                        <div class="mb-3 text-right">
                            @include('admin.product.create')
                        </div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Photo</th>
                                    <th>Action</th>
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
                                        <td>
                                            <img src="{{ asset('storage/' . $product->photo) }}" width="50px" height="50px" alt="">
                                        </td>
                                        <td>
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
    </section>
    <!-- /.content -->
@endsection
