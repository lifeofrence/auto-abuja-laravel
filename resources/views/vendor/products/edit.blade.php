@extends('layouts.vendor')

@section('vendor_content')
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
        <div class="d-flex align-items-center mb-4">
            <div class="bg-primary-subtle p-3 rounded-circle me-3">
                <i class="fa fa-edit text-primary fs-4"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0">Edit Product / Service</h4>
                <p class="text-muted mb-0">Update listing details and manage photos</p>
            </div>
        </div>

        <form action="{{ route('vendor.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror" id="productName"
                            placeholder="Product Name" value="{{ old('name', $product->name) }}" required>
                        <label for="productName">Listing Title (e.g. 2022 Toyota Corolla)</label>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="category_id" id="category_id" class="form-select" disabled>
                            <option value="{{ $category->id }}" selected>{{ $category->name }} (Primary Category)</option>
                        </select>
                        <label for="category_id">Primary Category (Fixed)</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="subcategory_id" id="subcategory_id"
                            class="form-select @error('subcategory_id') is-invalid @enderror">
                            <option value="">Select Subcategory</option>
                            @foreach($subcategories as $sub)
                                <option value="{{ $sub->id }}" {{ old('subcategory_id', $product->subcategory_id) == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="subcategory_id">Specific Subcategory</label>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <input type="number" name="price"
                            class="form-control @error('price') is-invalid @enderror" id="price"
                            placeholder="Price" value="{{ old('price', $product->price) }}" required>
                        <label for="price">Asking Price (₦)</label>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <textarea name="description"
                            class="form-control @error('description') is-invalid @enderror" id="description"
                            placeholder="Description"
                            style="height: 120px">{{ old('description', $product->description) }}</textarea>
                        <label for="description">Detailed Description</label>
                    </div>
                </div>

                <!-- Current Featured Image -->
                <div class="col-md-6">
                    <div class="p-3 border border-dashed rounded-4 bg-light text-center">
                        <label class="form-label fw-bold d-block mb-3 small text-uppercase">Featured Image</label>
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $product->image) }}" class="rounded shadow-sm" style="height: 100px; object-fit: cover;">
                        </div>
                        <input type="file" name="image" id="image" class="form-control form-control-sm">
                        <small class="text-muted">Upload to replace current main image</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-4 border border-dashed rounded-4 bg-light text-center">
                        <label class="form-label fw-bold d-block mb-2 small text-uppercase">New Gallery Photos</label>
                        <div class="d-flex justify-content-center align-items-center mb-3" style="height: 60px;">
                            <i class="fa fa-images text-muted fs-1 opacity-25"></i>
                        </div>
                        <input type="file" name="additional_images[]" id="additional_images" class="form-control form-control-sm" multiple accept="image/*">
                        <small class="text-muted">Add more photos to your listing</small>
                    </div>
                </div>

                <!-- Current Gallery -->
                @if($product->images->count() > 0)
                    <div class="col-12 mt-4">
                        <h6 class="fw-bold text-uppercase small text-muted mb-3">Manage Existing Photos</h6>
                        <div class="row g-2">
                            @foreach($product->images as $img)
                                <div class="col-4 col-md-2">
                                    <div class="position-relative rounded-3 overflow-hidden shadow-sm" style="height: 80px;">
                                        <img src="{{ asset('storage/' . $img->image_path) }}" class="w-100 h-100 object-fit-cover">
                                        <button type="button" class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 m-1 p-0 px-1" 
                                            onclick="if(confirm('Delete this gallery photo?')) { document.getElementById('delete-img-{{ $img->id }}').submit(); }"
                                            style="width: 20px; height: 20px; font-size: 10px;">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="col-12 mt-5">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold text-uppercase shadow-sm">
                        <i class="fa fa-save me-2"></i> SAVE CHANGES
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if($product->images->count() > 0)
        @foreach($product->images as $img)
            <form id="delete-img-{{ $img->id }}" action="{{ route('vendor.products.delete_image', $img->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif
@endsection