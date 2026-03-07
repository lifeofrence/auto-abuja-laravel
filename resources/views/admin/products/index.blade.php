@extends('layouts.admin')

@section('admin_content')

    <div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4>Listings / Products</h4>
            <p class="mb-0">Oversee all marketplace listings across every vendor on the platform</p>
        </div>
        <div>
            <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex align-items-center gap-2">
                <div class="input-group"
                    style="background: #fff; border: 1px solid #eef2f6; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.02); min-width: 320px;">
                    <span class="input-group-text bg-transparent border-0 pe-1 text-muted">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 shadow-none px-2"
                        placeholder="Search products, business, vendor..." value="{{ request('search') }}"
                        style="font-size: 0.9rem;">
                    <button type="submit" class="btn border-0"
                        style="background:var(--primary-color, #F68B1E); color:#fff; border-radius: 6px; margin: 4px; padding: 4px 16px; font-weight: 500; font-size: 0.85rem;">
                        Search
                    </button>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.products.index') }}" class="btn"
                        style="background: #fff2f2; color: #ff6b6b; border: 1px solid #ffecf2; border-radius: 8px; font-weight: 500; font-size: 0.85rem; padding: 8px 16px; box-shadow: 0 2px 10px rgba(255,107,107,0.1);">
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
                        <th style="padding-left:20px;">Item</th>
                        <th>Price</th>
                        <th>Business / Vendor</th>
                        <th>Status</th>
                        <th class="text-end" style="padding-right:20px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td style="padding-left:20px;">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $product->image_url }}"
                                        style="width:40px;height:40px;object-fit:cover;border-radius:8px;flex-shrink:0;"
                                        alt="{{ $product->name }}">
                                    <div>
                                        <div class="fw-semibold" style="font-size:0.875rem;color:#1a1a2e;">{{ $product->name }}
                                        </div>
                                        <div class="text-muted" style="font-size:0.75rem;">
                                            {{ $product->category->name ?? 'General' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold" style="color:#1a1a2e;">₦{{ number_format($product->price) }}</span>
                            </td>
                            <td>
                                <div style="font-size:0.875rem;font-weight:500;color:#333;">
                                    {{ $product->business->business_name ?? 'Individual' }}
                                </div>
                                <div style="font-size:0.75rem;color:#aaa;">By {{ $product->user->name ?? 'N/A' }}</div>
                            </td>
                            <td>
                                @if($product->is_available)
                                    <span class="status-badge" style="background:#edfaf1;color:#34c76f;">Live</span>
                                @else
                                    <span class="status-badge" style="background:#fff2f2;color:#ff6b6b;">Hidden</span>
                                @endif
                            </td>
                            <td class="text-end" style="padding-right:20px;">
                                <div class="d-flex gap-2 justify-content-end align-items-center">
                                    <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                                        style="border:none;border-radius:8px;padding:5px 12px;font-size:0.78rem;font-weight:600;cursor:pointer;background:#f0f7ff;color:#3b82f6;text-decoration:none;">
                                        View
                                    </a>
                                    <form action="{{ route('admin.products.toggle', $product->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit"
                                            style="border:none;border-radius:8px;padding:5px 12px;font-size:0.78rem;font-weight:600;cursor:pointer;background:{{ $product->is_available ? '#fff8ec' : '#edfaf1' }};color:{{ $product->is_available ? '#F68B1E' : '#34c76f' }};">
                                            {{ $product->is_available ? 'Hide' : 'Make Live' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Permanently remove this product?')"
                                            style="border:none;border-radius:8px;padding:5px 10px;font-size:0.78rem;cursor:pointer;background:#fff2f2;color:#ff6b6b;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5" style="border:none;">
                                <div class="mb-2"><i class="fa fa-shopping-bag fa-2x opacity-25"></i></div>
                                No listings found on the platform yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div style="padding:16px 20px;border-top:1px solid #f4f6f9;">
                {{ $products->links() }}
            </div>
        @endif
    </div>

@endsection