@extends('layouts.admin.app')

@section('title', 'History')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        @include('components.alert-message')
                        {{-- <div class="mb-3 text-right">
                            @include('admin.history.create')
                        </div> --}}
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Product</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($histories as $history)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $history->date ?? '-' }}</td>
                                        <td>{{ $history->name ?? '-' }}</td>                                
                                        <td>{{ $history->quantity ?? '-' }}</td>
                                        <td>{{ $history->total ?? '-' }}</td>
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
