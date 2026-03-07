@extends('layouts.admin')

@section('admin_content')
    <div class="user-profile-wrapper animate-fade-in">
        <!-- Premium Header -->
        <div class="profile-header-premium mb-5">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="header-avatar-ring">
                        <div class="header-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    <div>
                        <h2 class="profile-name fw-bold mb-1">{{ $user->name }}</h2>
                        <div class="d-flex align-items-center gap-2">
                            <span class="role-pill">{{ ucfirst($user->role) }}</span>
                            <span class="status-dot-active"></span>
                            <span class="text-muted small">Account {{ ucfirst($user->status ?: 'Active') }}</span>
                        </div>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn-glass secondary me-2">
                        <i class="fa fa-arrow-left me-2"></i> Return to Directory
                    </a>
                    <button class="btn-glass primary" onclick="document.getElementById('edit-account-tab').click()">
                        <i class="fa fa-magic me-2"></i> Quick Edit
                    </button>
                </div>
            </div>
        </div>

        <!-- Modern Tab System -->
        <div class="tabs-container-premium">
            <ul class="nav nav-pills custom-tabs mb-4" id="premiumUserTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview"
                        type="button" role="tab">
                        <i class="fa fa-th-large me-2"></i>Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="edit-account-tab" data-bs-toggle="tab" data-bs-target="#edit-account"
                        type="button" role="tab">
                        <i class="fa fa-user-shield me-2"></i>Account Security
                    </button>
                </li>
                @if($user->role == 'vendor')
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="edit-business-tab" data-bs-toggle="tab" data-bs-target="#edit-business"
                            type="button" role="tab">
                            <i class="fa fa-store me-2"></i>Business Profile
                        </button>
                    </li>
                @endif
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button"
                        role="tab">
                        <i class="fa fa-cubes me-2"></i>Inventory
                    </button>
                </li>
            </ul>

            <div class="tab-content pt-2" id="premiumTabContent">
                <!-- Overview Tab -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="premium-card">
                                <div class="card-glass-header">
                                    <h5 class="m-0 fw-bold fs-6">Contact Registry</h5>
                                </div>
                                <div class="p-4">
                                    <div class="info-item mb-4">
                                        <label>Official Email</label>
                                        <p class="mb-0 fw-semibold text-dark">{{ $user->email }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label>VIO User ID</label>
                                        <p class="mb-0 text-muted">{{ $user->vio_user_id ?: 'Not Integrated' }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label>License Authorization</label>
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            @if($user->license_status == 'Valid')
                                                <span class="auth-badge valid"><i class="fa fa-check-shield me-1"></i>
                                                    Authorized</span>
                                            @else
                                                <span class="auth-badge expired"><i class="fa fa-warning me-1"></i>
                                                    Expired</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <label>Registration Date</label>
                                        <p class="mb-0 text-muted">
                                            {{ $user->created_at ? $user->created_at->format('F d, Y') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            @if($user->business)
                                <div class="premium-card mb-4 overflow-hidden">
                                    <div class="business-banner">
                                        <div class="banner-overlay"></div>
                                        <div class="banner-content">
                                            <img src="{{ $user->business->logo_url }}" class="banner-logo">
                                            <div>
                                                <h3 class="m-0 text-white fw-bold">{{ $user->business->business_name }}</h3>
                                                <p class="m-0 text-white-50"><i class="fa fa-map-marker-alt me-1"></i>
                                                    {{ $user->business->address }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div class="row g-4">
                                            <div class="col-md-4">
                                                <div class="stat-box text-center">
                                                    <label>Industry</label>
                                                    <div class="stat-val">{{ $user->business->category->name ?? 'Mixed' }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="stat-box text-center">
                                                    <label>Verification</label>
                                                    <div
                                                        class="stat-val {{ $user->business->verified ? 'text-success' : 'text-warning' }}">
                                                        {{ $user->business->verified ? 'Full Access' : 'In Review' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="stat-box text-center">
                                                    <label>Store Status</label>
                                                    <div class="stat-val text-primary">{{ ucfirst($user->business->status) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="empty-state-premium">
                                    <i class="fa fa-store-slash mb-3"></i>
                                    <h5>No Active Store Found</h5>
                                    <p>This user currently operates as a standard member without a business registry.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Edit Account Tab -->
                <div class="tab-pane fade" id="edit-account" role="tabpanel">
                    <div class="premium-card">
                        <div class="card-glass-header border-bottom">
                            <h5 class="m-0 fw-bold">Update System Credentials</h5>
                        </div>
                        <div class="p-4">
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="premium-label">Full Name</label>
                                        <div class="input-with-icon">
                                            <i class="fa fa-id-card"></i>
                                            <input type="text" name="name" class="premium-input"
                                                value="{{ old('name', $user->name) }}" required placeholder="Legal Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="premium-label">System Email</label>
                                        <div class="input-with-icon">
                                            <i class="fa fa-envelope"></i>
                                            <input type="email" name="email" class="premium-input"
                                                value="{{ old('email', $user->email) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="premium-label">Platform Role</label>
                                        <select name="role" class="premium-select" {{ $user->id == auth()->id() ? 'disabled' : '' }}>
                                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Standard User
                                            </option>
                                            <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>Verified
                                                Vendor</option>
                                            <option value="support" {{ $user->role == 'support' ? 'selected' : '' }}>Support
                                                Agent</option>
                                            <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>
                                                Content Moderator</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator
                                            </option>
                                            <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>
                                                Super Administrator</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="premium-label">License Status</label>
                                        <select name="license_status" class="premium-select">
                                            <option value="">Choose Status...</option>
                                            <option value="Valid" {{ $user->license_status == 'Valid' ? 'selected' : '' }}>
                                                Valid (Authorized)</option>
                                            <option value="Expired" {{ $user->license_status == 'Expired' ? 'selected' : '' }}>Expired (Restricted)</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="premium-btn">
                                            <i class="fa fa-save me-2"></i> Commit Account Changes
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div
                        class="premium-card mt-4 border-danger border-opacity-25 border-top-0 border-end-0 border-bottom-0 border-4">
                        <div class="card-glass-header border-bottom">
                            <h5 class="m-0 fw-bold text-danger"><i class="fa fa-shield-alt me-2"></i>Security Actions</h5>
                        </div>
                        <div class="p-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div>
                                    <h6 class="fw-bold mb-1">Reset User Password</h6>
                                    <p class="text-muted small mb-0">This will immediately reset the user's password to
                                        default: <strong>12345678</strong>.</p>
                                </div>
                                <form action="{{ route('admin.users.reset_password', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to reset this user\'s password to 12345678?');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">
                                        <i class="fa fa-key me-2"></i> Force Reset Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Business Tab -->
                @if($user->role == 'vendor')
                    <div class="tab-pane fade" id="edit-business" role="tabpanel">
                        <div class="premium-card">
                            <div class="card-glass-header border-bottom">
                                <h5 class="m-0 fw-bold">Business Registry Configuration</h5>
                            </div>
                            <div class="p-4">
                                <form action="{{ route('admin.users.update_business', $user->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf @method('PUT')
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <label class="premium-label">Corporate Brand Name</label>
                                            <input type="text" name="business_name" class="premium-input"
                                                value="{{ old('business_name', $user->business->business_name ?? '') }}"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="premium-label">Trade Category</label>
                                            <select name="category_id" id="admin_category_id" class="premium-select" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ ($user->business->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="premium-label">Subcategory</label>
                                            <select name="subcategory_id" id="admin_subcategory_id" class="premium-select">
                                                <option value="">Select Subcategory</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="premium-label">Public Phone Number</label>
                                            <input type="text" name="phone" class="premium-input"
                                                value="{{ old('phone', $user->business->phone ?? '') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="premium-label">WhatsApp Business Line</label>
                                            <input type="text" name="whatsapp" class="premium-input"
                                                value="{{ old('whatsapp', $user->business->whatsapp ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="premium-label">Business Email</label>
                                            <input type="email" name="email" class="premium-input"
                                                value="{{ old('email', $user->business->email ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="premium-label">Website URL</label>
                                            <input type="url" name="website" class="premium-input"
                                                value="{{ old('website', $user->business->website ?? '') }}">
                                        </div>

                                        <div class="col-12 text-primary fw-bold text-uppercase small border-bottom mb-2">
                                            Location & Branding</div>

                                        <div class="col-12">
                                            <label class="premium-label">Physical Address</label>
                                            <input type="text" name="address" class="premium-input"
                                                value="{{ old('address', $user->business->address ?? '') }}" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="premium-label">Google Maps Link</label>
                                            <input type="url" name="google_maps_link" class="premium-input"
                                                value="{{ old('google_maps_link', $user->business->google_maps_link ?? '') }}">
                                        </div>

                                        <div class="col-md-6">
                                            <div class="p-3 border border-dashed rounded bg-light text-center">
                                                <label class="premium-label mb-2">Business Logo</label>
                                                @if($user->business && $user->business->logo)
                                                    <img src="{{ $user->business->logo_url }}"
                                                        class="rounded shadow-sm mb-2 d-block mx-auto"
                                                        style="height: 60px; width: 60px; object-fit: cover;">
                                                @endif
                                                <input type="file" name="logo" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 border border-dashed rounded bg-light text-center">
                                                <label class="premium-label mb-2">Profile Banner</label>
                                                @if($user->business && $user->business->cover_image)
                                                    <img src="{{ $user->business->image_url }}"
                                                        class="rounded shadow-sm mb-2 d-block mx-auto"
                                                        style="height: 60px; width: 100%; object-fit: cover;">
                                                @endif
                                                <input type="file" name="cover_image" class="form-control form-control-sm">
                                            </div>
                                        </div>

                                        <div class="col-12 text-primary fw-bold text-uppercase small border-bottom mb-2">
                                            Operation Hours</div>
                                        <div class="col-12">
                                            <div class="row g-2">
                                                @php
                                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                                    $hoursArr = (is_array($user->business->business_hours ?? null)) ? $user->business->business_hours : (isset($user->business->business_hours) ? json_decode($user->business->business_hours, true) : []);
                                                @endphp
                                                @foreach($days as $day)
                                                    <div class="col-md-4">
                                                        <div class="bg-white p-2 rounded border">
                                                            <div class="small fw-bold">{{ $day }}</div>
                                                            <div class="d-flex gap-1 mt-1">
                                                                <input type="text" name="business_hours[{{ $day }}][open]"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $hoursArr[$day]['open'] ?? '08:00 AM' }}">
                                                                <input type="text" name="business_hours[{{ $day }}][close]"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $hoursArr[$day]['close'] ?? '06:00 PM' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="premium-label">Market Bio</label>
                                            <textarea name="description" class="premium-textarea"
                                                rows="4">{{ old('description', $user->business->description ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="premium-label">Moderation Approval Path</label>
                                            <select name="status" class="premium-select" required>
                                                <option value="pending" {{ ($user->business->status ?? '') == 'pending' ? 'selected' : '' }}>Waitlisted (Pending)</option>
                                                <option value="approved" {{ ($user->business->status ?? '') == 'approved' ? 'selected' : '' }}>Active Listing (Approved)</option>
                                                <option value="rejected" {{ ($user->business->status ?? '') == 'rejected' ? 'selected' : '' }}>Rejected Access</option>
                                                <option value="disabled" {{ ($user->business->status ?? '') == 'disabled' ? 'selected' : '' }}>Terminated (Disabled)</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mt-4 text-center">
                                            <button type="submit" class="premium-btn w-100">
                                                <i class="fa fa-save me-2"></i> Commit Global Business Registry Changes
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Products Tab -->
                <div class="tab-pane fade" id="products" role="tabpanel">
                    <div class="premium-card">
                        <div class="card-glass-header border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-bold">Live Product Catalog ({{ $user->products->count() }})</h5>
                            <a href="{{ route('admin.products.index', ['search' => $user->name]) }}"
                                class="btn-glass secondary sm">
                                Full Inventory View
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table mb-0 premium-table">
                                <thead>
                                    <tr>
                                        <th>Product Identity</th>
                                        <th>Department</th>
                                        <th>Unit Price</th>
                                        <th>Availability</th>
                                        <th class="text-end">Insight</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($user->products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="table-img-box">
                                                        <img src="{{ $product->image_url }}">
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold product-title">{{ $product->name }}</div>
                                                        <div class="small text-muted">
                                                            {{ Str::limit($product->description, 30) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="dept-label">{{ $product->category->name ?? 'N/A' }}</span></td>
                                            <td>
                                                <div class="price-val">₦{{ number_format($product->price) }}</div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-between gap-2">
                                                    <div class="d-flex align-items-center">
                                                        @if($product->is_available)
                                                            <span class="dot-status active"></span>
                                                            <span class="small fw-semibold text-success">Live on Marketplace</span>
                                                        @else
                                                            <span class="dot-status inactive"></span>
                                                            <span class="small fw-semibold text-muted">Hidden from Public</span>
                                                        @endif
                                                    </div>
                                                    <form action="{{ route('admin.products.toggle', $product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm {{ $product->is_available ? 'btn-outline-secondary' : 'btn-primary' }} py-1 px-2"
                                                            style="font-size: 0.7rem; border-radius: 8px;">
                                                            @if($product->is_available)
                                                                <i class="fa fa-eye-slash me-1"></i> Hide
                                                            @else
                                                                <i class="fa fa-rocket me-1"></i> Make Live
                                                            @endif
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                                                    class="circle-btn">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="empty-inventory">
                                                    <i class="fa fa-box-open fa-3x mb-3 text-muted opacity-25"></i>
                                                    <p class="text-muted">No cataloged products found for this profile.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --premium-primary: #F68B1E;
            --premium-bg: #f8fafc;
            --premium-glass: rgba(255, 255, 255, 0.9);
            --premium-text: #1e293b;
            --premium-border: #e2e8f0;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header Styling */
        .profile-header-premium {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--premium-border);
        }

        .header-avatar-ring {
            padding: 4px;
            border: 2px solid #eef2ff;
            border-radius: 50%;
        }

        .header-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #4f6ef7, #7c94ff);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 800;
            border-radius: 50%;
        }

        .profile-name {
            color: var(--premium-text);
            font-size: 1.75rem;
        }

        .role-pill {
            background: #f1f5f9;
            color: #475569;
            padding: 4px 12px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            text-uppercase: uppercase;
        }

        .status-dot-active {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            display: inline-block;
        }

        /* Tabs Styling */
        .custom-tabs {
            gap: 10px;
        }

        .custom-tabs .nav-link {
            border-radius: 12px !important;
            border: 1px solid transparent;
            color: #64748b;
            font-weight: 600;
            padding: 12px 24px;
            transition: all 0.3s;
        }

        .custom-tabs .nav-link.active {
            background: var(--premium-primary) !important;
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(246, 139, 30, 0.3);
        }

        .custom-tabs .nav-link:hover:not(.active) {
            background: white;
            border-color: var(--premium-border);
            color: var(--premium-primary);
        }

        /* Card Styling */
        .premium-card {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--premium-border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            height: 100%;
            transition: transform 0.3s;
        }

        .premium-card:hover {
            transform: translateY(-2px);
        }

        .card-glass-header {
            background: #f8fafc;
            padding: 18px 24px;
        }

        /* Business Banner */
        .business-banner {
            height: 160px;
            position: relative;
            background: url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&q=80&w=1469') center/cover;
        }

        .banner-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.8), transparent);
        }

        .banner-content {
            position: relative;
            z-index: 1;
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            height: 100%;
        }

        .banner-logo {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 15px;
            border: 3px solid rgba(255, 255, 255, 0.2);
        }

        /* Form Styling */
        .premium-label {
            font-weight: 700;
            color: #475569;
            font-size: 0.8rem;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .premium-input,
        .premium-select,
        .premium-textarea {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: #f8fafc;
        }

        .premium-input:focus,
        .premium-select:focus,
        .premium-textarea:focus {
            outline: none;
            border-color: var(--premium-primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(246, 139, 30, 0.1);
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 15px;
            color: #94a3b8;
        }

        .input-with-icon input {
            padding-left: 45px;
        }

        /* Badges */
        .auth-badge {
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
        }

        .auth-badge.valid {
            background: #ecfdf5;
            color: #059669;
        }

        .auth-badge.expired {
            background: #fef2f2;
            color: #dc2626;
        }

        /* Buttons */
        .btn-glass {
            border-radius: 12px;
            padding: 11px 24px;
            font-weight: 700;
            font-size: 0.85rem;
            border: 1px solid transparent;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
        }

        .btn-glass.primary {
            background: var(--premium-primary);
            color: white;
        }

        .btn-glass.secondary {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-glass:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }

        .premium-btn {
            background: var(--premium-primary);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            transition: all 0.3s;
        }

        .premium-btn.success {
            background: #10b981;
        }

        .premium-btn:hover {
            background: #1a1a1a;
        }

        /* Table Styling */
        .premium-table thead th {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            color: #64748b;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 800;
            padding: 15px 24px;
        }

        .premium-table tbody td {
            padding: 20px 24px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-img-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            overflow: hidden;
            background: #f1f5f9;
        }

        .table-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dept-label {
            background: #eff6ff;
            color: #3b82f6;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.7rem;
        }

        .dot-status {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .dot-status.active {
            background: #10b981;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
        }

        .dot-status.inactive {
            background: #94a3b8;
        }

        .circle-btn {
            width: 36px;
            height: 36px;
            background: #f8fafc;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
            text-decoration: none;
        }

        .circle-btn:hover {
            background: var(--premium-primary);
            color: white;
        }

        /* Stat Box */
        .stat-box {
            padding: 15px;
            border-radius: 15px;
            background: #f8fafc;
            border: 1px solid #eef2f6;
        }

        .stat-box label {
            font-size: 0.65rem;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            display: block;
            margin-bottom: 5px;
        }

        .stat-val {
            font-size: 1rem;
            font-weight: 800;
            color: #1e293b;
        }

        /* Empty States */
        .empty-state-premium {
            text-align: center;
            padding: 60px 40px;
            background: white;
            border-radius: 20px;
            border: 2px dashed #e2e8f0;
        }

        .empty-state-premium i {
            font-size: 3rem;
            color: #cbd5e1;
        }
    </style>
    @push('scripts')
        <script>
            $(document).ready(function () {
                const categorySelect = $('#admin_category_id');
                const subcategorySelect = $('#admin_subcategory_id');
                const initialCategoryId = categorySelect.val();
                const initialSubcategoryId = "{{ old('subcategory_id', $user->business->subcategory_id ?? '') }}";

                if (initialCategoryId) {
                    loadSubcategories(initialCategoryId, initialSubcategoryId);
                }

                categorySelect.on('change', function () {
                    loadSubcategories($(this).val());
                });

                function loadSubcategories(categoryId, selectedId = null) {
                    if (!categoryId) {
                        subcategorySelect.empty().append('<option value="">Select Subcategory</option>');
                        return;
                    }
                    subcategorySelect.empty().append('<option value="">Loading...</option>');
                    $.ajax({
                        url: `/vendor/subcategories/${categoryId}`,
                        type: 'GET',
                        success: function (data) {
                            subcategorySelect.empty().append('<option value="">Select Subcategory</option>');
                            $.each(data, function (key, value) {
                                subcategorySelect.append(`<option value="${value.id}" ${selectedId == value.id ? 'selected' : ''}>${value.name}</option>`);
                            });
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection