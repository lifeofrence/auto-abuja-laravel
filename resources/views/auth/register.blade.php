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
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
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
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 15s ease-in-out infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
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
    .auth-sidebar .feature-list {
        margin-top: 30px;
        position: relative;
        z-index: 1;
    }
    .auth-sidebar .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .auth-sidebar .feature-item i {
        font-size: 1.2rem;
        margin-right: 15px;
        background: rgba(255,255,255,0.2);
        padding: 10px;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .auth-content {
        padding: 60px 50px;
        width: 60%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .form-floating { margin-bottom: 20px; }
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 15px;
        height: 55px;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #06A3DA;
        box-shadow: 0 0 0 0.2rem rgba(6,163,218,0.25);
    }
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 15px;
        height: 55px;
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
        box-shadow: 0 10px 20px rgba(6,163,218,0.3);
        color: white;
    }
    .divider {
        display: flex;
        align-items: center;
        margin: 30px 0;
        color: #6c757d;
    }
    .divider::before, .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e9ecef;
    }
    .divider span { padding: 0 15px; font-size: 0.9rem; }
    .forgot-password { text-align: right; margin-top: -10px; margin-bottom: 10px; }
    .forgot-password a { color: #06A3DA; text-decoration: none; font-size: 0.9rem; }
    .forgot-password a:hover { text-decoration: underline; }
    @media (max-width: 768px) {
        .auth-card { flex-direction: column; }
        .auth-sidebar, .auth-content { width: 100%; }
        .auth-sidebar { padding: 40px 30px; }
        .auth-content { padding: 40px 30px; }
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <!-- Sidebar -->
        <div class="auth-sidebar">
            <h2 class="text-white">Join A.R.T.S.P</h2>
            <p>Your trusted partner for all automotive needs in Abuja.</p>
            <div class="feature-list">
                <div class="feature-item">
                    <i class="fa fa-check-circle"></i>
                    <span>Access verified mechanics and workshops</span>
                </div>
                <div class="feature-item">
                    <i class="fa fa-check-circle"></i>
                    <span>Browse quality automotive products</span>
                </div>
                <div class="feature-item">
                    <i class="fa fa-check-circle"></i>
                    <span>Book services online</span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="auth-content">
            <h3 class="mb-4">Create Your Account</h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-floating">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="registerName"
                        placeholder="Full Name" value="{{ old('name') }}" required autofocus autocomplete="name">
                    <label for="registerName">Full Name</label>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-floating">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="registerEmail"
                        placeholder="Email Address" value="{{ old('email') }}" required autocomplete="username">
                    <label for="registerEmail">Email Address</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-floating">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="registerPassword"
                        placeholder="Password" required autocomplete="new-password">
                    <label for="registerPassword">Password</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-floating">
                    <input type="password" name="password_confirmation" class="form-control" id="registerPasswordConfirmation"
                        placeholder="Confirm Password" required autocomplete="new-password">
                    <label for="registerPasswordConfirmation">Confirm Password</label>
                </div>

                <!-- User Type/Role -->
                <div class="form-floating">
                    <select name="role" class="form-select @error('role') is-invalid @enderror" id="userRole" required>
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer (Vehicle Owner)</option>
                        <option value="business" {{ old('role') == 'business' ? 'selected' : '' }}>Business Owner (Mechanic/Dealer)</option>
                    </select>
                    <label for="userRole">I am a...</label>
                    @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-auth">
                    <i class="fa fa-user-plus me-2"></i> Register
                </button>
            </form>
            
            <div class="mt-4 text-center">
                <p class="text-muted">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold">Sign in here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
