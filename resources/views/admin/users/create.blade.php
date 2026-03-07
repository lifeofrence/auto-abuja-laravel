@extends('layouts.admin')

@section('admin_content')
    <div class="page-header mb-5">
        <a href="{{ route('admin.users.index') }}" class="text-muted text-decoration-none small mb-2 d-inline-block">
            <i class="fa fa-arrow-left me-1"></i> Back to Users
        </a>
        <h4>Create New Account</h4>
        <p class="text-muted">Register a new user or vendor manually in the system</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="admin-card p-4 p-md-5">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase"
                                style="letter-spacing:1px; color:#94a3b8;">Full Name</label>
                            <div class="input-with-icon position-relative">
                                <i class="fa fa-user position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                <input type="text" name="name"
                                    class="form-control py-3 ps-5 border-0 bg-light rounded-3 @error('name') is-invalid @enderror"
                                    placeholder="e.g. John Doe" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase"
                                style="letter-spacing:1px; color:#94a3b8;">Email Address</label>
                            <div class="input-with-icon position-relative">
                                <i class="fa fa-envelope position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                <input type="email" name="email"
                                    class="form-control py-3 ps-5 border-0 bg-light rounded-3 @error('email') is-invalid @enderror"
                                    placeholder="john@example.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase"
                                style="letter-spacing:1px; color:#94a3b8;">System Role</label>
                            <div class="input-with-icon position-relative">
                                <i
                                    class="fa fa-user-shield position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                <select name="role"
                                    class="form-select py-3 ps-5 border-0 bg-light rounded-3 @error('role') is-invalid @enderror"
                                    required>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Standard User</option>
                                    <option value="vendor" {{ old('role') == 'vendor' ? 'selected' : '' }}>Verified Vendor
                                    </option>
                                    <option value="support" {{ old('role') == 'support' ? 'selected' : '' }}>Support Agent
                                    </option>
                                    <option value="moderator" {{ old('role') == 'moderator' ? 'selected' : '' }}>Moderator
                                    </option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator
                                    </option>
                                    <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super
                                        Administrator</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase"
                                style="letter-spacing:1px; color:#94a3b8;">Password</label>
                            <div class="input-with-icon position-relative">
                                <i class="fa fa-lock position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                <input type="password" name="password"
                                    class="form-control py-3 ps-5 border-0 bg-light rounded-3 @error('password') is-invalid @enderror"
                                    placeholder="Minimum 8 characters" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase"
                                style="letter-spacing:1px; color:#94a3b8;">Confirm Password</label>
                            <div class="input-with-icon position-relative">
                                <i class="fa fa-lock position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                <input type="password" name="password_confirmation"
                                    class="form-control py-3 ps-5 border-0 bg-light rounded-3" placeholder="Repeat password"
                                    required>
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-sm"
                                style="background:#1a1a2e; border:none;">
                                <i class="fa fa-save me-2"></i> Create Account
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card p-4">
                <h6 class="fw-bold mb-3"><i class="fa fa-info-circle me-2 text-primary"></i> Registration Tips</h6>
                <ul class="small text-muted ps-3 mb-0" style="line-height:2;">
                    <li><strong>Vendor Accounts</strong>: After creating a vendor, they should log in to complete their
                        business profile under "Business Setup".</li>
                    <li><strong>Email Uniqueness</strong>: Every user must have a unique email address not already in the
                        system.</li>
                    <li><strong>Initial Password</strong>: Ensure you provide the password to the user securely after
                        creation.</li>
                    <li><strong>License Status</strong>: Manually created accounts are set to "Active" status by default.
                    </li>
                </ul>

                <h6 class="fw-bold mt-4 mb-3"><i class="fa fa-shield-alt me-2 text-primary"></i> Role Definitions</h6>
                <div class="small text-muted">
                    <div class="mb-2"><strong>Super Admin:</strong> Full, unrestricted access to all areas of the platform.</div>
                    <div class="mb-2"><strong>Moderator:</strong> Focused on content and business oversight. Can manage Listings, Businesses, and Categories, but cannot manage Users.</div>
                    <div><strong>Support:</strong> Focused on vendor assistance. Can manage Listings and Businesses, but cannot edit Categories or Users.</div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus,
        .form-select:focus {
            background-color: #fff !important;
            box-shadow: 0 0 0 4px rgba(26, 26, 46, 0.05) !important;
            border: 1px solid #e2e8f0 !important;
        }
    </style>
@endsection