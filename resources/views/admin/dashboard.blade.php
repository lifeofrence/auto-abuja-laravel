@extends('layouts.admin')

@section('admin_content')

    @php
        $totalVendors = \App\Models\User::where('role', 'vendor')->count();
        $totalUsers = \App\Models\User::where('role', 'user')->count();
        $activeListings = \App\Models\Product::where('is_available', true)->count();
        $pendingBiz = \App\Models\Business::where('status', 'pending')->count();
        $approvedBiz = \App\Models\Business::where('status', 'approved')->count();
        $totalCategories = \App\Models\Category::count();
        $totalAll = \App\Models\User::count();
    @endphp

    <!-- Page Title -->
    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="font-size: 1.5rem;">Dashboard</h4>
        <p class="text-muted" style="font-size: 0.875rem;">Welcome back, <strong>{{ auth()->user()->name }}</strong>! Here's
            what's happening on Auto Abuja.</p>
    </div>

    <!-- Stats Grid — 3 per row on medium+, 1 on mobile -->
    <div class="row g-3 mb-4">

        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eaf0ff; color:#4f6ef7;"><i class="fa fa-store"></i></div>
                <div class="stat-label">Total Vendors</div>
                <div class="stat-value">{{ $totalVendors }}</div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#edfaf1; color:#34c76f;"><i class="fa fa-users"></i></div>
                <div class="stat-label">Registered Users</div>
                <div class="stat-value">{{ $totalAll }}</div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fff8ec; color:#F68B1E;"><i class="fa fa-shopping-bag"></i></div>
                <div class="stat-label">Active Listings</div>
                <div class="stat-value">{{ $activeListings }}</div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fff2f2; color:#ff6b6b;"><i class="fa fa-clock"></i></div>
                <div class="stat-label">Pending Approvals</div>
                <div class="stat-value">{{ $pendingBiz }}</div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#edfaf1; color:#34c76f;"><i class="fa fa-check-circle"></i></div>
                <div class="stat-label">Approved Businesses</div>
                <div class="stat-value">{{ $approvedBiz }}</div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f3efff; color:#7c3aed;"><i class="fa fa-tags"></i></div>
                <div class="stat-label">Categories</div>
                <div class="stat-value">{{ $totalCategories }}</div>
            </div>
        </div>

    </div>

    <!-- Recent Business Registrations -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h6 class="fw-bold mb-0">Recent Business Registrations</h6>
                <p class="text-muted small mb-0">Latest businesses pending review</p>
            </div>
            <a href="{{ route('admin.businesses.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                style="font-size:0.8rem;">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0 admin-table">
                <thead>
                    <tr>
                        <th>Business</th>
                        <th>Vendor</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Business::with(['user', 'category'])->latest()->take(6)->get() as $biz)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="biz-avatar">{{ strtoupper(substr($biz->business_name, 0, 1)) }}</div>
                                    <div>
                                        <div class="fw-semibold" style="font-size:0.875rem;">{{ $biz->business_name }}</div>
                                        <div class="text-muted" style="font-size:0.75rem;">{{ Str::limit($biz->address, 28) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:0.875rem;">{{ $biz->user->name ?? 'N/A' }}</td>
                            <td><span class="cat-badge">{{ $biz->category->name ?? 'General' }}</span></td>
                            <td>
                                @if($biz->status == 'approved')
                                    <span class="status-badge" style="background:#edfaf1;color:#34c76f;">Approved</span>
                                @elseif($biz->status == 'pending')
                                    <span class="status-badge" style="background:#fff8ec;color:#F68B1E;">Pending</span>
                                @else
                                    <span class="status-badge" style="background:#fff2f2;color:#ff6b6b;">Suspended</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($biz->status == 'pending')
                                    <form action="{{ route('admin.businesses.approve', $biz->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm rounded-pill px-3"
                                            style="background:#F68B1E;color:#fff;font-size:0.78rem;">Approve</button>
                                    </form>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No businesses registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection