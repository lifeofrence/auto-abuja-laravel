@extends('layouts.admin')

@section('admin_content')

    <div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4>Business Approvals</h4>
            <p class="mb-0">Review and moderate all registered businesses on the platform</p>
        </div>
        <div>
            <form action="{{ route('admin.businesses.index') }}" method="GET" class="d-flex align-items-center gap-2">
                <div class="input-group"
                    style="background: #fff; border: 1px solid #eef2f6; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.02); min-width: 320px;">
                    <span class="input-group-text bg-transparent border-0 pe-1 text-muted">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 shadow-none px-2"
                        placeholder="Search businesses, vendors..." value="{{ request('search') }}"
                        style="font-size: 0.9rem;">
                    <button type="submit" class="btn border-0"
                        style="background:var(--primary-color, #F68B1E); color:#fff; border-radius: 6px; margin: 4px; padding: 4px 16px; font-weight: 500; font-size: 0.85rem;">
                        Search
                    </button>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.businesses.index') }}" class="btn"
                        style="background: #fff2f2; color: #ff6b6b; border: 1px solid #ffecf2; border-radius: 8px; font-weight: 500; font-size: 0.85rem; padding: 8px 16px;">
                        Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="admin-card">
        <div class="table-responsive">
            <table class="table mb-0 admin-table">
                <thead>
                    <tr>
                        <th style="padding-left:20px;">Business</th>
                        <th>Vendor</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th class="text-end" style="padding-right:20px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($businesses as $biz)
                        <tr>
                            <td style="padding-left:20px;">
                                <div class="d-flex align-items-center gap-3">
                                    @if($biz->logo)
                                        <img src="{{ asset('storage/' . $biz->logo) }}" alt="Logo"
                                            style="width:36px;height:36px;object-fit:cover;border-radius:8px;flex-shrink:0;">
                                    @else
                                        <div class="biz-avatar">{{ strtoupper(substr($biz->business_name, 0, 1)) }}</div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold" style="font-size:0.875rem;color:#1a1a2e;">
                                            {{ $biz->business_name }}
                                        </div>
                                        <div class="text-muted" style="font-size:0.75rem;"><i
                                                class="fa fa-map-marker-alt me-1"></i>{{ Str::limit($biz->address, 30) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size:0.875rem;font-weight:500;color:#333;">{{ $biz->user->name ?? 'N/A' }}
                                </div>
                                <div style="font-size:0.75rem;color:#aaa;">{{ $biz->user->email ?? '' }}</div>
                            </td>
                            <td><span class="cat-badge">{{ $biz->category->name ?? 'Uncategorized' }}</span></td>
                            <td>
                                @if($biz->status == 'approved')
                                    <span class="status-badge" style="background:#edfaf1;color:#34c76f;">Approved</span>
                                @elseif($biz->status == 'pending')
                                    <span class="status-badge" style="background:#fff8ec;color:#F68B1E;">Pending</span>
                                @else
                                    <span class="status-badge" style="background:#fff2f2;color:#ff6b6b;">Suspended</span>
                                @endif
                            </td>
                            <td class="text-end" style="padding-right:20px;">
                                <div class="d-flex gap-2 justify-content-end align-items-center">
                                    <!-- Account Management Group -->
                                    <div class="d-flex gap-1">
                                        @if($biz->slug)
                                            <a href="{{ route('business.show', $biz->slug) }}" target="_blank" class="btn btn-sm"
                                                title="Preview Business"
                                                style="background:#fff; border:1px solid #eef2f6; color:#0d6efd; border-radius:6px; width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center;">
                                                <i class="fa fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.users.show', $biz->user_id) }}" class="btn btn-sm"
                                            title="View Profile"
                                            style="background:#fff; border:1px solid #eef2f6; color:#555; border-radius:6px; width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center;">
                                            <i class="fa fa-user"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $biz->user_id) }}" class="btn btn-sm"
                                            title="Edit Account"
                                            style="background:#fff; border:1px solid #eef2f6; color:#555; border-radius:6px; width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center;">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <!-- <a href="{{ route('admin.products.index', ['search' => $biz->business_name]) }}" class="btn btn-sm" title="View Products" 
                                                            style="background:#fff; border:1px solid #eef2f6; color:#555; border-radius:6px; width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center;">
                                                            <i class="fa fa-shopping-bag"></i>
                                                        </a> -->
                                    </div>

                                    <div style="width: 1px; height: 20px; background: #eef2f6;"></div>

                                    <!-- Moderation Group -->
                                    <div class="d-flex gap-1 align-items-center">
                                        @if($biz->status == 'pending')
                                            <form action="{{ route('admin.businesses.approve', $biz->id) }}" method="POST"
                                                class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm"
                                                    style="background:#34c76f; color:#fff; border-radius:6px; padding:6px 14px; font-weight:600; border:none; font-size: 0.75rem;">
                                                    <i class="fa fa-check me-1"></i> Approve
                                                </button>
                                            </form>
                                        @elseif($biz->status == 'approved')
                                            <form action="{{ route('admin.businesses.suspend', $biz->id) }}" method="POST"
                                                class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm"
                                                    style="background:#fff8ec; color:#F68B1E; border:1px solid #fceccb; border-radius:6px; padding:6px 14px; font-weight:600; font-size: 0.75rem;">
                                                    <i class="fa fa-ban me-1"></i> Suspend
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.businesses.approve', $biz->id) }}" method="POST"
                                                class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm"
                                                    style="background:#eafaf1; color:#34c76f; border:1px solid #d1f2de; border-radius:6px; padding:6px 14px; font-weight:600; font-size: 0.75rem;">
                                                    Restore
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.businesses.destroy', $biz->id) }}" method="POST"
                                            class="m-0">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Permanently delete this business?')"
                                                class="btn btn-sm" title="Delete Permanent"
                                                style="background:#fff2f2; border:1px solid #ffecf2; color:#ff6b6b; border-radius:6px; width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center;">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($businesses->hasPages())
            <div style="padding:16px 20px;border-top:1px solid #f4f6f9;">
                {{ $businesses->links() }}
            </div>
        @endif
    </div>

@endsection