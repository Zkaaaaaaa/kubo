@extends('layouts.admin.app')

@section('title', 'Category Management')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header text-black">
                        <h3 class="card-title">Manage Categories</h3>
                        <div class="card-tools">
                            @include('admin.category.create')
                        </div>
                    </div>
                    <div class="card-body">
                        @include('components.alert-message')
                        <table id="example1" class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 70%">Name</th>
                                    <th style="width: 25%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name ?? '-' }}</td>
                                        <td class="text-center">
                                            @include('admin.category.edit')
                                            @include('admin.category.delete')
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
