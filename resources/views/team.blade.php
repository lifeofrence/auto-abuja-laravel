@extends('layouts.main')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0"
        style="background-image: url('{{ asset("img/carousel-bg-2.jpg") }}');">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Business Owner</h1>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Business Owners Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="mb-5">Meet Our Registered Business Owners</h1>
                <p class="mb-5">Connect with verified automotive business owners across Abuja</p>
            </div>

            <!-- Search Bar -->
            <div class="row mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-lg-8 mx-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa fa-search text-primary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="ownerSearch"
                            placeholder="Search by name, business, or location...">
                    </div>
                </div>
            </div>

            <!-- Business Owners Grid -->
            <div class="row g-4" id="ownersGrid">
                @forelse($businesses as $index => $business)
                    <div class="col-lg-4 col-md-6 wow fadeInUp owner-card" data-wow-delay="{{ 0.1 + ($index * 0.1) }}s">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden">
                            <div class="position-relative">
                                <img src="{{ asset($business->cover_image ?? 'img/default-business.jpg') }}" class="card-img-top" alt="{{ $business->user->name ?? $business->business_name }}"
                                    style="height: 250px; object-fit: cover;">
                                @if($business->verified)
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-primary">Verified</span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-2">{{ $business->business_name }}</h5>
                                <p class="text-muted mb-3"><i class="fa fa-briefcase me-2"></i>{{ $business->category->name ?? 'Automotive Business' }}</p>
                                <div class="mb-2">
                                    <i class="fa fa-user text-primary me-2"></i>
                                    <span class="text-dark">{{ $business->user->name ?? 'Business Owner' }}</span>
                                </div>
                                <div class="mb-2">
                                    <i class="fa fa-building text-primary me-2"></i>
                                    <a href="{{ url('/business/' . $business->slug) }}" class="text-dark fw-bold">{{ $business->business_name }}</a>
                                </div>
                                <div class="mb-2">
                                    <i class="fa fa-phone text-primary me-2"></i>
                                    <a href="tel:{{ $business->phone }}" class="text-dark">{{ $business->phone }}</a>
                                </div>
                                <div class="mb-2">
                                    <i class="fa fa-map-marker-alt text-primary me-2"></i>
                                    <span class="text-dark">{{ Str::limit($business->address, 40) }}</span>
                                </div>
                                <div class="mb-3">
                                    <i class="fa fa-envelope text-primary me-2"></i>
                                    <a href="mailto:{{ $business->email }}" class="text-dark">{{ $business->email ?? 'N/A' }}</a>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="tel:{{ $business->phone }}" class="btn btn-primary btn-sm flex-fill">
                                        <i class="fa fa-phone me-1"></i>Call
                                    </a>
                                    @if($business->email)
                                        <a href="mailto:{{ $business->email }}" class="btn btn-outline-primary btn-sm flex-fill">
                                            <i class="fa fa-envelope me-1"></i>Email
                                        </a>
                                    @endif
                                    <a href="{{ url('/business/' . $business->slug) }}" class="btn btn-outline-dark btn-sm flex-fill">
                                        <i class="fa fa-eye me-1"></i>View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle me-2"></i>No registered business owners available at the moment.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- No Results Message -->
            <div class="row mt-4 d-none" id="noResults">
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle me-2"></i>No business owners found matching your search.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Business Owners End -->

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('ownerSearch');
            const ownersGrid = document.getElementById('ownersGrid');
            const noResults = document.getElementById('noResults');

            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                const ownerCards = ownersGrid.querySelectorAll('.owner-card');
                let visibleCount = 0;

                ownerCards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (visibleCount === 0) {
                    noResults.classList.remove('d-none');
                } else {
                    noResults.classList.add('d-none');
                }
            });
        });
    </script>
@endpush