@extends('layouts.admin.app')

@section('title', 'Employee Management')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Employee Management</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-light" data-toggle="modal" data-target="#createUserModal">
                                <i class="fas fa-user-plus"></i> Add Employee
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('components.alert-message')
                        <table id="example1" class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 25%;">Name</th>
                                    <th style="width: 30%;">Email</th>
                                    <th style="width: 20%;">Role</th>
                                    <th style="width: 20%; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name ?? '-' }}</td>
                                        <td>{{ $user->email ?? '-' }}</td>
                                        <td>
                                            @if ($user->role == 'admin')
                                                <span class="badge badge-danger">Admin</span>
                                            @elseif ($user->role == 'employee')
                                                <span class="badge badge-primary">Employee</span>
                                            @elseif ($user->role == 'customer')
                                                <span class="badge badge-success">Customer</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editUserModal-{{ $user->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteUserModal-{{ $user->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modals -->
    @include('admin.user.create')
    @foreach ($users as $user)
        @include('admin.user.edit', ['user' => $user])
        @include('admin.user.delete', ['user' => $user])
    @endforeach
@endsection
