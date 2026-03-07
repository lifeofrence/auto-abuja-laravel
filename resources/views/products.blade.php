@extends('layouts.main')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0"
        style="background-image: url('{{ asset('img/carousel-bg-2.jpg') }}');">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Products</h1>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Products Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <!-- Search Section -->
            <div class="row mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-lg-12">
                    <div class="bg-light p-4 rounded">
                        <form method="GET" action="{{ url('/product') }}" class="row g-3 align-items-center">
                            <!-- Keyword Search -->
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Search products (e.g., Benz, Camry)..." value="{{ request('search') }}">
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="col-lg-3">
                                <select name="category" id="categorySelect" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Subcategory -->
                            <div class="col-lg-3">
                                <select name="subcategory" id="subcategorySelect" class="form-select">
                                    <option value="">All Sub-types</option>
                                </select>
                            </div>

                            <!-- Search Action -->
                            <div class="col-lg-2">
                                <button class="btn btn-primary w-100" type="submit">
                                    <i class="fa fa-search me-2"></i>Search
                                </button>
                            </div>
                        </form>

                        <!-- Results Count -->
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'super_admin', 'moderator', 'support']))
                            <div class="mt-3">
                                <p class="mb-0 text-muted">
                                    <i class="fa fa-info-circle me-2"></i>
                                    Showing <span>{{ $products->total() }}</span> product(s)
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row g-4" id="productsGrid">
                @forelse($products as $product)
                    <div class="col-lg-3 col-md-6 wow fadeInUp product-item" data-wow-delay="0.1s">
                        <div class="card h-100 border-0 shadow">
                            <div class="position-relative">
                                <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}"
                                    style="height:200px; object-fit:cover;">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title mb-3">{{ $product->name }}</h5>
                                <h4 class="text-primary mb-3">₦{{ number_format($product->price) }}</h4>
                                
                                <div class="mb-3">
                                    @php
                                        $pCategoryName = $product->category->name ?? $product->business->category->name ?? '';
                                        $pCategorySlug = $product->category->slug ?? $product->business->category->slug ?? '';
                                        $pSubcatName = $product->subcategory->name ?? $product->business->subcategory->name ?? '';
                                        $pSubcatSlug = $product->subcategory->slug ?? $product->business->subcategory->slug ?? '';
                                    @endphp
                                    <a href="{{ url('/product?category=' . $pCategorySlug) }}" class="badge text-decoration-none me-1"
                                        style="background:#F68B1E; color:#000; font-size:11px;">
                                        <i class="fa fa-tag me-1"></i>{{ $pCategoryName }}
                                    </a>
                                    @if($pSubcatName)
                                        <div class="mt-1 w-100">
                                            <a href="{{ url('/product?category=' . $pCategorySlug . '&subcategory=' . $pSubcatSlug) }}"
                                                class="badge bg-light text-dark border text-decoration-none d-inline-block text-truncate" style="font-size:11px; max-width: 100%;">
                                                {{ $pSubcatName }}
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                @if($product->business)
                                    <p class="text-secondary mb-3 small">By {{ $product->business->business_name }}</p>
                                @endif
                                <a href="{{ url('/product/' . $product->slug) }}" class="btn btn-outline-primary w-100 btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- No Results Message -->
                    <div class="col-12 text-center" id="noResults">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle me-2"></i>
                            No products found matching your search criteria. Try different keywords.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @endif

        </div>
    </div>
    <!-- Products End -->

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dropdown Logic
            const categorySelect = document.getElementById('categorySelect');
            const subcategorySelect = document.getElementById('subcategorySelect');
            const selectedSubcatSlug = '{{ request("subcategory") ?? "" }}';

            function loadSubcategories(categorySlug, preselect) {
                subcategorySelect.innerHTML = '<option value="">All Sub-types</option>';
                if (!categorySlug) return;

                fetch('/api/subcategories?category=' + encodeURIComponent(categorySlug))
                    .then(res => res.json())
                    .then(subcategories => {
                        subcategories.forEach(sc => {
                            var opt = document.createElement('option');
                            opt.value = sc.slug;
                            opt.textContent = sc.name;
                            if (preselect && sc.slug === preselect) {
                                opt.selected = true;
                            }
                            subcategorySelect.appendChild(opt);
                        });
                    })
                    .catch(err => console.error('Subcategory load failed:', err));
            }

            categorySelect.addEventListener('change', function () {
                loadSubcategories(this.value, null);
            });

            if (categorySelect.value) {
                loadSubcategories(categorySelect.value, selectedSubcatSlug);
            }

        });
    </script>
@endpush