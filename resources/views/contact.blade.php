@extends('layouts.main')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0"
        style="background-image: url('{{ asset("img/carousel-bg-1.jpg") }}');">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Contact Us</h1>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase"> Get In Touch </h6>
                <h1 class="mb-5"> For Any Inquiry</h1>
            </div>
            <div class="row g-4">
                <div class="col-12">
                    <div class="row gy-4">
                        <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="bg-light d-flex flex-column justify-content-center p-4 h-100">
                                <h5 class="text-uppercase mb-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>
                                    Our Location</h5>
                                <p class="m-0">No. 35 Lusaka Street, Wuse Zone 6, Abuja, Nigeria</p>
                            </div>
                        </div>
                        <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="bg-light d-flex flex-column justify-content-center p-4 h-100">
                                <h5 class="text-uppercase mb-3"><i class="fa fa-envelope text-primary me-2"></i> Email
                                    Us</h5>
                                <p class="m-0"><a href="mailto:info@artsp.ng" class="text-dark">info@quionltd.com</a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="bg-light d-flex flex-column justify-content-center p-4 h-100">
                                <h5 class="text-uppercase mb-3"><i class="fa fa-phone text-primary me-2"></i> Call Us
                                </h5>
                                <p class="m-0"><a href="tel:+2348037879981" class="text-dark">+234 803 787 9981</a></p>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Section -->
                <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
                    <iframe class="position-relative rounded w-100 h-100"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d252230.02028974562!2d6.9317188!3d9.0764785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x104e0baf7da48d0d%3A0x99a8fe4168c50bc8!2sAbuja%2C%20Federal%20Capital%20Territory%2C%20Nigeria!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s"
                        frameborder="0" style="min-height: 400px; border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>

                <!-- Contact Form -->
                <div class="col-md-6">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        <h4 class="mb-4">Send Us A Message</h4>
                        <p class="mb-4">Have questions about our platform? Need help registering your business? Want to
                            report an issue? Fill out the form below and we'll get back to you as soon as possible.</p>
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
                                        <input type="email" class="form-control" id="email" placeholder="Your Email"
                                            required>
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" placeholder="Your Phone" required>
                                        <label for="phone">Your Phone</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="subject" required>
                                            <option value="" selected>Select Subject</option>
                                            <option value="general">General Inquiry</option>
                                            <option value="business">Business Registration</option>
                                            <option value="support">Technical Support</option>
                                            <option value="partnership">Partnership Opportunity</option>
                                            <option value="complaint">Report an Issue</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a message here" id="message"
                                            style="height: 150px" required></textarea>
                                        <label for="message">Your Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Business Hours Start -->
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-primary text-uppercase"> Support Hours </h6>
                    <h1 class="mb-4">We're Here To Help</h1>
                    <p class="mb-4">Our support team is available to assist you with any questions or concerns about
                        using the A.R.T.S.P platform.</p>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="d-flex">
                                <i class="fa fa-clock text-primary me-3 mt-1"></i>
                                <div>
                                    <h5>Monday - Friday</h5>
                                    <p class="mb-0">8:00 AM - 6:00 PM</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex">
                                <i class="fa fa-clock text-primary me-3 mt-1"></i>
                                <div>
                                    <h5>Saturday</h5>
                                    <p class="mb-0">9:00 AM - 4:00 PM</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex">
                                <i class="fa fa-clock text-primary me-3 mt-1"></i>
                                <div>
                                    <h5>Sunday</h5>
                                    <p class="mb-0">Closed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex">
                                <i class="fa fa-headset text-primary me-3 mt-1"></i>
                                <div>
                                    <h5>Emergency Support</h5>
                                    <p class="mb-0">24/7 Available</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <h6 class="text-primary text-uppercase"> Follow Us </h6>
                    <h1 class="mb-4">Stay Connected</h1>
                    <p class="mb-4">Follow us on social media for the latest updates, automotive tips, and platform
                        news.</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-primary btn-social me-2" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-primary btn-social me-2" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-primary btn-social me-2" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-outline-primary btn-social me-2" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="mt-4">
                        <h5 class="mb-3">Quick Links</h5>
                        <div class="row">
                            <div class="col-6">
                                <p><i class="fa fa-check text-primary me-2"></i><a href="{{ url('/faq') }}"
                                        class="text-dark">FAQs</a></p>
                                <p><i class="fa fa-check text-primary me-2"></i><a href="{{ url('/about') }}"
                                        class="text-dark">About Us</a></p>
                                <p><i class="fa fa-check text-primary me-2"></i><a href="{{ url('/service') }}"
                                        class="text-dark">Services</a></p>
                            </div>
                            <div class="col-6">
                                <p><i class="fa fa-check text-primary me-2"></i><a href="{{ url('/listings') }}"
                                        class="text-dark">Businesses</a></p>
                                <p><i class="fa fa-check text-primary me-2"></i><a href="{{ url('/team') }}"
                                        class="text-dark">
                                        Owners</a></p>
                                <p><i class="fa fa-check text-primary me-2"></i><a href="{{ url('/testimonial') }}"
                                        class="text-dark">Testimonials</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Business Hours End -->

@endsection