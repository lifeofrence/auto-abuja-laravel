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
            min-height: 500px;
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

        .form-floating {
            margin-bottom: 10px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            height: 55px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #06A3DA;
            box-shadow: 0 0 0 0.2rem rgba(6, 163, 218, 0.25);
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

        .info-text {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 30px;
        }

        .back-to-login {
            display: block;
            margin-top: 25px;
            text-align: center;
            color: #6c757d;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .back-to-login:hover {
            color: #06A3DA;
            text-decoration: underline;
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
                min-height: 200px;
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
                <h2 class="text-white">Recover Access</h2>
                <p>Don't worry, Let's get you back inside.</p>
                <i class="fa fa-key"></i>
            </div>

            <!-- Content -->
            <div class="auth-content">
                <h3 class="mb-3 fw-bold">Forgot Password?</h3>
                <p class="info-text">
                    Enter your registered email address below and we will send you a secure link to reset your password.
                </p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="success-alert">
                        <i class="fa fa-check-circle me-2"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="forgotEmail" placeholder="Email Address" value="{{ old('email') }}" required autofocus
                            autocomplete="username">
                        <label for="forgotEmail">Your Email Address</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-auth">
                        <i class="fa fa-paper-plane me-2"></i> Send Reset Link
                    </button>
                </form>

                <a href="{{ route('login') }}" class="back-to-login">
                    <i class="fa fa-arrow-left me-1"></i> Back to Login
                </a>
            </div>
        </div>
    </div>
@endsection