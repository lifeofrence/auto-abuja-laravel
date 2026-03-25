@extends('layouts.admin')

@section('admin_content')

    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <a href="{{ route('admin.categories.index') }}"
                style="color:#F68B1E;font-size:0.875rem;text-decoration:none;font-weight:600;display:inline-block;margin-bottom:8px;">
                <i class="fa fa-arrow-left me-1"></i> Back to Categories
            </a>
            <h4>{{ $category->name }} &rsaquo; Subcategories</h4>
            <p>Manage the sub-categories inside "{{ $category->name }}"</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Subcategories Table -->
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h6 class="fw-bold mb-0" style="font-size:0.95rem;">All Subcategories</h6>
                        <p class="mb-0" style="font-size:0.8rem;color:#999;">{{ $subcategories->count() }} total</p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 admin-table">
                        <thead>
                            <tr>
                                <th style="padding-left:20px;">Subcategory</th>
                                <th>Listings</th>
                                <th>Status</th>
                                <th class="text-end" style="padding-right:20px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subcategories as $subcat)
                                <tr>
                                    <td style="padding-left:20px;">
                                        <div class="d-flex align-items-center gap-3">
                                            <div
                                                style="width:36px;height:36px;border-radius:8px;background:var(--bs-{{ $subcat->badge_color ?? 'primary' }}-subtle, #eaf0ff);display:flex;align-items:center;justify-content:center;color:var(--bs-{{ $subcat->badge_color ?? 'primary' }}, #4f6ef7);flex-shrink:0;">
                                                <b>{{ strtoupper(substr($subcat->name, 0, 1)) }}</b>
                                            </div>
                                            <div>
                                                <div class="fw-semibold" style="font-size:0.875rem;color:#1a1a2e;">
                                                    {{ $subcat->name }}</div>
                                                <div style="font-size:0.72rem;color:#bbb;">{{ $subcat->slug }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="cat-badge">{{ $subcat->products_count }}
                                            {{ Str::plural('Listing', $subcat->products_count) }}</span>
                                    </td>
                                    <td>
                                        @if($subcat->is_active)
                                            <span class="status-badge" style="background:#edfaf1;color:#34c76f;">Active</span>
                                        @else
                                            <span class="status-badge" style="background:#f4f6f9;color:#999;">Disabled</span>
                                        @endif
                                    </td>
                                    <td class="text-end" style="padding-right:20px;">
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#editSubCatModal{{ $subcat->id }}" style="border:none;border-radius:8px;padding:5px 12px;font-size:0.78rem;font-weight:600;cursor:pointer;background:#eefaff;color:#0ea5e9;">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.subcategories.toggle', $subcat->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit"
                                                    style="border:none;border-radius:8px;padding:5px 12px;font-size:0.78rem;font-weight:600;cursor:pointer;background:{{ $subcat->is_active ? '#fff2f2' : '#edfaf1' }};color:{{ $subcat->is_active ? '#ff6b6b' : '#34c76f' }};">
                                                    {{ $subcat->is_active ? 'Disable' : 'Enable' }}
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade text-start" id="editSubCatModal{{ $subcat->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow" style="border-radius:12px;">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h6 class="modal-title fw-bold">Edit Subcategory</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('admin.subcategories.update', $subcat->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body p-4 pt-3">
                                                            <div class="mb-3">
                                                                <label style="font-size:0.8rem;font-weight:600;color:#555;display:block;margin-bottom:6px;">Subcategory Name</label>
                                                                <input type="text" name="name" value="{{ $subcat->name }}" class="form-control" required style="border-radius:8px;padding:10px 14px;font-size:0.9rem;">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label style="font-size:0.8rem;font-weight:600;color:#555;display:block;margin-bottom:6px;">Color Badge</label>
                                                                <select name="badge_color" class="form-select" style="border-radius:8px;padding:10px 14px;font-size:0.9rem;">
                                                                    <option value="primary" {{ $subcat->badge_color == 'primary' ? 'selected' : '' }}>Blue (Primary)</option>
                                                                    <option value="success" {{ $subcat->badge_color == 'success' ? 'selected' : '' }}>Green (Success)</option>
                                                                    <option value="warning" {{ $subcat->badge_color == 'warning' ? 'selected' : '' }}>Yellow (Warning)</option>
                                                                    <option value="danger" {{ $subcat->badge_color == 'danger' ? 'selected' : '' }}>Red (Danger)</option>
                                                                    <option value="info" {{ $subcat->badge_color == 'info' ? 'selected' : '' }}>Cyan (Info)</option>
                                                                    <option value="dark" {{ $subcat->badge_color == 'dark' ? 'selected' : '' }}>Dark</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label style="font-size:0.8rem;font-weight:600;color:#555;display:block;margin-bottom:6px;">Description</label>
                                                                <textarea name="description" class="form-control" rows="3" style="border-radius:8px;padding:10px 14px;font-size:0.9rem;">{{ $subcat->description }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:8px;font-weight:600;font-size:0.85rem;">Cancel</button>
                                                            <button type="submit" class="btn" style="background:#F68B1E;color:#fff;border-radius:8px;font-weight:600;font-size:0.85rem;">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5" style="border:none;">
                                        No subcategories added yet. Create one!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Subcategory Panel -->
        <div class="col-lg-4">
            <div class="admin-card p-4" style="position:sticky;top:100px;">
                <h6 class="fw-bold mb-1" style="font-size:0.95rem;">Add Subcategory</h6>
                <p style="font-size:0.8rem;color:#999;margin-bottom:20px;">Add a new child category to
                    "{{ $category->name }}"</p>

                <form action="{{ route('admin.categories.subcategories.store', $category->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label
                            style="font-size:0.78rem;font-weight:600;color:#555;display:block;margin-bottom:6px;">Subcategory
                            Name</label>
                        <input type="text" name="name" placeholder="e.g. Sports Cars"
                            style="border:1px solid #eee;border-radius:8px;padding:9px 14px;font-size:0.875rem;width:100%;outline:none;transition:border-color 0.2s;"
                            onfocus="this.style.borderColor='#F68B1E'" onblur="this.style.borderColor='#eee'" required>
                    </div>
                    <div class="mb-3">
                        <label style="font-size:0.78rem;font-weight:600;color:#555;display:block;margin-bottom:6px;">Color
                            Badge (Optional)</label>
                        <select name="badge_color"
                            style="border:1px solid #eee;border-radius:8px;padding:9px 14px;font-size:0.875rem;width:100%;outline:none;background:#fff;cursor:pointer;">
                            <option value="primary">Blue (Primary)</option>
                            <option value="success">Green (Success)</option>
                            <option value="warning">Yellow (Warning)</option>
                            <option value="danger">Red (Danger)</option>
                            <option value="info">Cyan (Info)</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label
                            style="font-size:0.78rem;font-weight:600;color:#555;display:block;margin-bottom:6px;">Description
                            (Optional)</label>
                        <textarea name="description" rows="3" placeholder="Brief description..."
                            style="border:1px solid #eee;border-radius:8px;padding:9px 14px;font-size:0.875rem;width:100%;outline:none;transition:border-color 0.2s;resize:none;"
                            onfocus="this.style.borderColor='#F68B1E'" onblur="this.style.borderColor='#eee'"></textarea>
                    </div>
                    <button type="submit"
                        style="background:#F68B1E;color:#fff;border:none;border-radius:8px;padding:10px 20px;font-size:0.875rem;font-weight:600;cursor:pointer;width:100%;transition:opacity 0.2s;"
                        onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        <i class="fa fa-plus me-2"></i>Create Subcategory
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection