@extends('layouts.main')

@section('content')
    <style>
        .auth-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e3a5f 0%, #2c5f8d 50%, #06A3DA 100%);
            padding: 80px 20px;
        }

        .auth-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
            min-height: 450px;
        }

        .auth-sidebar {
            background: linear-gradient(135deg, #06A3DA 0%, #1e3a5f 100%);
            color: white;
            padding: 60px 40px;
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-sidebar::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .auth-sidebar h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
            color: white;
        }

        .auth-sidebar p {
            font-size: 1.1rem;
            opacity: 0.95;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        .auth-sidebar i {
            font-size: 5rem;
            opacity: 0.15;
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        .auth-content {
            padding: 60px 50px;
            width: 60%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .btn-auth {
            background: linear-gradient(135deg, #06A3DA 0%, #1e3a5f 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(6, 163, 218, 0.3);
            color: white;
        }

        .btn-logout {
            background: transparent;
            color: #6c757d;
            border: 2px solid #e9ecef;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #f8f9fa;
            color: #dc3545;
            border-color: #dc3545;
        }

        .info-text {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .success-alert {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            border-left: 5px solid #28a745;
        }

        @media (max-width: 768px) {
            .auth-card {
                flex-direction: column;
            }

            .auth-sidebar,
            .auth-content {
                width: 100%;
            }

            .auth-sidebar {
                padding: 40px 30px;
                min-height: 150px;
            }

            .auth-content {
                padding: 40px 30px;
            }
        }
    </style>

    <div class="auth-container">
        <div class="auth-card animate-fade-in">
            <!-- Sidebar -->
            <div class="auth-sidebar text-center">
                <h2 class="text-white">Verify Email</h2>
                <p>Welcome to the family! Just one quick step to secure your account and unlock full access.</p>
                <i class="fa fa-envelope-open-text"></i>
            </div>

            <!-- Content -->
            <div class="auth-content">
                <h3 class="mb-3 fw-bold">Almost There!</h3>

                <p class="info-text">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                    link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="success-alert">
                        <i class="fa fa-check-circle me-2"></i>
                        A new verification link has been sent to the email address you provided during registration.
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-auth">
                        <i class="fa fa-sync-alt me-2"></i> Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-logout">
                        <i class="fa fa-sign-out-alt me-2"></i> Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection