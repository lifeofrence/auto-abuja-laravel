<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>A.R.T.S.P - Automotive Resource & Technical Service Platform</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body class="bg-light">
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <div class="container-fluid bg-light p-0">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-map-marker-alt text-primary me-2"></small>
                    <small>No. 35 Lusaka Street, Wuse Zone 6, Abuja, Nigeria</small>
                </div>
                <!-- <div class="h-100 d-inline-flex align-items-center py-3">
                    <small class="far fa-clock text-primary me-2"></small>
                    <small>Mon - Fri : 09.00 AM - 09.00 PM</small>
                </div> -->
            </div>
            <div class="col-lg-5 px-5 text-end">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-phone-alt text-primary me-2"></small>
                    <small>(+234) 803 787 9981</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i
                            class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i
                            class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-sm-square bg-white text-primary me-0" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-car me-3"></i>A.R.T.S.P</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ url('/') }}" class="nav-item nav-link">Home</a>
                <a href="{{ url('/about') }}" class="nav-item nav-link">About Us</a>
                <a href="{{ url('/team') }}" class="nav-item nav-link">Owner</a>
            </div>

            @auth
                <div class="nav-item dropdown d-none d-lg-block">
                    <a href="#" class="nav-link dropdown-toggle btn btn-primary py-4 px-lg-5 text-white"
                        data-bs-toggle="dropdown">
                        <i class="fa fa-user-circle me-2"></i>
                        {{ explode(' ', Auth::user()->name)[0] }}
                    </a>
                    <div class="dropdown-menu fade-up m-0 shadow-sm border-0">
                        <a href="{{ url('/dashboard') }}" class="dropdown-item"><i
                                class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                        <a href="{{ url('/profile-edit') }}" class="dropdown-item"><i
                                class="fa fa-user-edit me-2"></i>Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                <i class="fa fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Mobile login link -->
                <a href="{{ url('/dashboard') }}" class="nav-item nav-link d-lg-none">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="d-lg-none">
                    @csrf
                    <button type="submit" class="nav-item nav-link text-danger border-0 bg-transparent">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
                    <i class="fa fa-user me-2"></i> Login / Register
                </a>
                <a href="{{ route('login') }}" class="nav-item nav-link d-lg-none">Login / Register</a>
            @endauth
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Main Content -->
    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Contact Us</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>No. 35 Lusaka Street, Wuse Zone 6, Abuja,
                        Nigeria</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>(+234) 803 787 9981</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>Info@quionltd.com</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Main Menu</h4>
                    <a class="btn btn-link" href="{{ url('/') }}">Home</a>
                    <a class="btn btn-link" href="{{ url('/about') }}">About Us</a>
                    <a class="btn btn-link" href="{{ url('/team') }}">Owners</a>
                    <a class="btn btn-link" href="{{ url('/service') }}">Services</a>
                    <a class="btn btn-link" href="{{ url('/product') }}">Products</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="{{ route('login') }}">Sign In</a>
                    <a class="btn btn-link" href="{{ route('register') }}">Register</a>
                    <a class="btn btn-link" href="{{ url('/testimonial') }}">Testimonials</a>
                    <a class="btn btn-link" href="{{ url('/listings') }}"> Business</a>
                    <a class="btn btn-link" href="mailto:info@artsp.com.ng">Send an Email</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Services</h4>
                    <a class="btn btn-link" href="">Auto Mechanics & Technicians</a>
                    <a class="btn btn-link" href="">Automobile Dealership</a>
                    <a class="btn btn-link" href="">Auto Spare Parts</a>
                    <a class="btn btn-link" href="">Auto Dismantlers & Recyclers</a>
                    <a class="btn btn-link" href="">Tow Truck Operators</a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#"> Quion Nigeria Limited</a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="{{ url('/') }}">Home</a>
                            <a href="#">Cookies</a>
                            <a href="{{ url('/contact') }}">Help</a>
                            <a href="{{ url('/faq') }}">FQAs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>