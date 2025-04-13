@extends('layouts.client.app')

@section('title', 'Detail Pesanan')

@include('client.components.client-styles')

@section('content')
    {{-- Main Container --}}
    <div class="container">
        <div class="card">
            <div class="card-body">
                {{-- Page Title --}}
                <h4 class="card-title mb-4">Detail Pesanan</h4>
                
                {{-- Order Information Section --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Informasi Pesanan</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>No. Pesanan</th>
                                <td>{{ $order->token }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    {{-- Status Badge with Conditional Color --}}
                                    <span class="badge badge-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'done' ? 'success' : 'danger') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Products List Section --}}
                <h5>Daftar Produk</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Loop through each item in the order --}}
                            @foreach($orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {{-- Total Amount --}}
                            <tr>
                                <th colspan="3" class="text-right">Total</th>
                                <th>Rp {{ number_format($orderItems->sum('total'), 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Back Button --}}
                <div class="mt-4">
                    <a href="{{ route('my-orders') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
                </div>
            </div>
        </div>
    </div>
@endsection 