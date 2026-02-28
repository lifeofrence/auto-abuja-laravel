@extends('layouts.main')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0"
        style="background-image: url('{{ asset("img/carousel-bg-1.jpg") }}');">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Testimonials</h1>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Testimonial Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase"> Client Testimonials </h6>
                <h1 class="mb-5">What Our Clients Say About Us</h1>
            </div>

            <!-- Testimonial Grid -->
            <div class="row g-4 mb-5">
                @forelse($testimonials as $index => $testimonial)
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index * 0.1) }}s">
                        <div class="testimonial-item bg-light p-4 h-100">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-shrink-0 rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-4"
                                    style="width: 60px; height: 60px; border: 2px solid var(--primary);">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-1">{{ $testimonial->name }}</h5>
                                    <p class="mb-0 text-primary">{{ $testimonial->position ?? 'Customer' }}</p>
                                </div>
                                <div class="ms-auto">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i
                                            class="fa fa-star {{ $i < ($testimonial->rating ?? 5) ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="mb-0">"{{ $testimonial->text }}"</p>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle me-2"></i>No testimonials available at the moment. Check back later!
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Submit Testimonial Start -->
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-primary text-uppercase"> Share Your Experience </h6>
                    <h1 class="mb-4">Submit Your Testimonial</h1>
                    <p class="mb-4">Have you used our platform to find automotive services or grow your business? We'd
                        love to hear about your experience! Your feedback helps us improve and assists other vehicle
                        owners in making informed decisions.</p>
                    <div class="d-flex mb-3">
                        <i class="fa fa-check text-primary me-3 mt-1"></i>
                        <div>
                            <h5>Share Your Honest Experience</h5>
                            <p class="mb-0">Tell us what you loved or what we can improve</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="fa fa-check text-primary me-3 mt-1"></i>
                        <div>
                            <h5>Help Other Vehicle Owners</h5>
                            <p class="mb-0">Your review helps others make better decisions</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="fa fa-check text-primary me-3 mt-1"></i>
                        <div>
                            <h5>Support Quality Service Providers</h5>
                            <p class="mb-0">Positive reviews help good businesses grow</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bg-white p-5 rounded shadow">
                        <h4 class="mb-4">Write Your Testimonial</h4>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="Your Name" required>
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="profession"
                                            placeholder="Your Profession">
                                        <label for="profession">Your Profession</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Your Email"
                                            required>
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <select class="form-select" id="rating" required>
                                            <option value="" selected>Rate Your Experience</option>
                                            <option value="5">⭐⭐⭐⭐⭐ Excellent (5 Stars)</option>
                                            <option value="4">⭐⭐⭐⭐ Very Good (4 Stars)</option>
                                            <option value="3">⭐⭐⭐ Good (3 Stars)</option>
                                            <option value="2">⭐⭐ Fair (2 Stars)</option>
                                            <option value="1">⭐ Poor (1 Star)</option>
                                        </select>
                                        <label for="rating">Rating</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Your Testimonial" id="message"
                                            style="height: 150px" required></textarea>
                                        <label for="message">Your Testimonial</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Submit Testimonial</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Submit Testimonial End -->

@endsection