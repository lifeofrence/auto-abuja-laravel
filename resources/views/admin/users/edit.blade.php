@extends('layouts.admin')

@section('admin_content')
    <div class="page-header d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1">Edit User Account: {{ $user->name }}</h4>
            <p class="text-muted mb-0">Update account credentials and system access permissions</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-light">
            <i class="fa fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="admin-card">
                <div class="p-4">
                    <h5 class="fw-bold mb-4" style="font-size: 1rem;">Account Information</h5>
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label text-muted small">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required
                                style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required
                                style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}"
                                    style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">VIO User ID</label>
                                <input type="text" name="vio_user_id" class="form-control" value="{{ $user->vio_user_id }}"
                                    style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Account Status</label>
                                <select name="status" class="form-select" required
                                    style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="disabled" {{ $user->status == 'disabled' ? 'selected' : '' }}>Disabled
                                    </option>
                                    <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">License Status</label>
                                <select name="license_status" class="form-select"
                                    style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                                    <option value="Valid" {{ $user->license_status == 'Valid' ? 'selected' : '' }}>Valid
                                    </option>
                                    <option value="Expired" {{ $user->license_status == 'Expired' ? 'selected' : '' }}>Expired
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small">System Role</label>
                            <select name="role" class="form-select" required
                                style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Regular User</option>
                                <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>Business Vendor
                                </option>
                                <option value="support" {{ $user->role == 'support' ? 'selected' : '' }}>Support Agent
                                </option>
                                <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>Content Moderator
                                </option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>System Administrator
                                </option>
                                <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super
                                    Administrator</option>
                            </select>
                            @if($user->id === auth()->id())
                                <p class="text-danger small mt-1"><i class="fa fa-info-circle me-1"></i> You cannot change your
                                    own role.</p>
                                <input type="hidden" name="role" value="{{ $user->role }}">
                            @endif
                        </div>

                        <button type="submit" class="btn w-100"
                            style="background: var(--primary-color, #F68B1E); color: #fff; border: none; padding: 12px; font-weight: 600; border-radius: 8px;">
                            <i class="fa fa-save me-1"></i> Update Account
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="admin-card">
                <div class="p-4">
                    <h5 class="fw-bold mb-4" style="font-size: 1rem;">Security Overview</h5>
                    <div class="mb-4 d-flex align-items-center gap-3 p-3 bg-light" style="border-radius: 12px;">
                        <i class="fa fa-shield-alt text-primary fa-2x"></i>
                        <div>
                            <div class="fw-bold text-dark">Password Security</div>
                            <div class="text-muted small">User manages their own password locally.</div>
                        </div>
                    </div>
                    <div class="p-4 mb-4"
                        style="background: rgba(220, 53, 69, 0.05); border: 1px solid rgba(220, 53, 69, 0.2); border-left: 4px solid #dc3545; border-radius: 12px;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div>
                                <h6 class="fw-bold mb-1 text-danger"><i class="fa fa-shield-alt me-1"></i>Reset Password
                                </h6>
                                <p class="text-muted small mb-0">Instantly reset password to default:
                                    <strong>12345678</strong>
                                </p>
                            </div>
                            <form action="{{ route('admin.users.reset_password', $user->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to reset this user\'s password to 12345678?');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold">
                                    <i class="fa fa-key me-1"></i> Force Reset
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="alert alert-info border-0"
                        style="border-radius: 12px; background: #eaf0ff; color: #4f6ef7;">
                        <div class="d-flex gap-2">
                            <i class="fa fa-info-circle mt-1"></i>
                            <div class="small">Modifying a user's role affects their system permissions immediately. Ensure
                                you speak with the vendor before reducing their access level.</div>
                        </div>
                    </div>

                    <h5 class="fw-bold mt-5 mb-3" style="font-size: 1rem;"><i
                            class="fa fa-info-circle me-1 text-primary"></i> Role Definitions</h5>
                    <div class="small text-muted p-3 bg-light" style="border-radius: 12px;">
                        <div class="mb-2"><strong>Super Admin:</strong> Full, unrestricted access to all areas of the
                            platform.</div>
                        <div class="mb-2"><strong>Moderator:</strong> Focused on content and business oversight. Can manage
                            Listings, Businesses, and Categories, but cannot manage Users.</div>
                        <div><strong>Support:</strong> Focused on vendor assistance. Can manage Listings and Businesses, but
                            cannot edit Categories or Users.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection