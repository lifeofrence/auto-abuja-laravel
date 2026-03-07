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
            min-height: 550px;
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
            margin-bottom: 20px;
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
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(6, 163, 218, 0.3);
            color: white;
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
                <h2 class="text-white">New Password</h2>
                <p>Ready for a fresh start? Set your new secure password below to regain full access.</p>
                <i class="fa fa-lock-open"></i>
            </div>

            <!-- Content -->
            <div class="auth-content">
                <h3 class="mb-4 fw-bold">Reset Your Password</h3>

            <!-- Session Status -->
            @if (session('status'))
                <div class="success-alert">
                    <i class="fa fa-check-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="resetEmail" placeholder="Email Address" value="{{ old('email', $request->email) }}" required
                            readonly autocomplete="username">
                        <label for="resetEmail">Email Address</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-floating">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            id="resetPassword" placeholder="New Password" required autocomplete="new-password" autofocus>
                        <label for="resetPassword">New Password</label>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-floating">
                        <input type="password" name="password_confirmation" class="form-control" id="resetConfirmPassword"
                            placeholder="Confirm New Password" required autocomplete="new-password">
                        <label for="resetConfirmPassword">Confirm New Password</label>
                    </div>

                    <button type="submit" class="btn btn-auth">
                        <i class="fa fa-sync-alt me-2"></i> Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection