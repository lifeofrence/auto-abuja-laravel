@extends('layouts.vendor')

@section('vendor_content')
    <!-- Stat Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 border-start border-primary border-5 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small fw-bold text-uppercase">Portal ID</p>
                        <h4 class="mb-0 fw-bold">{{ auth()->user()->vio_user_id }}</h4>
                    </div>
                    <div class="bg-primary-subtle p-3 rounded-circle">
                        <i class="fa fa-id-card text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 border-start border-success border-5 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Account Status</p>
                            <h4 class="mb-0 fw-bold text-success text-capitalize">{{ auth()->user()->status }}</h4>
                        </div>
                        <div class="bg-success-subtle p-3 rounded-circle">
                            <i class="fa fa-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div> -->

        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 border-start border-warning border-5 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small fw-bold text-uppercase">Member Type</p>
                        <h4 class="mb-0 fw-bold text-dark text-capitalize">{{ auth()->user()->role }}</h4>
                    </div>
                    <div class="bg-warning-subtle p-3 rounded-circle">
                        <i class="fa fa-user-tag text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Overview -->
    <div class="row g-4">
        <div class="col-md-7">
            <!-- Business Info Summary -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-bold mb-0">Business Overview</h5>
                    <a href="{{ route('vendor.business.index') }}" class="btn btn-sm btn-light rounded-pill px-3">Manage</a>
                </div>
                <div class="mb-4">
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1">Company Name</label>
                    <p class="h6 fw-bold mb-0">{{ auth()->user()->business_name ?: 'N/A' }}</p>
                </div>
                <div class="mb-4">
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1">Registered Category</label>
                    <p class="h6 fw-bold mb-0 text-primary">{{ auth()->user()->service_category ?: 'N/A' }}</p>
                </div>
                <div>
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1">Business Address</label>
                    <p class="small mb-0"><i
                            class="fa fa-map-marker-alt text-danger me-2"></i>{{ auth()->user()->business_address ?: 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Trade Info -->
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4">Special Trade License</h5>
                <div class="p-3 bg-light rounded-3 mb-3">
                    <label class="text-muted tiny fw-bold text-uppercase d-block mb-1">Type of Service</label>
                    <span class="fw-bold">{{ auth()->user()->service_type ?: 'N/A' }}</span>
                </div>
                <p class="text-muted small mb-0">
                    {{ auth()->user()->service_description ?: 'No service description provided.' }}
                </p>
            </div>
        </div>

        <div class="col-md-5">
            <!-- License Validity -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-4">License Validity</h5>
                <div class="d-flex align-items-center mb-4">
                    <div
                        class="bg-{{ strtolower(auth()->user()->license_status) == 'expired' ? 'danger' : 'success' }} p-3 rounded-circle me-3">
                        <i class="fa fa-certificate text-white"></i>
                    </div>
                    <div>
                        <h6
                            class="mb-0 text-uppercase fw-bold text-{{ strtolower(auth()->user()->license_status) == 'expired' ? 'danger' : 'success' }}">
                            {{ auth()->user()->license_status ?: 'Unknown' }}
                        </h6>
                        <small class="text-muted">Portal Verification Status</small>
                    </div>
                </div>
                <div class="row text-center g-0 border rounded-3 overflow-hidden">
                    <div class="col-6 p-2 bg-light border-end">
                        <small class="text-muted d-block tiny fw-bold">ISSUED</small>
                        <span
                            class="small fw-bold">{{ auth()->user()->license_start_date ? auth()->user()->license_start_date->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div class="col-6 p-2 bg-light">
                        <small class="text-muted d-block tiny fw-bold">EXPIRY</small>
                        <span
                            class="small fw-bold {{ strtolower(auth()->user()->license_status) == 'expired' ? 'text-danger' : '' }}">
                            {{ auth()->user()->license_end_date ? auth()->user()->license_end_date->format('M d, Y') : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Profile Completion / Quick Actions -->
            <div class="card border-0 bg-primary text-white shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-white mb-3">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('vendor.products.create') }}" class="btn btn-light fw-bold rounded-pill">
                        <i class="fa fa-plus-circle me-2"></i>Post New Product
                    </a>
                    <a href="{{ route('vendor.gallery.index') }}" class="btn btn-outline-light rounded-pill">
                        <i class="fa fa-images me-2"></i>Upload Gallery Photos
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .tiny {
            font-size: 0.65rem;
        }

        .bg-primary-subtle {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1);
        }
    </style>
@endpush