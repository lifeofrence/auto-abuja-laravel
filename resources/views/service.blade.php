@extends('layouts.main')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0"
        style="background-image: url('{{ asset("img/carousel-bg-2.jpg") }}');">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Services</h1>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Service Start -->
    <div class="container-xxl service py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase"> Browse Categories </h6>
                <h1 class="mb-5">Our Auto Services</h1>
            </div>
            <div class="row g-4 wow fadeInUp" data-wow-delay="0.3s">
                @php
                    $categories = \App\Models\Category::where('is_active', true)->orderBy('display_order')->get();
                @endphp

                @forelse($categories as $category)
                    <div class="col-lg-4 col-md-6">
                        <div class="d-flex {{ $loop->index % 2 == 1 ? 'bg-light' : '' }} py-5 px-4 h-100">
                            <i class="{{ $category->icon ?: 'fa fa-car' }} fa-3x text-primary flex-shrink-0"></i>
                            <div class="ps-4 d-flex flex-column">
                                <h5 class="mb-3">{{ $category->name }}</h5>
                                <p class="flex-grow-1">{{ Str::limit($category->description, 80) }}</p>
                                <div>
                                    <a class="text-secondary border-bottom"
                                        href="{{ url('/?category=' . $category->slug) }}">Browse Businesses & Products</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        <p>No categories available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Service End -->

@endsection