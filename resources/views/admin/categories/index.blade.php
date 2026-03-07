@extends('layouts.admin')

@section('admin_content')

    <div class="page-header">
        <h4>Categories</h4>
        <p>Manage the marketplace trade categories available to vendors</p>
    </div>

    <div class="row g-4">
        <!-- Categories Table -->
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h6 class="fw-bold mb-0" style="font-size:0.95rem;">All Categories</h6>
                        <p class="mb-0" style="font-size:0.8rem;color:#999;">{{ $categories->count() }} total</p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 admin-table">
                        <thead>
                            <tr>
                                <th style="padding-left:20px;">Category</th>
                                <th>Listings</th>
                                <th>Status</th>
                                <th class="text-end" style="padding-right:20px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $cat)
                                <tr>
                                    <td style="padding-left:20px;">
                                        <div class="d-flex align-items-center gap-3">
                                            <div
                                                style="width:36px;height:36px;border-radius:8px;background:#f4f6f9;display:flex;align-items:center;justify-content:center;color:#F68B1E;flex-shrink:0;">
                                                <i class="fa {{ $cat->icon ?: 'fa-tag' }}"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold" style="font-size:0.875rem;color:#1a1a2e;">
                                                    {{ $cat->name }}
                                                </div>
                                                <div style="font-size:0.72rem;color:#bbb;">{{ $cat->slug }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="cat-badge">{{ $cat->products_count }}
                                            {{ Str::plural('Listing', $cat->products_count) }}</span>
                                    </td>
                                    <td>
                                        @if($cat->is_active)
                                            <span class="status-badge" style="background:#edfaf1;color:#34c76f;">Active</span>
                                        @else
                                            <span class="status-badge" style="background:#f4f6f9;color:#999;">Disabled</span>
                                        @endif
                                    </td>
                                    <td class="text-end" style="padding-right:20px;">
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <a href="{{ route('admin.categories.subcategories', $cat->id) }}"
                                                style="border:none;border-radius:8px;padding:5px 12px;font-size:0.78rem;font-weight:600;cursor:pointer;text-decoration:none;background:#f4f6f9;color:#555;">
                                                Subcategories
                                            </a>
                                            <form action="{{ route('admin.categories.toggle', $cat->id) }}" method="POST"
                                                class="m-0">
                                                @csrf
                                                <button type="submit"
                                                    style="border:none;border-radius:8px;padding:5px 12px;font-size:0.78rem;font-weight:600;cursor:pointer;background:{{ $cat->is_active ? '#fff2f2' : '#edfaf1' }};color:{{ $cat->is_active ? '#ff6b6b' : '#34c76f' }};">
                                                    {{ $cat->is_active ? 'Disable' : 'Enable' }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5" style="border:none;">No categories yet.
                                        Add one!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Category Panel -->
        <div class="col-lg-4">
            <div class="admin-card p-4" style="position:sticky;top:100px;">
                <h6 class="fw-bold mb-1" style="font-size:0.95rem;">Add New Category</h6>
                <p style="font-size:0.8rem;color:#999;margin-bottom:20px;">Create a trade category for vendors to list under
                </p>

                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label
                            style="font-size:0.78rem;font-weight:600;color:#555;display:block;margin-bottom:6px;">Category
                            Name</label>
                        <input type="text" name="name" placeholder="e.g. Luxury Cars"
                            style="border:1px solid #eee;border-radius:8px;padding:9px 14px;font-size:0.875rem;width:100%;outline:none;transition:border-color 0.2s;"
                            onfocus="this.style.borderColor='#F68B1E'" onblur="this.style.borderColor='#eee'" required>
                    </div>
                    <div class="mb-4">
                        <label
                            style="font-size:0.78rem;font-weight:600;color:#555;display:block;margin-bottom:6px;">FontAwesome
                            Icon</label>
                        <input type="text" name="icon" placeholder="fa-car" value="fa-tag"
                            style="border:1px solid #eee;border-radius:8px;padding:9px 14px;font-size:0.875rem;width:100%;outline:none;transition:border-color 0.2s;"
                            onfocus="this.style.borderColor='#F68B1E'" onblur="this.style.borderColor='#eee'">
                        <p style="font-size:0.72rem;color:#bbb;margin-top:4px;">Examples: fa-car, fa-tools, fa-oil-can</p>
                    </div>
                    <button type="submit"
                        style="background:#F68B1E;color:#fff;border:none;border-radius:8px;padding:10px 20px;font-size:0.875rem;font-weight:600;cursor:pointer;width:100%;transition:opacity 0.2s;"
                        onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        <i class="fa fa-plus me-2"></i>Create Category
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection