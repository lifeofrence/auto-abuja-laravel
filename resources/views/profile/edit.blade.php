@extends('layouts.vendor')

@section('vendor_content')
    <!-- Profile Information Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <div class="d-flex align-items-center mb-4">
            <div class="bg-primary-subtle p-3 rounded-circle me-3">
                <i class="fa fa-id-card text-primary fs-4"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0">Profile Information</h4>
                <p class="text-muted mb-0">Update your account name and email address</p>
            </div>
        </div>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="profileName" placeholder="Full Name" value="{{ old('name', $user->name) }}" required
                            autocomplete="name">
                        <label for="profileName">Full Name</label>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="profileEmail" placeholder="Email Address" value="{{ old('email', $user->email) }}" required
                            autocomplete="username">
                        <label for="profileEmail">Email Address</label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            id="profilePhone" placeholder="Phone Number" value="{{ old('phone', $user->phone) }}">
                        <label for="profilePhone">Phone Number</label>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating mb-3">
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                            id="profileAddress" placeholder="Residential Address"
                            style="height: 100px">{{ old('address', $user->address) }}</textarea>
                        <label for="profileAddress">Residential Address</label>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="alert alert-warning small border-0 shadow-sm">
                    <i class="fa fa-exclamation-circle me-2"></i>Your email address is unverified.
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 small">Click here to re-send the
                            verification email.</button>
                    </form>
                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-2 text-success">A new verification link has been sent to your email address.
                        </div>
                    @endif
                </div>
            @endif

            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm mt-2">
                <i class="fa fa-save me-2"></i>Save Changes
            </button>
        </form>
    </div>

    <!-- Password Update Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4" id="password-section">
        <div class="d-flex align-items-center mb-4">
            <div class="bg-primary-subtle p-3 rounded-circle me-3">
                <i class="fa fa-lock text-primary fs-4"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0">Security Settings</h4>
                <p class="text-muted mb-0">Update your password to stay secure</p>
            </div>
        </div>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="row g-3">
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input type="password" name="current_password"
                            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                            id="currentPassword" placeholder="Current Password" autocomplete="current-password">
                        <label for="currentPassword">Current Password</label>
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="password" name="password"
                            class="form-control @error('password', 'updatePassword') is-invalid @enderror" id="newPassword"
                            placeholder="New Password" autocomplete="new-password">
                        <label for="newPassword">New Password</label>
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="password" name="password_confirmation" class="form-control" id="confirmNewPassword"
                            placeholder="Confirm New Password" autocomplete="new-password">
                        <label for="confirmNewPassword">Confirm New Password</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm mt-2">
                <i class="fa fa-key me-2"></i>Update Password
            </button>
        </form>
    </div>
@endsection