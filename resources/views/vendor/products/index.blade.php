@extends('layouts.vendor')

@section('vendor_content')
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-0">My Products & Services</h4>
                <p class="text-muted small mb-0">Manage and track your active marketplace listings</p>
            </div>
            <a href="{{ route('vendor.products.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fa fa-plus me-2"></i>Post New Item
            </a>
        </div>

        @if(session('status'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4 text-dark"
                style="background: #e6fcf5;">
                <i class="fa fa-check-circle me-3 fs-3 text-success"></i>
                <div>
                    <h6 class="mb-0 fw-bold">Success!</h6>
                    <p class="mb-0 small">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 rounded-start text-muted small text-uppercase fw-bold ps-3">Item</th>
                            <th class="border-0 text-muted small text-uppercase fw-bold">Price</th>
                            <th class="border-0 text-muted small text-uppercase fw-bold">Category</th>
                            <th class="border-0 text-muted small text-uppercase fw-bold">Visibility</th>
                            <th class="border-0 rounded-end text-muted small text-uppercase fw-bold text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="ps-3 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="rounded-3 overflow-hidden shadow-sm" style="width: 50px; height: 50px;">
                                                <img src="{{ $product->image_url }}" class="w-100 h-100 object-fit-cover"
                                                    alt="{{ $product->name }}">
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $product->name }}</h6>
                                            <span class="text-muted x-small">ID:
                                                #{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">₦{{ number_format($product->price) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark rounded-pill border">
                                        {{ $product->category->name ?? 'General' }}
                                    </span>
                                </td>
                                <td>
                                    @if($product->is_available)
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-medium">
                                            <i class="fa fa-circle me-1 small"></i> Live on Marketplace
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 fw-medium">
                                            <i class="fa fa-circle me-1 small"></i> Hidden from Public
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-3 text-end">
                                    <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                        <a href="{{ route('vendor.products.edit', $product->id) }}"
                                            class="btn btn-white btn-sm px-3 border-0" title="Edit">
                                            <i class="fa fa-edit text-primary"></i>
                                        </a>

                                        <form action="{{ route('vendor.products.toggle', $product->id) }}" method="POST"
                                            class="d-inline m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-white btn-sm px-3 border-0"
                                                title="{{ $product->is_available ? 'Hide from Public' : 'Make Live' }}">
                                                @if($product->is_available)
                                                    <i class="fa fa-eye-slash text-warning"></i>
                                                @else
                                                    <i class="fa fa-eye text-success"></i>
                                                @endif
                                            </button>
                                        </form>

                                        <form action="{{ route('vendor.products.destroy', $product->id) }}" method="POST"
                                            class="d-inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-white btn-sm px-3 border-0" title="Deactivate"
                                                onclick="return confirm('Note: This will hide your product from the marketplace. You can re-activate it later.')">
                                                <i class="fa fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4"
                    style="width: 100px; height: 100px;">
                    <i class="fa fa-shopping-bag fa-3x text-muted opacity-50"></i>
                </div>
                <h5 class="fw-bold">No items found</h5>
                <p class="text-muted mb-4">You haven't posted any products or services yet.</p>
                <a href="{{ route('vendor.products.create') }}" class="btn btn-primary rounded-pill px-5">
                    Start Selling Now
                </a>
            </div>
        @endif
    </div>

    <style>
        .custom-table thead th {
            padding: 1rem 0.75rem;
            font-size: 0.75rem;
        }

        .btn-white {
            background-color: #fff;
            border: 1px solid #eee;
        }

        .btn-white:hover {
            background-color: #f8f9fa;
        }

        .x-small {
            font-size: 0.7rem;
        }

        .bg-success-subtle {
            background-color: #e6fcf5 !important;
        }

        .bg-danger-subtle {
            background-color: #fff5f5 !important;
        }
    </style>
@endsection