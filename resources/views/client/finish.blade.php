@extends('layouts.client.app')

@section('title', 'Kubo')

@section('content')
    <div class="container text-center mt-5">
        <!-- Icon Success -->
        <div class="text-success mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                <path d="M10.97 6.03a.75.75 0 0 1 1.08 1.04l-3 4a.75.75 0 0 1-1.08.02l-2-2.5a.75.75 0 1 1 1.16-.96l1.47 1.84 2.37-3.16z"/>
            </svg>
        </div>
        <!-- Title -->
        <h1 class="mb-4">Checkout Berhasil!</h1>
        <!-- Message -->
        <p class="mb-4">Terima kasih telah berbelanja bersama kami. Pesanan Anda telah berhasil diproses.</p>
        <!-- Button -->
        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Kembali ke Home</a>
    </div>
    @endsection