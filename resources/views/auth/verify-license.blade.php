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

        .auth-sidebar h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
            color: white;
        }

        .auth-sidebar p {
            font-size: 1rem;
            opacity: 0.9;
            line-height: 1.6;
            position: relative;
            z-index: 1;
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
            }

            .auth-content {
                padding: 40px 30px;
            }
        }
    </style>

    <div class="auth-container">
        <div class="auth-card">
            <!-- Sidebar -->
            <div class="auth-sidebar">
                <h2 class="text-white">Verify Your License</h2>
                <p>To join A.R.T.S.P, please provide your Trade License/Portal ID for verification.</p>
            </div>

            <!-- Content -->
            <div class="auth-content">
                <h3 class="mb-4">Portal ID Verification</h3>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verify-license.post') }}">
                    @csrf


                    <!-- Portal ID/Trade License Number -->
                    <div class="form-floating">
                        <input type="text" name="portal_id" class="form-control @error('portal_id') is-invalid @enderror"
                            id="portal_id" placeholder="Portal ID / Trade License Number" value="{{ old('portal_id') }}"
                            required autofocus>
                        <label for="portal_id">Portal ID / Trade License Number</label>
                        @error('portal_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-auth">
                        <i class="fa fa-shield-alt me-2"></i> Verify and Register
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <p class="text-muted">Already have an account? <a href="{{ route('login') }}"
                            class="text-primary fw-bold">Sign in here</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection