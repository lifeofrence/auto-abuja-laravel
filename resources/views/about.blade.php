@extends('layouts.main')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0"
        style="background-image: url('{{ asset('img/carousel-bg-1.jpg') }}');">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">About Us</h1>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 pt-4" style="min-height: 400px;">
                    <div class="position-relative h-100 wow fadeIn" data-wow-delay="0.1s">
                        <img class="position-absolute img-fluid w-100 h-100" src="{{ asset('img/about.jpg') }}"
                            style="object-fit: cover;" alt="">
                        <div class="position-absolute top-0 end-0 mt-n4 me-n4 py-4 px-5"
                            style="background: rgba(0, 0, 0, .08);">
                            <h1 class="display-4 text-white mb-0">9 <span class="fs-4">Years</span></h1>
                            <h4 class="text-white">Experience</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h6 class="text-primary text-uppercase"> About Us </h6>
                    <h1 class="mb-4"><span class="text-primary">A.R.T.S.P</span> - Automotive Resource & Technical
                        Service Platform</h1>
                    <p class="mb-4">A.R.T.S.P is your trusted partner in automotive care, connecting vehicle owners
                        across Abuja with verified service providers, quality parts, and expert support.</p>
                    <div class="row g-4 mb-3 pb-3">
                        <div class="col-12 wow fadeIn" data-wow-delay="0.1s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1"
                                    style="width: 45px; height: 45px;">
                                    <span class="fw-bold text-secondary">01</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Our Vision</h6>
                                    <ul class="mb-0 ps-3">
                                        <li>To empower every vehicle owner with the knowledge, tools, and support they need
                                            to maintain their cars with confidence and ease.</li>
                                        <li>To revolutionize how drivers access quality auto parts and services — fast,
                                            affordable, and stress-free.</li>
                                        <li>To make car maintenance simple and accessible for everyone, from first-time
                                            drivers to seasoned gearheads.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 wow fadeIn" data-wow-delay="0.3s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1"
                                    style="width: 45px; height: 45px;">
                                    <span class="fw-bold text-secondary">02</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Our Mission</h6>
                                    <ul class="mb-0 ps-3">
                                        <li>To provide clear, reliable, and accessible car maintenance advice and tools to
                                            help every driver take better care of their vehicle.</li>
                                        <li>To connect drivers with trusted automotive service providers through a simple,
                                            transparent, and efficient online platform.</li>
                                        <li>To simplify vehicle ownership by offering expert advice, reliable service
                                            options, and trusted tools — all in one place.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- FAQ Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="mb-4">Frequently Asked Questions (FAQ)</h1>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    Why is regular car maintenance important?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Regular car maintenance helps prevent costly repairs, ensures your vehicle runs
                                    efficiently, improves safety, and extends the lifespan of your car.
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    How often should I change my car's oil?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Most vehicles require an oil change every 5,000 to 7,500 kilometers, but check your
                                    owner's manual for specific recommendations for your vehicle.
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading7">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                    How often should I check my tire pressure?
                                </button>
                            </h2>
                            <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Check your tire pressure at least once a month and before long trips. Proper tire
                                    pressure improves fuel efficiency and safety.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading8">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                    What is tire rotation and why is it important?
                                </button>
                            </h2>
                            <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Tire rotation involves moving tires to different positions on your vehicle to ensure
                                    even wear, extending tire life and improving performance.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading9">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                    When should I replace my tires?
                                </button>
                            </h2>
                            <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Replace tires when tread depth is below 2mm, when you see visible damage, or after 6
                                    years regardless of wear. Use the penny test to check tread depth.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ End -->

@endsection