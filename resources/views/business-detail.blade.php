@extends('layouts.main')

@section('content')

    <style>
        .business-header {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ $business->image_url }}');
            background-position: center;
            background-size: cover;
            padding: 100px 0;
            color: white;
            border-radius: 0 0 50px 50px;
        }

        .business-logo {
            width: 150px;
            height: 150px;
            object-fit: contain;
            background: white;
            border-radius: 20px;
            padding: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: -75px;
        }

        .contact-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            background: #fff;
        }

        .gallery-img {
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .gallery-img:hover {
            transform: scale(1.05);
        }

        .nav-pills .nav-link {
            color: #444;
            border-radius: 50px;
            padding: 10px 25px;
            margin-right: 10px;
        }

        .nav-pills .nav-link.active {
            background-color: #F68B1E;
        }
    </style>

    <!-- Business Header -->
    <div class="business-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold text-white mb-3">
                {{ $business->business_name }}
            </h1>
            <div class="d-flex justify-content-center align-items-center">
                <span class="badge bg-primary px-3 py-2 me-3">
                    {{ $business->category->name ?? '' }}
                </span>
                @if($business->verified)
                    <span class="text-success"><i class="fa fa-check-circle me-1"></i>Verified Business</span>
                @endif
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="text-center">
            <img src="{{ $business->logo_url }}" class="business-logo" alt="Logo">
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8">
                <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-about-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-about" type="button" role="tab">About</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-products-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-products" type="button" role="tab">Products & Services</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-gallery-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-gallery" type="button" role="tab">Gallery</button>
                    </li>
                </ul>

                <div class="tab-content border-top pt-4" id="pills-tabContent">
                    <!-- About Tab -->
                    <div class="tab-pane fade show active" id="pills-about" role="tabpanel">
                        <h4 class="fw-bold mb-4">Description</h4>
                        <p class="fs-5 mb-5">
                            {!! nl2br(e($business->description)) !!}
                        </p>

                        <h4 class="fw-bold mb-4">Location</h4>
                        <p class="mb-4">
                            <a href="{{ $business->google_maps_link ?: 'https://www.google.com/maps/search/?api=1&query=' . urlencode($business->address) }}" target="_blank" class="text-secondary text-decoration-none">
                                <i class="fa fa-map-marker-alt text-primary me-2"></i>{{ $business->address }}
                            </a>
                        </p>
                        <!-- Map placeholder -->
                        <div class="bg-light rounded p-4 text-center"
                            style="height: 300px; display: flex; align-items: center; justify-content: center; background-image: url('{{ asset("img/map-placeholder.jpg") }}'); background-size: cover;">
                            <a href="{{ $business->google_maps_link ?: 'https://www.google.com/maps/search/?api=1&query=' . urlencode($business->address) }}"
                                target="_blank" class="btn btn-dark">Open in Google Maps</a>
                        </div>
                    </div>

                    <!-- Products Tab -->
                    <div class="tab-pane fade" id="pills-products" role="tabpanel">
                        <div class="row g-4">
                            @forelse($products as $product)
                                <div class="col-md-6">
                                    <div class="card h-100 border shadow-sm">
                                        <img src="{{ $product->image_url }}" class="card-img-top"
                                            style="height: 200px; object-fit: cover;" alt="{{ $product->name }}">
                                        <div class="card-body">
                                            <h5 class="fw-bold">
                                                {{ $product->name }}
                                            </h5>
                                            <p class="text-primary fw-bold fs-5">₦
                                                {{ number_format($product->price, 2) }}
                                            </p>
                                            <a href="{{ url('/product/' . $product->slug) }}"
                                                class="btn btn-outline-primary btn-sm w-100">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted">No products or services listed yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Gallery Tab -->
                    <div class="tab-pane fade" id="pills-gallery" role="tabpanel">
                        <div class="row g-3">
                            @forelse($gallery as $img)
                                <div class="col-md-4">
                                    <img src="{{ $img->image_url }}" class="img-fluid gallery-img"
                                        alt="{{ $img->caption }}" data-bs-toggle="modal" data-bs-target="#galleryModal"
                                        onclick="setModalImg(this.src)">
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted">No images in gallery yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="contact-card p-4">
                    <h4 class="fw-bold mb-4">Contact Details</h4>
                    <div class="mb-4">
                        <div class="d-flex mb-3">
                            <div class="btn-square bg-light rounded-circle me-3">
                                <i class="fa fa-phone-alt text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Phone Number</h6>
                                <p class="mb-0">
                                    {{ $business->phone }}
                                </p>
                            </div>
                        </div>
                        @if($business->email)
                            <div class="d-flex mb-3">
                                <div class="btn-square bg-light rounded-circle me-3">
                                    <i class="fa fa-envelope text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Email Address</h6>
                                    <p class="mb-0">
                                        {{ $business->email }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if($business->whatsapp)
                            <div class="d-flex mb-3">
                                <div class="btn-square bg-light rounded-circle me-3">
                                    <i class="fab fa-whatsapp text-primary text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">WhatsApp</h6>
                                    <p class="mb-0">
                                        {{ $business->whatsapp }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-grid gap-2 mb-4">
                        <a href="tel:{{ $business->phone }}" class="btn btn-primary py-3">Call Now</a>
                        @if($business->whatsapp)
                            <a href="https://wa.me/{{ str_replace(['+', ' '], '', $business->whatsapp) }}"
                                class="btn btn-success py-3">WhatsApp Message</a>
                        @endif
                        <a href="{{ $business->google_maps_link ?: 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($business->address) }}"
                            target="_blank" class="btn btn-outline-dark py-3">
                            <i class="fa fa-directions me-2 text-primary"></i>Get Directions
                        </a>
                    </div>

                    <hr>

                    <h5 class="fw-bold mb-3 mt-4">Opening Hours</h5>
                    <ul class="list-unstyled">
                        @php $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; @endphp
                        @foreach($days as $day)
                            @php 
                                $hoursData = $business_hours[$day] ?? null; 
                                $displayHours = $hoursData ? ($hoursData['open'] . ' - ' . $hoursData['close']) : 'Closed';
                            @endphp
                            <li class="d-flex justify-content-between mb-2">
                                <span>{{ $day }}</span>
                                <span class="text-muted">{{ $displayHours }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-dark text-white rounded p-4 mt-4">
                    <h5 class="text-white mb-3">Verify this business</h5>
                    <p class="small mb-0">Our team ensures that all listed businesses are genuine. If you encounter any
                        issues, please <a href="{{ url('/contact') }}" class="text-primary">report it</a>.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <img src="" id="modalImg" class="img-fluid w-100 rounded">
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function setModalImg(src) {
            document.getElementById('modalImg').src = src;
        }
    </script>
@endpush