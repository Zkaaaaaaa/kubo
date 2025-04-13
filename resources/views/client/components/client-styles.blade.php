@section('style')
    <style>
        /* Common Styles */
        .container {
            margin-bottom: 1.5rem;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 1.5rem 0;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }

        /* Card Styles */
        .card {
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            object-fit: cover;
            width: 100%;
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            line-height: 1.2;
        }

        .card-text {
            color: #e74c3c;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        /* Button Styles */
        .btn {
            border-radius: 4px;
            font-weight: 600;
            padding: 0.5rem;
            font-size: 0.9rem;
        }

        /* Tab Styles */
        .nav-tabs {
            border-bottom: none;
            margin-bottom: 0.5rem;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            padding: 0.5rem 1rem;
            font-weight: 500;
            position: relative;
            font-size: 0.9rem;
        }

        .nav-tabs .nav-link.active {
            color: #e74c3c;
            background: none;
        }

        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #e74c3c;
        }

        .nav-tabs .nav-link:hover {
            color: #e74c3c;
        }

        /* Grid Styles */
        .product-grid {
            margin: -0.375rem;
        }

        .product-grid .col {
            padding: 0.375rem;
        }

        /* Table Styles */
        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .table td {
            vertical-align: middle;
        }

        /* Form Styles */
        .form-control {
            border-radius: 4px;
            padding: 0.5rem 0.75rem;
        }

        .form-control:focus {
            border-color: #e74c3c;
            box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.25);
        }

        /* Responsive Styles */
        @media (max-width: 991.98px) {
            .hero-section {
                padding: 1.25rem 0;
            }
            
            .card-img-top {
                height: 160px;
            }
        }

        @media (max-width: 767.98px) {
            .hero-section {
                padding: 1rem 0;
            }
            
            .card-img-top {
                height: 140px;
            }
            
            .card-body {
                padding: 0.75rem;
            }
            
            .card-title {
                font-size: 0.9rem;
            }
            
            .card-text {
                font-size: 1rem;
            }
            
            .nav-tabs .nav-link {
                padding: 0.4rem 0.75rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 575.98px) {
            .card-img-top {
                height: 120px;
            }
            
            .card-body {
                padding: 0.5rem;
            }
            
            .btn {
                padding: 0.4rem;
                font-size: 0.8rem;
            }
        }
    </style>
@endsection 