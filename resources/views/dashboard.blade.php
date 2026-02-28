@extends('layouts.main')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0"
        style="background-image: url('{{ asset('img/carousel-bg-1.jpg') }}');">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Dashboard</h1>
                <p class="text-white fs-5">Welcome back, {{ auth()->user()->name }}</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Dashboard Content Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3 col-md-4">
                    <div class="bg-light rounded p-4 mb-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center fw-bold fs-4"
                                style="width: 60px; height: 60px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                                <span class="text-muted small">{{ auth()->user()->email }}</span>
                            </div>
                        </div>

                        <div class="list-group list-group-flush">
                            <a href="{{ route('dashboard') }}"
                                class="list-group-item list-group-item-action active bg-primary text-white border-primary rounded mb-2">
                                <i class="fa fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}"
                                class="list-group-item list-group-item-action bg-transparent border-0 mb-2">
                                <i class="fa fa-user me-2"></i> Profile Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}" id="logoutFormSidebar">
                                @csrf
                                <button type="submit"
                                    class="list-group-item list-group-item-action text-danger bg-transparent border-0">
                                    <i class="fa fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9 col-md-8">
                    <div class="row g-4 mb-4">
                        <!-- Stat Card 1 -->
                        @if(auth()->user()->role === 'business')
                            <div class="col-sm-6 col-xl-4">
                                <div
                                    class="bg-light rounded d-flex align-items-center justify-content-between p-4 border-start border-primary border-5">
                                    <i class="fa fa-building fa-3x text-primary"></i>
                                    <div class="ms-3 text-end">
                                        <p class="text-muted mb-2">My Businesses</p>
                                        <h4 class="mb-0 text-dark">{{ auth()->user()->businesses()->count() ?? 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Stat Card 2 -->
                        <div class="col-sm-6 col-xl-4">
                            <div
                                class="bg-light rounded d-flex align-items-center justify-content-between p-4 border-start border-success border-5">
                                <i class="fa fa-list fa-3x text-success"></i>
                                <div class="ms-3 text-end">
                                    <p class="text-muted mb-2">Account Status</p>
                                    <h4 class="mb-0 text-dark">Active</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Stat Card 3 -->
                        <div class="col-sm-6 col-xl-4">
                            <div
                                class="bg-light rounded d-flex align-items-center justify-content-between p-4 border-start border-warning border-5">
                                <i class="fa fa-calendar-check fa-3x text-warning"></i>
                                <div class="ms-3 text-end">
                                    <p class="text-muted mb-2">Joined Date</p>
                                    <h4 class="mb-0 text-dark">{{ auth()->user()->created_at ? auth()->user()->created_at->format('M Y') : 'N/A' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light rounded p-4">
                        <h4 class="mb-4">Recent Activity</h4>

                        @if(session('status') === 'profile-updated')
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa fa-check-circle me-2"></i>Your profile has been updated successfully.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <i class="fa fa-info-circle me-2"></i> Welcome to the A.R.T.S.P platform dashboard! Here you
                            will be able to manage your automotive journey and settings.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard Content End -->
@endsection