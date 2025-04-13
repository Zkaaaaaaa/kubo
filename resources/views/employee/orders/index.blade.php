@extends('layouts.admin.app')

@section('title', 'Order Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Orders in Process</h3>
                </div>
                <div class="card-body">
                    @include('components.alert-message')
                    <table id="ordersTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Products</th>
                                <th>Total Quantity</th>
                                <th>Total Amount</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->token }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>
                                        <ul class="list-unstyled">
                                            @foreach($order->items as $item)
                                                <li>
                                                    {{ $item->product->name }} 
                                                    ({{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }})
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $order->total_quantity }}</td>
                                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('employee.orders.done', $order->items->first()->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Mark as Done
                                            </button>
                                        </form>
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
@endsection

@push('scripts')
<script>
    $(function () {
        $('#ordersTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endpush 