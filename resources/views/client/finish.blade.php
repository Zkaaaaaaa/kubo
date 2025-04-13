@extends('layouts.client.app')

@section('title', 'Kubo')

@section('style')
    <style>
        .success-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }
        .success-icon {
            animation: scaleIn 0.5s ease-in-out, float 3s ease-in-out infinite;
            color: #28a745;
            margin-bottom: 30px;
            position: relative;
        }
        .success-icon svg {
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }
        .success-title {
            animation: slideUp 0.5s ease-in-out;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .success-message {
            animation: slideUp 0.5s ease-in-out 0.2s;
            animation-fill-mode: both;
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }
        .home-button {
            animation: slideUp 0.5s ease-in-out 0.4s;
            animation-fill-mode: both;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            background: linear-gradient(45deg, #4e73df, #224abe);
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .home-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        @keyframes checkmark {
            0% { stroke-dashoffset: 100; }
            100% { stroke-dashoffset: 0; }
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="success-container">
            <!-- Icon Success -->
            <div class="success-icon">
                <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="45" stroke="#28a745" stroke-width="8" fill="none"/>
                    <path d="M30 50 L45 65 L70 35" stroke="#28a745" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" 
                          style="stroke-dasharray: 100; stroke-dashoffset: 100; animation: checkmark 0.5s ease-in-out 0.5s forwards;"/>
                </svg>
            </div>
            <!-- Title -->
            <h1 class="success-title">Checkout Berhasil!</h1>
            <!-- Message -->
            <p class="success-message">Terima kasih telah berbelanja bersama kami. Pesanan Anda sedang diproses.</p>
            <!-- Button -->
            <a href="{{ route('home') }}" class="btn home-button text-white">
                Kembali ke Home
            </a>
        </div>
    </div>
@endsection