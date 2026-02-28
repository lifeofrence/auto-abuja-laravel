@extends('layouts.main')

@section('content')

    <style>
        .product-image-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .main-image {
            width: 100%;
            height: 450px;
            object-fit: cover;
        }

        .thumb-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 8px;
            margin-right: 10px;
            border: 2px solid transparent;
            transition: 0.3s;
        }

        .thumb-image:hover,
        .thumb-image.active {
            border-color: #F68B1E;
        }

        .business-card {
            border: none;
            border-radius: 15px;
            background: #f8f9fa;
            padding: 25px;
        }

        .price-tag {
            font-size: 2rem;
            color: #F68B1E;
            font-weight: 700;
        }

        .badge-verified {
            background-color: #198754;
            color: white;
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 50px;
        }
    </style>

    <div class="container-xxl py-5">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/product') }}">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $product->name }}
                    </li>
                </ol>
            </nav>

            <div class="row g-5">
                <!-- Product Images -->
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="product-image-container mb-3">
                        <img id="mainImage" src="{{ asset($product->image ?: 'img/default-product.jpg') }}"
                            class="main-image" alt="{{ $product->name }}">
                    </div>
                    @if(count($product_images) > 0)
                        <div class="d-flex overflow-auto pb-2">
                            <img src="{{ asset($product->image ?: 'img/default-product.jpg') }}" class="thumb-image active"
                                onclick="changeImage(this.src, this)">
                            @foreach($product_images as $img)
                                <img src="{{ asset($img->image_path) }}" class="thumb-image" onclick="changeImage(this.src, this)">
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h1 class="display-5 fw-bold mb-3">
                        {{ $product->name }}
                    </h1>

                    <div class="d-flex align-items-center mb-4">
                        <span class="price-tag me-3">₦
                            {{ number_format($product->price, 2) }}
                        </span>
                        @if($product->price_type !== 'fixed')
                            <span class="badge bg-light text-dark border">
                                {{ ucfirst($product->price_type) }}
                            </span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <p class="text-muted"><i class="fa fa-eye me-2"></i>
                            {{ number_format($product->views_count) }} views
                        </p>
                    </div>

                    <p class="fs-5 mb-5">
                        {!! nl2br(e($product->description ?? '')) !!}
                    </p>

                    @if($product->business)
                        <div class="business-card mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <h5 class="mb-0 me-2">Sold by: <a href="{{ url('/business/' . $product->business->slug) }}"
                                        class="text-primary">
                                        {{ $product->business->business_name }}
                                    </a></h5>
                                @if($product->business->verified)
                                    <span class="badge-verified"><i class="fa fa-check-circle me-1"></i>Verified</span>
                                @endif
                            </div>
                            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary me-2"></i>
                                {{ $product->business->address }}
                            </p>
                            <p class="mb-4"><i class="fa fa-phone-alt text-primary me-2"></i>
                                {{ $product->business->phone }}
                            </p>

                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="tel:{{ $product->business->phone }}" class="btn btn-primary w-100 py-3">
                                        <i class="fa fa-phone-alt me-2"></i>Call Now
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="https://wa.me/{{ str_replace(['+', ' '], '', $product->business->whatsapp ?? $product->business->phone) }}"
                                        class="btn btn-success w-100 py-3">
                                        <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-5 pt-5">
                    <h3 class="fw-bold mb-4">Other products from this business</h3>
                    <div class="row g-4">
                        @foreach($relatedProducts as $rp)
                            <div class="col-lg-3 col-md-6">
                                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                                    <img src="{{ asset($rp->image ?: 'img/default-product.jpg') }}" class="card-img-top"
                                        style="height: 180px; object-fit: cover;" alt="{{ $rp->name }}">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2">
                                            {{ $rp->name }}
                                        </h6>
                                        <p class="text-primary fw-bold mb-3">₦
                                            {{ number_format($rp->price, 2) }}
                                        </p>
                                        <a href="{{ url('/product/' . $rp->slug) }}" class="btn btn-sm btn-outline-primary w-100">View
                                            Product</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function changeImage(src, thumb) {
            document.getElementById('mainImage').src = src;
            const thumbs = document.querySelectorAll('.thumb-image');
            thumbs.forEach(t => t.classList.remove('active'));
            thumb.classList.add('active');
        }
    </script>
@endpush