@extends('layouts.main')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0"
        style="background-image: url('{{ asset('public/img/carousel-bg-2.jpg') }}');">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Profile Settings</h1>
                <p class="text-white fs-5">Manage your account information</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">

                <!-- Sidebar -->
                <div class="col-lg-3 col-md-4">
                    <div class="bg-light rounded p-4 mb-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center fw-bold fs-4"
                                style="width: 60px; height: 60px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                                <span class="text-muted small">{{ auth()->user()->email }}</span>
                            </div>
                        </div>

                        <div class="list-group list-group-flush">
                            <a href="{{ route('dashboard') }}"
                                class="list-group-item list-group-item-action bg-transparent border-0 mb-2">
                                <i class="fa fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}"
                                class="list-group-item list-group-item-action active bg-primary text-white border-primary rounded mb-2">
                                <i class="fa fa-user me-2"></i> Profile Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="list-group-item list-group-item-action text-danger bg-transparent border-0">
                                    <i class="fa fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9 col-md-8">

                    <!-- Success Alerts -->
                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="fa fa-check-circle me-2"></i> Profile information updated successfully!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if (session('status') === 'password-updated')
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="fa fa-check-circle me-2"></i> Password updated successfully!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Profile Information Card -->
                    <div class="bg-light rounded p-4 mb-4 wow fadeInUp" data-wow-delay="0.1s">
                        <h4 class="mb-1"><i class="fa fa-id-card text-primary me-2"></i>Profile Information</h4>
                        <p class="text-muted small mb-4">Update your name and email address.</p>

                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="form-floating mb-3">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    id="profileName" placeholder="Full Name" value="{{ old('name', $user->name) }}" required
                                    autocomplete="name">
                                <label for="profileName">Full Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    id="profileEmail" placeholder="Email Address" value="{{ old('email', $user->email) }}"
                                    required autocomplete="username">
                                <label for="profileEmail">Email Address</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                <div class="alert alert-warning small">
                                    <i class="fa fa-exclamation-circle me-2"></i>Your email address is unverified.
                                    <form id="send-verification" method="post" action="{{ route('verification.send') }}"
                                        class="d-inline">
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

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa fa-save me-2"></i>Save Changes
                            </button>
                        </form>
                    </div>

                    <!-- Change Password Card -->
                    <div class="bg-light rounded p-4 mb-4 wow fadeInUp" data-wow-delay="0.2s">
                        <h4 class="mb-1"><i class="fa fa-lock text-primary me-2"></i>Update Password</h4>
                        <p class="text-muted small mb-4">Use a long, random password to keep your account secure.</p>

                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="form-floating mb-3">
                                <input type="password" name="current_password"
                                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                    id="currentPassword" placeholder="Current Password" autocomplete="current-password">
                                <label for="currentPassword">Current Password</label>
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" name="password"
                                    class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                    id="newPassword" placeholder="New Password" autocomplete="new-password">
                                <label for="newPassword">New Password</label>
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="confirmNewPassword" placeholder="Confirm New Password" autocomplete="new-password">
                                <label for="confirmNewPassword">Confirm New Password</label>
                            </div>

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa fa-key me-2"></i>Update Password
                            </button>
                        </form>
                    </div>

                    <!-- Danger Zone Card -->
                    <div class="border border-danger rounded p-4 wow fadeInUp" data-wow-delay="0.3s">
                        <h4 class="mb-1 text-danger"><i class="fa fa-exclamation-triangle me-2"></i>Danger Zone</h4>
                        <p class="text-muted small mb-4">Once your account is deleted, all data is permanently removed. This
                            action cannot be undone.</p>

                        <button type="button" class="btn btn-outline-danger px-4" data-bs-toggle="modal"
                            data-bs-target="#deleteAccountModal">
                            <i class="fa fa-trash me-2"></i>Delete My Account
                        </button>
                    </div>

                </div><!-- end main content -->
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteAccountModalLabel">
                        <i class="fa fa-exclamation-triangle me-2"></i>Confirm Account Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-3">Are you absolutely sure? This will permanently delete your account and all associated
                        data.</p>
                    <form method="post" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                        @csrf
                        @method('delete')
                        <div class="form-floating mb-3">
                            <input type="password" name="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                id="deletePassword" placeholder="Your Password">
                            <label for="deletePassword">Enter your password to confirm</label>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                        <i class="fa fa-trash me-2"></i>Yes, Delete My Account
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection