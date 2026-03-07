@extends('layouts.vendor')

@section('vendor_content')
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-0">Business Gallery</h4>
                <p class="text-muted mb-0">Manage showroom, workshop and team photos</p>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="bg-light p-4 rounded-4 mb-5 border-2 border-dashed border-primary border-opacity-25 shadow-sm">
            <form action="{{ route('vendor.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-center g-3">
                    <div class="col-md-9">
                        <label class="form-label fw-bold small text-uppercase text-muted">Add New Photos</label>
                        <input type="file" name="images[]" class="form-control" multiple required accept="image/*">
                        <small class="text-muted">You can select multiple images (JPG, PNG, max 5MB each)</small>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 py-2 mt-md-4 rounded-pill fw-bold">
                            <i class="fa fa-upload me-2"></i> UPLOAD NOW
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Gallery Grid -->
        <div class="row g-4">
            @foreach($images as $img)
                <div class="col-6 col-sm-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden position-relative gallery-card">
                        <img src="{{ asset('storage/' . $img->image_path) }}" class="w-100 object-fit-cover"
                            style="height: 200px;">
                        <div class="position-absolute top-0 end-0 p-2">
                            <form action="{{ route('vendor.gallery.destroy', $img->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm rounded-circle shadow"
                                    onclick="return confirm('Remove this image from your public gallery?')">
                                    <i class="fa fa-times small"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($images->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fa fa-images fa-4x text-muted mb-3 opacity-25"></i>
                    <p class="text-muted">Your gallery is currently empty. Upload photos of your office, store, or warehouse to
                        build trust with customers!</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .gallery-card {
            transition: all 0.3s ease;
        }

        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .object-fit-cover {
            object-fit: cover;
        }
    </style>
@endpush