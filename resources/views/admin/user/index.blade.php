@extends('layouts.admin.app')

@section('title', 'Employee Management')

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
                            @include('admin.user.create')
                        </div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name ?? '-' }}</td>
                                        <td>{{ $user->email ?? '-' }}</td>
                                        <td>
                                            @if( $user->role == 'admin')
                                            <span class="badge badge-danger">Admin</span>
                                            @elseif ($user->role == 'employee')
                                            <span class="badge badge-primary">Employee</span>
                                            @elseif ($user->role == 'customer')
                                            <span class="badge badge-success">Customer</span>
                                            @endif
                                        </td>
                                        <td>
                                            @include('admin.user.edit')
                                            @include('admin.user.delete')
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
