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
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex py-5 px-4">
                        <i class="fa fa-wrench fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Auto Mechanics and Technicians</h5>
                            <p>Find trusted mechanics for all your vehicle repair needs.</p>
                            <a class="text-secondary border-bottom" href="{{ url('/listings') }}">Browse</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex bg-light py-5 px-4">
                        <i class="fa fa-car fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Automobile Dealership</h5>
                            <p>Connect with reliable car dealers and showrooms.</p>
                            <a class="text-secondary border-bottom" href="{{ url('/listings') }}">Browse</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex py-5 px-4">
                        <i class="fa fa-cogs fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Auto Spare Parts Dealership</h5>
                            <p>Genuine spare parts for various car models.</p>
                            <a class="text-secondary border-bottom" href="{{ url('/listings') }}">Browse</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex bg-light py-5 px-4">
                        <i class="fa fa-recycle fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Auto Dismantlers & Recyclers</h5>
                            <p>Eco-friendly disposal and parts recycling.</p>
                            <a class="text-secondary border-bottom" href="{{ url('/listings') }}">Browse</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex py-5 px-4">
                        <i class="fa fa-truck-pickup fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Tow Truck Operators</h5>
                            <p>24/7 towing services for emergencies.</p>
                            <a class="text-secondary border-bottom" href="{{ url('/listings') }}">Browse</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex bg-light py-5 px-4">
                        <i class="fa fa-plus-circle fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">New Category</h5>
                            <p>Explore other automotive services and categories.</p>
                            <a class="text-secondary border-bottom" href="{{ url('/listings') }}">Browse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

@endsection