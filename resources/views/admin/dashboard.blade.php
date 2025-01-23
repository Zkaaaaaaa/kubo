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
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-6 col-xl-4 mb-3">
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
                <div class="col-md-6 col-xl-4 mb-3">
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
                <div class="col-md-6 col-xl-4 mb-3">
                    <!-- Total History -->
                    <div class="card bg-danger text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Total History</h5>
                                    <h3>{{ $histories }}</h3>
                                </div>
                                <div>
                                    <i class="ion ion-pie-graph display-4"></i>
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
@endsection
