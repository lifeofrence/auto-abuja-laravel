@extends('layouts.vendor')

@section('vendor_content')
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
        <div class="d-flex align-items-center mb-4">
            <div class="bg-primary-subtle p-3 rounded-circle me-3">
                <i class="fa fa-plus text-primary fs-4"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0">Post New Product / Service</h4>
                <p class="text-muted mb-0">List a vehicle, part, or automotive service</p>
            </div>
        </div>

        <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="productName" placeholder="Product Name" value="{{ old('name') }}" required>
                        <label for="productName">Listing Title (e.g. 2022 Toyota Corolla)</label>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="category_id" id="category_id"
                            class="form-select @error('category_id') is-invalid @enderror" required>
                            @if($category)
                                <option value="{{ $category->id }}" selected>{{ $category->name }} (Your Business Category)
                                </option>
                            @else
                                <option value="">No Category Found</option>
                            @endif
                        </select>
                        <label for="category_id">Primary Category</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="subcategory_id" id="subcategory_id"
                            class="form-select @error('subcategory_id') is-invalid @enderror">
                            <option value="">Select Subcategory</option>
                            @foreach($subcategories as $sub)
                                <option value="{{ $sub->id }}" {{ old('subcategory_id') == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="subcategory_id">Specific Subcategory</label>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                            id="price" placeholder="Price" value="{{ old('price') }}" required>
                        <label for="price">Asking Price (₦)</label>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                            id="description" placeholder="Description"
                            style="height: 120px">{{ old('description') }}</textarea>
                        <label for="description">Detailed Description (Condition, Features, Specs)</label>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 border border-dashed rounded-4 bg-light">
                        <label class="form-label fw-bold d-block mb-2 small text-uppercase">Featured Image</label>
                        <input type="file" name="image" id="image" class="form-control" required accept="image/*">
                        <small class="text-muted">Main image for the listing</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 border border-dashed rounded-4 bg-light">
                        <label class="form-label fw-bold d-block mb-2 small text-uppercase">Gallery Images</label>
                        <input type="file" name="additional_images[]" id="additional_images" class="form-control" multiple
                            accept="image/*">
                        <small class="text-muted">Add more photos (Max 10)</small>
                    </div>
                </div>

                <div class="col-12 mt-5">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold text-uppercase shadow-sm">
                        <i class="fa fa-cloud-upload-alt me-2"></i> PUBLISH PRODUCT NOW
                    </button>
                    <p class="text-center mt-3 mb-0 small text-muted">By publishing, you agree to our terms of service</p>
                </div>
            </div>
        </form>
    </div>
@endsection