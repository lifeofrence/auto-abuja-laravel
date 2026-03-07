@extends('layouts.vendor')

@section('vendor_content')
    <!-- Cover Section -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="position-relative" style="height: 250px;">
            <div class="w-100 h-100 overflow-hidden">
                @if($business->cover_image)
                    <img src="{{ asset('storage/' . $business->cover_image) }}" class="w-100 h-100 object-fit-cover"
                        alt="Cover">
                @else
                    <img src="{{ asset('img/carousel-bg-1.jpg') }}" class="w-100 h-100 object-fit-cover" alt="Default Cover">
                @endif
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 p-4 text-white"
                style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                <div class="d-flex align-items-end">
                    <div class="me-4 mb-n5" style="z-index: 10;">
                        <div class="bg-white rounded-circle p-1 shadow-lg" style="width: 120px; height: 120px;">
                            @if($business->logo)
                                <img src="{{ asset('storage/' . $business->logo) }}"
                                    class="rounded-circle w-100 h-100 object-fit-cover" alt="Logo">
                            @else
                                <div
                                    class="w-100 h-100 rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fs-2 fw-bold">
                                    {{ strtoupper(substr($business->business_name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex-grow-1 pb-2">
                        <h2 class="fw-bold mb-0 text-white">{{ $business->business_name }}</h2>
                        <p class="mb-0 small"><i class="fa fa-map-marker-alt me-2 text-primary"></i>{{ $business->address }}
                        </p>
                    </div>
                    <div class="pb-2 d-none d-md-block">
                        <a href="{{ route('vendor.business.index') }}"
                            class="btn btn-warning btn-sm rounded-pill px-3 fw-bold shadow-sm">
                            <i class="fa fa-edit me-1"></i> Edit Business
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body pt-5">
            <div class="row pt-2 g-4">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <span class="badge bg-primary px-3 py-2 rounded-pill me-2">
                            <i class="fa fa-tag me-1"></i> {{ $business->category->name ?? 'Uncategorized' }}
                        </span>
                        @if($business->subcategory)
                            <span class="badge bg-outline-primary border border-primary text-primary px-3 py-2 rounded-pill">
                                <i class="fa fa-tags me-1"></i> {{ $business->subcategory->name }}
                            </span>
                        @endif
                    </div>

                    <h6 class="fw-bold text-uppercase small text-muted mb-3">About My Business</h6>
                    <p class="text-muted small">
                        {!! $business->description ? nl2br(e($business->description)) : 'No description provided yet.' !!}
                    </p>

                    <div class="mt-4">
                        <h6 class="fw-bold text-uppercase small text-muted mb-3">Operating Hours</h6>
                        <div class="bg-light rounded-3 p-3 small">
                            @php
                                $daysOrdered = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            @endphp
                            @foreach($daysOrdered as $dayName)
                                @php
                                    $times = $business->business_hours[$dayName] ?? null;
                                @endphp
                                @if($times)
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">{{ $dayName }}</span>
                                        <span class="fw-bold">{{ $times['open'] }} - {{ $times['close'] }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="fw-bold text-uppercase small text-muted mb-3">Contact Details</h6>
                        <div class="d-grid gap-2">
                            @if($business->phone)
                                <div class="d-flex align-items-center bg-light p-2 rounded-3">
                                    <i class="fa fa-phone text-primary me-2 w-25px text-center"></i>
                                    <span class="small">{{ $business->phone }}</span>
                                </div>
                            @endif
                            @if($business->email)
                                <div class="d-flex align-items-center bg-light p-2 rounded-3">
                                    <i class="fa fa-envelope text-primary me-2 w-25px text-center"></i>
                                    <span class="small">{{ $business->email }}</span>
                                </div>
                            @endif
                            @if($business->website)
                                <a href="{{ str_starts_with($business->website, 'http') ? $business->website : 'https://' . $business->website }}"
                                    target="_blank"
                                    class="d-flex align-items-center bg-light p-2 rounded-3 text-decoration-none text-dark">
                                    <i class="fa fa-globe text-primary me-2 w-25px text-center"></i>
                                    <span class="small text-truncate">{{ $business->website }}</span>
                                </a>
                            @endif
                            @if($business->whatsapp)
                                <div class="d-flex align-items-center bg-light p-2 rounded-3">
                                    <i class="fab fa-whatsapp text-success me-2 w-25px text-center"></i>
                                    <span class="small">{{ $business->whatsapp }}</span>
                                </div>
                            @endif

                            <a href="{{ $business->google_maps_link ?: 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($business->address) }}"
                                target="_blank" class="btn btn-outline-primary btn-sm rounded-pill mt-2">
                                <i class="fa fa-directions me-2"></i> Get Directions
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <!-- Products Section -->
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold mb-0">Marketplace Listings</h5>
                        <a href="{{ route('vendor.products.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                            <i class="fa fa-plus me-1"></i> New Item
                        </a>
                    </div>

                    @if($products->count() > 0)
                        <div class="row g-3">
                            @foreach($products as $product)
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden product-card h-100">
                                        <div class="position-relative" style="height: 150px;">
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                                            <div class="position-absolute bottom-0 start-0 p-2">
                                                <span
                                                    class="badge bg-primary rounded-pill">₦{{ number_format($product->price) }}</span>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <h6 class="fw-bold mb-1 text-truncate">{{ $product->name }}</h6>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <span class="small text-muted">{{ $product->subcategory->name ?? 'General' }}</span>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('vendor.products.edit', $product->id) }}"
                                                        class="btn btn-light btn-sm rounded-circle"><i
                                                            class="fa fa-edit text-primary"></i></a>
                                                    <form action="{{ route('vendor.products.destroy', $product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-light btn-sm rounded-circle"
                                                            onclick="return confirm('Deactivate this listing?')"><i
                                                                class="fa fa-trash text-danger"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="text-center py-5 bg-light rounded-4 border-2 border-dashed border-secondary border-opacity-25">
                            <i class="fa fa-shopping-bag fa-3x text-muted mb-3 opacity-25"></i>
                            <p class="text-muted small">You haven't posted any products yet. Post one now to reach millions of
                                buyers in Abuja!</p>
                            <a href="{{ route('vendor.products.create') }}"
                                class="btn btn-primary mt-2 rounded-pill px-4 btn-sm">Post First Product</a>
                        </div>
                    @endif

                    <!-- Gallery Section -->
                    <div class="d-flex align-items-center justify-content-between mt-5 mb-4">
                        <h5 class="fw-bold mb-0">Business Gallery</h5>
                        <a href="{{ route('vendor.gallery.index') }}" class="btn btn-outline-info btn-sm rounded-pill px-3">
                            <i class="fa fa-images me-1"></i> Manage
                        </a>
                    </div>
                    @if($gallery->count() > 0)
                        <div class="row g-2">
                            @foreach($gallery as $img)
                                <div class="col-4">
                                    <div class="rounded-3 overflow-hidden shadow-sm" style="height: 100px;">
                                        <img src="{{ asset('storage/' . $img->image_path) }}" class="w-100 h-100 object-fit-cover"
                                            alt="Gallery">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="text-center py-4 bg-light rounded-4 border-2 border-dashed border-secondary border-opacity-25">
                            <p class="text-muted small mb-0">No gallery images yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .mb-n5 {
            margin-bottom: -3rem !important;
        }

        .w-25px {
            width: 25px;
        }
    </style>
@endpush