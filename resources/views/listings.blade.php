@extends('layouts.main')

@section('content')
    <style>
        .listing-card {
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            height: 100%;
        }

        .listing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .listing-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .badge-featured {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #FFB400;
            color: #000;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .rating-stars {
            color: #FFB400;
        }

        #map {
            height: 500px;
            width: 100%;
            border-radius: 10px;
        }

        .filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .business-contact {
            font-size: 14px;
        }

        .business-contact i {
            width: 20px;
            text-align: center;
        }
    </style>

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0"
        style="background-image: url('{{ asset('img/carousel-bg-2.jpg') }}');">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{ $pageTitle }}</h1>
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'super_admin', 'moderator', 'support']))
                    <p class="text-white fs-5">{{ $businesses->total() }} Business{{ $businesses->total() != 1 ? 'es' : '' }}
                        Found</p>
                @endif
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Listings Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <!-- Search and Filter Section -->
            <div class="filter-section">
                <form method="GET" action="{{ url('/listings') }}" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search" placeholder="Search businesses..."
                            value="{{ $search }}">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="category" id="categorySelect" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ $categorySlug === $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="sub" id="subcategorySelect">
                            <option value="">All Subcategories</option>
                            @foreach($subcategories as $subcat)
                                <option value="{{ $subcat->slug }}" {{ $subcategorySlug === $subcat->slug ? 'selected' : '' }}>
                                    {{ $subcat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-search me-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- View Toggle -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'super_admin', 'moderator', 'support']))
                    <h5 class="mb-0">Showing {{ $businesses->firstItem() ?? 0 }} - {{ $businesses->lastItem() ?? 0 }} of
                        {{ $businesses->total() }} results</h5>
                @else
                    <h5 class="mb-0"></h5>
                @endif
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active" onclick="showGridView()">
                        <i class="fa fa-th"></i> Grid
                    </button>
                    <button type="button" class="btn btn-outline-primary" onclick="showMapView()">
                        <i class="fa fa-map"></i> Map
                    </button>
                </div>
            </div>

            <!-- Grid View -->
            <div id="gridView" class="row g-4">
                @forelse($businesses as $business)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="card listing-card">
                            <div class="position-relative">
                                <img src="{{ $business->image_url }}" class="card-img-top listing-image"
                                    alt="{{ $business->business_name }}">
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">
                                        <a href="{{ url('/business/' . $business->slug) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $business->business_name }}
                                        </a>
                                    </h5>
                                    @if($business->verified)
                                        <span class="badge bg-success" title="Verified Business">
                                            <i class="fa fa-check-circle"></i>
                                        </span>
                                    @endif
                                </div>

                                @if($business->category)
                                    <a href="{{ url('/listings?category=' . $business->category->slug) }}" class="badge text-decoration-none me-1 mb-2"
                                        style="background:#F68B1E; color:#000; font-size:12px;">
                                        <i class="fa fa-tag me-1"></i>{{ $business->category->name }}
                                    </a>
                                @endif

                                @if($business->subcategory)
                                    <span class="badge bg-{{ $business->subcategory->badge_color ?: 'primary' }} mb-2">
                                        {{ $business->subcategory->name }}
                                    </span>
                                @endif

                                <p class="card-text text-muted small mb-2">
                                    {{ Str::limit($business->description, 100) }}
                                </p>

                                <div class="business-contact mb-2">
                                    <div class="mb-1">
                                        <i class="fa fa-map-marker-alt text-primary"></i>
                                        <small>{{ $business->address }}</small>
                                    </div>
                                    <div class="mb-1">
                                        <i class="fa fa-phone text-primary"></i>
                                        <small>{{ $business->phone }}</small>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="rating-stars">
                                        @php $rating = round($business->rating_average); @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa{{ $i <= $rating ? 's' : 'r' }} fa-star"></i>
                                        @endfor
                                        <small class="text-muted">({{ $business->rating_count }})</small>
                                    </div>
                                    <a href="{{ url('/business/' . $business->slug) }}" class="btn btn-sm btn-primary">
                                        View Details <i class="fa fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fa fa-info-circle fa-3x mb-3"></i>
                            <h4>No businesses found</h4>
                            <p>Try adjusting your search or filter criteria</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Map View -->
            <div id="mapView" style="display: none;">
                <div id="map"></div>
                <div class="mt-3" id="mapListings"></div>
            </div>

            <!-- Pagination -->
            @if($businesses->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $businesses->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- Listings End -->

@endsection

@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
    <script>
        let map;
        let markers = [];
        const businesses = @json($mapBusinesses);

        function initMap() {
            // Center on Abuja
            const center = { lat: 9.0765, lng: 7.3986 };

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: center
            });

            // Add markers for each business
            businesses.forEach(business => {
                if (!business.latitude || !business.longitude) return;
                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(business.latitude), lng: parseFloat(business.longitude) },
                    map: map,
                    title: business.business_name
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `
                                <div style="max-width: 250px;">
                                    <h6>${business.business_name}</h6>
                                    <p class="small mb-1">${business.address}</p>
                                    <p class="small mb-2">${business.phone}</p>
                                    <a href="{{ url('/business') }}/${business.slug}" class="btn btn-sm btn-primary">
                                        View Details
                                    </a>
                                </div>
                            `
                });

                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });

                markers.push(marker);
            });
        }

        function showGridView() {
            document.getElementById('gridView').style.display = 'flex';
            document.getElementById('mapView').style.display = 'none';

            document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
            document.querySelector('.btn-group .btn:first-child').classList.add('active');
        }

        function showMapView() {
            document.getElementById('gridView').style.display = 'none';
            document.getElementById('mapView').style.display = 'block';

            document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
            document.querySelector('.btn-group .btn:last-child').classList.add('active');

            if (!map) {
                initMap();
            }
        }
    </script>
@endpush