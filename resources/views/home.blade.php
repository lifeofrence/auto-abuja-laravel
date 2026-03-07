@extends('layouts.main')

@section('content')
    <!-- Hero Section Start -->
    <div class="container-fluid" style="background: #FFB400; padding: 80px 0 60px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-4 text-black mb-3 fw-bold">Find Trusted Automotive Services in Abuja</h1>
                    <p class="text-black-50 mb-4 fs-5">Connect with verified mechanics, dealers, and auto service providers
                    </p>

                    <!-- Search Bar -->
                    <div class="search-container bg-white rounded-3 p-2 shadow-lg">
                        <form action="{{ url('/') }}" method="GET" class="row g-2 align-items-center" id="heroSearchForm">
                            <!-- Keyword -->
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control border-0 py-3"
                                    placeholder="What are you looking for?" value="{{ $search }}" style="font-size: 16px;">
                            </div>

                            <!-- Category -->
                            <div class="col-md-3">
                                <select name="category" id="categorySelect" class="form-select border-0 py-3"
                                    style="font-size: 16px;">
                                    <option value="">All Categories</option>
                                    @foreach($searchCategories as $cat)
                                        <option value="{{ $cat->slug }}" {{ $categorySlug === $cat->slug ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Subcategory -->
                            <div class="col-md-3">
                                <select name="subcategory" id="subcategorySelect" class="form-select border-0 py-3"
                                    style="font-size: 16px;">
                                    <option value="">All Sub-types</option>
                                    @foreach($searchSubcategories as $sc)
                                        <option value="{{ $sc->slug }}" {{ (!empty($subcategorySlug) && $subcategorySlug === $sc->slug) ? 'selected' : '' }}>
                                            {{ $sc->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Search Button -->
                            <div class="col-md-2">
                                <button type="submit" class="btn w-100 py-3 fw-bold"
                                    style="background: #F68B1E; border: none; color: #000;">
                                    <i class="fa fa-search me-2"></i>Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    @if($showResults)
        <!-- Search Results Section -->
        <div class="container-xxl py-5" id="searchResults">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="mb-3 fw-bold">Search Results</h2>
                    <p class="text-muted">Explore businesses and products matching your criteria</p>
                    <a href="{{ url('/') }}" class="btn btn-link text-primary p-0">Clear Search</a>
                </div>

                <!-- Product Results -->
                <div class="mb-5">
                    <h4 class="fw-bold mb-4"><i class="fa fa-box me-2 text-primary"></i>Products & Services
                        ({{ $searchProductResults->count() }})</h4>
                    <div class="row g-4">
                        @forelse($searchProductResults as $product)
                            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="card h-100 border-0 shadow-sm hover-lift"
                                    style="border-radius: 12px; overflow: hidden;">
                                    <div class="position-relative">
                                        <img src="{{ $product->image_url }}" class="card-img-top"
                                            style="height: 160px; object-fit: cover;" alt="{{ $product->name }}">
                                        <div class="position-absolute bottom-0 end-0 p-2">
                                            <span
                                                class="badge bg-primary px-2 py-1 shadow-sm">₦{{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-1 text-dark text-truncate">{{ $product->name }}</h6>
                                        <p class="text-muted small mb-2">By: <a
                                                href="{{ url('/business/' . $product->business->slug) }}"
                                                class="text-primary fw-bold">{{ $product->business->business_name }}</a></p>
                                        <p class="text-muted small mb-3">{{ Str::limit($product->description, 60) }}</p>
                                        <a href="{{ url('/product/' . $product->slug) }}" class="btn btn-dark btn-sm w-100"
                                            style="border-radius: 6px;">View Product</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-light border text-center text-muted">No matching products or services found.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Business Results -->
                <div>
                    <h4 class="fw-bold mb-4"><i class="fa fa-building me-2 text-primary"></i>Businesses
                        ({{ $searchBusinessResults->count() }})</h4>
                    <div class="row g-4">
                        @forelse($searchBusinessResults as $business)
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="card h-100 border-0 shadow-sm hover-lift"
                                    style="border-radius: 12px; overflow: hidden;">
                                    <div class="position-relative">
                                        <img src="{{ $business->image_url }}" class="card-img-top"
                                            style="height: 180px; object-fit: cover;" alt="{{ $business->business_name }}">
                                        @if($business->is_featured)
                                            <div class="position-absolute top-0 end-0 p-2">
                                                <span class="badge bg-warning text-dark shadow-sm"><i
                                                        class="fa fa-star me-1"></i>Featured</span>
                                            </div>
                                        @endif
                                        @if($business->verified)
                                            <div class="position-absolute top-0 start-0 p-2">
                                                <span class="badge bg-success shadow-sm"><i
                                                        class="fa fa-check-circle me-1"></i>Verified</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="fw-bold mb-1 text-dark text-truncate">{{ $business->business_name }}</h5>
                                        <span class="badge bg-light text-primary mb-2">{{ $business->category->name ?? '' }}</span>
                                        <p class="text-muted small mb-3">{{ Str::limit($business->description, 80) }}</p>
                                        <div class="mb-3">
                                            <div class="text-muted small mb-1"><i
                                                    class="fa fa-map-marker-alt me-2 text-primary"></i>{{ $business->address }}
                                            </div>
                                            <div class="text-muted small"><i
                                                    class="fa fa-phone me-2 text-primary"></i>{{ $business->phone }}</div>
                                        </div>
                                        <a href="{{ url('/listings/' . $business->slug) }}"
                                            class="btn btn-outline-dark btn-sm w-100" style="border-radius: 6px;">View Business</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-light border text-center text-muted">No matching businesses found.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <hr class="mt-5">
            </div>
        </div>
    @endif

    <!-- Featured Products Section -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-uppercase mb-2" style="color: #F68B1E; font-weight: 600; letter-spacing: 2px;">Featured
                    Products & Services</h6>
            </div>
            <div class="row g-4" id="productsGrid">
                @forelse($featuredProducts as $index => $product)
                    <div class="col-lg-3 col-md-6 wow fadeInUp product-item" data-wow-delay="{{ 0.1 + ($index * 0.2) }}s">
                        <div class="card h-100 border-0 shadow">
                            <div class="position-relative">
                                <img src="{{ $product->image_url }}" class="card-img-top"
                                    style="height: 200px; object-fit: cover;" alt="{{ $product->name }}">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title mb-2">{{ $product->name }}</h5>
                                <div class="mb-2">
                                    @php
                                        $pCategoryName = $product->category->name ?? $product->business->category->name ?? '';
                                        $pCategorySlug = $product->category->slug ?? $product->business->category->slug ?? '';
                                        $pSubcatName = $product->subcategory->name ?? $product->business->subcategory->name ?? '';
                                        $pSubcatSlug = $product->subcategory->slug ?? $product->business->subcategory->slug ?? '';
                                    @endphp
                                    <a href="{{ url('/?category=' . $pCategorySlug) }}" class="badge text-decoration-none me-1"
                                        style="background:#F68B1E; color:#000; font-size:11px;">
                                        <i class="fa fa-tag me-1"></i>{{ $pCategoryName }}
                                    </a>
                                    @if($pSubcatName)
                                        <div class="mt-1 w-100">
                                            <a href="{{ url('/?category=' . $pCategorySlug . '&subcategory=' . $pSubcatSlug) }}"
                                                class="badge bg-light text-dark border text-decoration-none d-inline-block text-truncate"
                                                style="font-size:11px; max-width: 100%;">
                                                {{ $pSubcatName }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <h4 class="mb-2" style="color: #F68B1E;">₦{{ number_format($product->price, 2) }}</h4>
                                <p class="text-secondary mb-3 small">By: {{ $product->business->business_name }}</p>
                                <a href="{{ url('/product/' . $product->slug) }}" class="btn btn-outline-dark w-100 btn-sm">View
                                    Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No featured products available at the moment.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.1s">
                <a href="{{ route('products.index') }}" class="btn btn-primary py-3 px-5 rounded-pill shadow-sm fw-bold">
                    View More Products <i class="fa fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>


    <!-- CTA Section Start -->
    <div class="container-fluid py-5" style="background: #FFB400;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h2 class="mb-4 fw-bold" style="color: #000;">Are You an Automotive Service Provider?</h2>
                    <p class="mb-4 fs-5" style="color: #000;">Join hundreds of verified businesses on Auto Abuja and
                        connect with
                        thousands of potential customers looking for your services.</p>
                    <ul class="list-unstyled" style="color: #000;">
                        <li class="mb-3"><i class="fa fa-check-circle me-3" style="color: #F68B1E;"></i>Increase
                            your
                            visibility</li>
                        <li class="mb-3"><i class="fa fa-check-circle me-3" style="color: #F68B1E;"></i>Reach more
                            customers</li>
                        <li class="mb-3"><i class="fa fa-check-circle me-3" style="color: #F68B1E;"></i>Grow your
                            business</li>
                        <li class="mb-3"><i class="fa fa-check-circle me-3" style="color: #F68B1E;"></i>Get verified
                            badge</li>
                    </ul>
                </div>
                <div class="col-lg-5 text-center">
                    <div class="bg-white rounded-3 p-5 shadow-lg" style="border: 3px solid #F68B1E;">
                        <h4 class="mb-4 fw-bold">List Your Business</h4>
                        <p class="text-muted mb-4">Get started today and join our growing community of automotive
                            professionals</p>
                        <a href="{{ route('register') }}" class="btn btn-lg w-100 py-3 mb-3 fw-bold"
                            style="background: #F68B1E; border: none; color: #000;">
                            <i class="fa fa-user-plus me-2"></i>Register Now
                        </a>
                        <p class="small text-muted mb-0">Already have an account? <a href="{{ route('login') }}"
                                class="fw-bold" style="color: #F68B1E; text-decoration: underline;">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CTA Section End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @if($carouselAds->isNotEmpty())
                    @foreach($carouselAds as $index => $ad)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img class="w-100" src="{{ asset($ad->image) }}" alt="Image">
                            <div class="carousel-caption d-flex align-items-center">
                                <div class="container">
                                    <div class="row justify-content-start">
                                        <div class="col-10 col-lg-8">
                                            <h5 class="text-white text-uppercase mb-3 animated slideInDown">
                                                A.R.T.S.P Special</h5>
                                            <h1 class="display-3 text-white animated slideInDown mb-4">
                                                {{ $ad->title }}
                                            </h1>
                                            <p class="fs-5 fw-medium text-white mb-4 pb-2">
                                                {{ $ad->description }}
                                            </p>
                                            <a href="{{ $ad->link_url ?? url('/listings') }}"
                                                class="btn btn-primary py-3 px-5 animated slideInLeft">Discover
                                                More<i class="fa fa-arrow-right ms-3"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="carousel-item active">
                        <img class="w-100" src="{{ asset('img/carousel-bg-1.jpg') }}" alt="Image">
                        <div class="carousel-caption d-flex align-items-center">
                            <div class="container">
                                <div class="row justify-content-start">
                                    <div class="col-10 col-lg-8">
                                        <h1 class="display-3 text-white animated slideInDown mb-4">Welcome
                                            to Auto Abuja</h1>
                                        <a href="{{ url('/listings') }}"
                                            class="btn btn-primary py-3 px-5 animated slideInLeft">Discover
                                            More<i class="fa fa-arrow-right ms-3"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Advert Section Start -->
    <div class="container-fluid py-4" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row g-4">
                @if($promoAds->isNotEmpty())
                    @foreach($promoAds as $index => $ad)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index * 0.1) }}s">
                            <div class="ad-slot bg-white">
                                <a href="{{ $ad->link_url ?? '#' }}">
                                    <img class="img-fluid w-100" src="{{ asset($ad->image) }}" alt="{{ $ad->title }}">
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- Advert Section End -->

    <!-- Partners Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase"> Our Partners </h6>
                <h1 class="mb-5">Trusted By Leading Organizations</h1>
            </div>
            <div class="row g-4 align-items-center">
                @if($partners->isNotEmpty())
                    @foreach($partners as $index => $partner)
                        <div class="col-lg-2 col-md-4 col-6 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index * 0.1) }}s">
                            <div class="partner-item bg-light p-4 text-center">
                                <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}" class="img-fluid"
                                    style="max-height: 80px;">
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="text-center mt-5">
                <a class="btn btn-primary py-3 px-5" href="{{ url('/contact') }}">Contact Us</a>
            </div>
        </div>
    </div>
    <!-- Partners End -->

    <!-- Testimonials Start -->
    <div class="container-fluid py-5" style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase fw-bold mb-2" style="letter-spacing: 3px;">Social Proof</h6>
                <h1 class="display-5 mb-0 fw-bold">What Our Clients Say</h1>
                <div class="mx-auto mt-3" style="width: 80px; height: 4px; background: var(--primary); border-radius: 2px;">
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                @if($testimonials->isNotEmpty())
                    @foreach($testimonials as $index => $t)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index * 0.2) }}s">
                            <div class="testimonial-card bg-white p-5 h-100 position-relative shadow-sm hover-lift"
                                style="border-radius: 20px; border: 1px solid rgba(0,0,0,0.05); transition: all 0.3s ease;">
                                <div class="quote-icon position-absolute top-0 end-0 p-4 opacity-10" style="pointer-events: none;">
                                    <!-- <i class="fa fa-quote-right fa-4x text-primary"></i> -->
                                </div>
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                        style="width: 60px; height: 60px; min-width: 60px;">
                                        <span class="text-white fw-bold fs-4">{{ substr($t->name ?? 'U', 0, 1) }}</span>
                                    </div>
                                    <div class="ps-3">
                                        <h5 class="fw-bold mb-0" style="color: #1a1a2e;">{{ $t->name }}</h5>
                                        <small class="text-muted fw-medium">{{ $t->position }}</small>
                                        <div class="stars mt-1" style="color: #FFB400; font-size: 0.75rem;">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0 fs-6 text-secondary lh-lg"
                                    style="font-style: italic; position: relative; z-index: 1;">
                                    "{{ $t->text }}"
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center text-muted">No testimonials yet. Be the first to share your experience!</div>
                @endif
            </div>
        </div>
    </div>
    <!-- Testimonials End -->

    <style>
        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
            border-color: var(--primary) !important;
        }

        .testimonial-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            bottom: 20%;
            width: 4px;
            background: var(--primary);
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .testimonial-card:hover::before {
            opacity: 1;
        }
    </style>
    @push('scripts')
        <script>
            (function () {
                const categorySelect = document.getElementById('categorySelect');
                const subcategorySelect = document.getElementById('subcategorySelect');
                const selectedSubcatSlug = '{{ $subcategorySlug ?? '' }}';

                function loadSubcategories(categorySlug, preselect) {
                    subcategorySelect.innerHTML = '<option value="">All Sub-types</option>';
                    if (!categorySlug) return;

                    fetch('/api/subcategories?category=' + encodeURIComponent(categorySlug))
                        .then(function (res) { return res.json(); })
                        .then(function (subcategories) {
                            subcategories.forEach(function (sc) {
                                var opt = document.createElement('option');
                                opt.value = sc.slug;
                                opt.textContent = sc.name;
                                if (preselect && sc.slug === preselect) {
                                    opt.selected = true;
                                }
                                subcategorySelect.appendChild(opt);
                            });
                        })
                        .catch(function (err) { console.error('Subcategory load failed:', err); });
                }

                categorySelect.addEventListener('change', function () {
                    loadSubcategories(this.value, null);
                });

                if (categorySelect.value) {
                    loadSubcategories(categorySelect.value, selectedSubcatSlug);
                }
            })();
        </script>
    @endpush
@endsection