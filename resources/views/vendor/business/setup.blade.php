@extends('layouts.vendor')

@section('vendor_content')
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
        <div class="d-flex align-items-center mb-4">
            <div class="bg-primary-subtle p-3 rounded-circle me-3">
                <i class="fa fa-pencil-alt text-primary fs-4"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0">Business Profile Setup</h4>
                <p class="text-muted mb-0">Manage your automotive business listing and contact details</p>
            </div>
        </div>

        <form method="POST" action="{{ route('vendor.business.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <!-- Business Name -->
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="business_name"
                            class="form-control @error('business_name') is-invalid @enderror" id="businessName"
                            placeholder="Business Name"
                            value="{{ old('business_name', $business->business_name ?? $prefill['business_name'] ?? '') }}"
                            required>
                        <label for="businessName">Registered Business Name</label>
                        @error('business_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Category Selection -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="category_id" id="category_id"
                            class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id', $business->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="category_id">Primary Trade Category</label>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Subcategory Selection -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="subcategory_id" id="subcategory_id"
                            class="form-select @error('subcategory_id') is-invalid @enderror">
                            <option value="">Select Subcategory</option>
                        </select>
                        <label for="subcategory_id">Specialized Subcategory</label>
                        @error('subcategory_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Contact Details Header -->
                <div class="col-12 mt-4">
                    <h6 class="text-primary fw-bold text-uppercase small border-bottom pb-2">Contact & Online Presence</h6>
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            placeholder="Phone" value="{{ old('phone', $business->phone ?? $prefill['phone'] ?? '') }}"
                            required>
                        <label for="phone">Public Phone Number</label>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror"
                            id="whatsapp" placeholder="WhatsApp" value="{{ old('whatsapp', $business->whatsapp ?? '') }}">
                        <label for="whatsapp">WhatsApp Business Line</label>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" placeholder="Email"
                            value="{{ old('email', $business->email ?? $prefill['email'] ?? '') }}">
                        <label for="email">Business Email Address</label>
                    </div>
                </div>

                <!-- Website -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="website" class="form-control @error('website') is-invalid @enderror"
                            id="website" placeholder="Website" value="{{ old('website', $business->website ?? '') }}">
                        <label for="website">Website URL (if any)</label>
                    </div>
                </div>

                <!-- Location & Media Header -->
                <div class="col-12 mt-4">
                    <h6 class="text-primary fw-bold text-uppercase small border-bottom pb-2">Location & Branding</h6>
                </div>

                <!-- Address -->
                <div class="col-12">
                    <div class="form-floating">
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                            placeholder="Address" id="address" style="height: 100px"
                            required>{{ old('address', $business->address ?? $prefill['address'] ?? '') }}</textarea>
                        <label for="address">Full Physical Address / Shop Location</label>
                    </div>
                </div>

                <!-- Google Maps Link -->
                <div class="col-12">
                    <div class="form-floating">
                        <input type="url" name="google_maps_link"
                            class="form-control @error('google_maps_link') is-invalid @enderror" id="google_maps_link"
                            placeholder="Google Maps Link"
                            value="{{ old('google_maps_link', $business->google_maps_link ?? '') }}">
                        <label for="google_maps_link">Google Maps Share Link</label>
                        <small class="text-muted px-2">Copy link from Google Maps app</small>
                    </div>
                </div>

                <!-- Logo Upload -->
                <div class="col-md-6">
                    <div class="p-4 border border-dashed rounded-4 bg-light text-center">
                        <label class="form-label fw-bold d-block mb-3">Business Logo</label>
                        @if($business && $business->logo)
                            <img src="{{ asset('storage/' . $business->logo) }}" alt="Logo"
                                class="rounded-circle shadow-sm mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm"
                                style="width: 80px; height: 80px;">
                                <i class="fa fa-image text-muted fs-2"></i>
                            </div>
                        @endif
                        <input type="file" name="logo" class="form-control form-control-sm">
                    </div>
                </div>

                <!-- Cover Image Upload -->
                <div class="col-md-6">
                    <div class="p-4 border border-dashed rounded-4 bg-light text-center">
                        <label class="form-label fw-bold d-block mb-3">Profile Banner</label>
                        @if($business && $business->cover_image)
                            <img src="{{ asset('storage/' . $business->cover_image) }}" alt="Cover"
                                class="rounded shadow-sm mb-3 w-100" style="height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-white rounded d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm w-100"
                                style="height: 80px;">
                                <i class="fa fa-images text-muted fs-2"></i>
                            </div>
                        @endif
                        <input type="file" name="cover_image" class="form-control form-control-sm">
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="col-12 mt-4">
                    <div class="card border-0 bg-light p-4 rounded-4">
                        <h6 class="fw-bold mb-3"><i class="fa fa-clock me-2 text-primary"></i>Operation Hours</h6>
                        <div class="row g-3">
                            @php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                $hours = $business->business_hours ?? [];
                            @endphp
                            @foreach($days as $day)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center bg-white p-2 rounded-3 border">
                                        <div style="width: 90px;" class="small fw-bold ps-2">{{ $day }}</div>
                                        <div class="d-flex gap-2">
                                            <input type="text" name="business_hours[{{ $day }}][open]"
                                                class="form-control form-control-sm border-0 bg-light" placeholder="Open"
                                                value="{{ $hours[$day]['open'] ?? '08:00 AM' }}">
                                            <span class="align-self-center text-muted">-</span>
                                            <input type="text" name="business_hours[{{ $day }}][close]"
                                                class="form-control form-control-sm border-0 bg-light" placeholder="Close"
                                                value="{{ $hours[$day]['close'] ?? '06:00 PM' }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="col-12 mt-4">
                    <div class="form-floating">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                            placeholder="Description" id="description"
                            style="height: 150px">{{ old('description', $business->description ?? '') }}</textarea>
                        <label for="description">About Your Business</label>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <button class="btn btn-primary w-100 py-3 rounded-pill fw-bold text-uppercase shadow-sm" type="submit">
                        <i class="fa fa-save me-2"></i> Update Business Profile
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            const categorySelect = $('#category_id');
            const subcategorySelect = $('#subcategory_id');
            const initialCategoryId = categorySelect.val();
            const initialSubcategoryId = "{{ old('subcategory_id', $business->subcategory_id ?? '') }}";

            if (initialCategoryId) {
                loadSubcategories(initialCategoryId, initialSubcategoryId);
            }

            categorySelect.on('change', function () {
                loadSubcategories($(this).val());
            });

            function loadSubcategories(categoryId, selectedId = null) {
                if (!categoryId) {
                    subcategorySelect.empty().append('<option value="">Select Subcategory</option>');
                    return;
                }
                subcategorySelect.empty().append('<option value="">Loading...</option>');
                $.ajax({
                    url: `/vendor/subcategories/${categoryId}`,
                    type: 'GET',
                    success: function (data) {
                        subcategorySelect.empty().append('<option value="">Select Subcategory</option>');
                        $.each(data, function (key, value) {
                            subcategorySelect.append(`<option value="${value.id}" ${selectedId == value.id ? 'selected' : ''}>${value.name}</option>`);
                        });
                    }
                });
            }
        });
    </script>
@endpush