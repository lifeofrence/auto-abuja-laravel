@extends('layouts.admin')

@section('admin_content')
    <div class="page-header d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1">Edit Product: {{ $product->name }}</h4>
            <p class="text-muted mb-0">Update listing details and assignment</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-light">
            <i class="fa fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="admin-card">
                <div class="p-4">
                     <h5 class="fw-bold mb-4" style="font-size: 1rem;">Product Information</h5>
                     
                     @if ($errors->any())
                        <div class="alert alert-danger" style="border-radius: 8px;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                     @endif

                     <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                         @csrf
                         @method('PUT')

                         <div class="mb-3">
                             <label class="form-label text-muted small">Product Name</label>
                             <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                         </div>

                         <div class="mb-3">
                             <label class="form-label text-muted small">Slug</label>
                             <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug) }}" required style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                         </div>

                         <div class="row">
                             <div class="col-md-6 mb-3">
                                 <label class="form-label text-muted small">Business / Vendor</label>
                                 <select name="business_id" class="form-select" required style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                                     <option value="">Select Business</option>
                                     @foreach($businesses as $business)
                                         <option value="{{ $business->id }}" {{ (old('business_id', $product->business_id) == $business->id) ? 'selected' : '' }}>{{ $business->business_name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="col-md-6 mb-3">
                                 <label class="form-label text-muted small">Price</label>
                                 <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                             </div>
                         </div>

                         <div class="row">
                             <div class="col-md-6 mb-3">
                                 <label class="form-label text-muted small">Category</label>
                                 <select name="category_id" id="category_id" class="form-select" required style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                                     <option value="">Select Category</option>
                                     @foreach($categories as $category)
                                         <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="col-md-6 mb-3">
                                 <label class="form-label text-muted small">Subcategory</label>
                                 <select name="subcategory_id" id="subcategory_id" class="form-select" style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                                     <option value="">Select Subcategory (Optional)</option>
                                     @foreach($subcategories as $sub)
                                         <option value="{{ $sub->id }}" {{ (old('subcategory_id', $product->subcategory_id) == $sub->id) ? 'selected' : '' }}>{{ $sub->name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>

                         <div class="mb-3">
                             <label class="form-label text-muted small">Description</label>
                             <textarea name="description" class="form-control" rows="4" style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">{{ old('description', $product->description) }}</textarea>
                         </div>
                         
                         <div class="mb-4">
                             <label class="form-label text-muted small">Product Image (Leave blank to keep current)</label>
                             <input type="file" name="image" class="form-control" accept="image/*" style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                             @if($product->image_url)
                                 <div class="mt-2">
                                     <img src="{{ $product->image_url }}" alt="Current Image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                                 </div>
                             @endif
                         </div>

                         <div class="mb-4">
                             <label class="form-label text-muted small">Add Gallery Images (Optional)</label>
                             <input type="file" name="additional_images[]" class="form-control" accept="image/*" multiple style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                         </div>

                         <button type="submit" class="btn w-100" style="background: var(--primary-color, #F68B1E); color: #fff; border: none; padding: 12px; font-weight: 600; border-radius: 8px;">
                             <i class="fa fa-save me-1"></i> Update Product
                         </button>
                     </form>
                </div>
            </div>

            @if($product->images && $product->images->count() > 0)
                <div class="admin-card mt-4">
                    <div class="p-4">
                        <h5 class="fw-bold mb-4" style="font-size: 1rem;">Current Gallery Images</h5>
                        <div class="row g-3">
                            @foreach($product->images as $image)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="position-relative" style="border-radius: 8px; overflow: hidden; border: 1px solid #eef2f6;">
                                        <img src="{{ $image->image_url }}" alt="Gallery Image" style="width: 100%; height: 120px; object-fit: cover;">
                                        <form action="{{ route('admin.products.delete_image', $image->id) }}" method="POST" class="position-absolute" style="top: 5px; right: 5px;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this image from gallery?')" style="border-radius: 50%; width: 30px; height: 30px; padding: 0; d-flex align-items-center justify-content-center; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            const subcategorySelect = document.getElementById('subcategory_id');

            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;
                const optionElement = this.options[this.selectedIndex];
                const selectedCategoryName = optionElement.text;
                const slug = selectedCategoryName.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');

                subcategorySelect.innerHTML = '<option value="">Loading...</option>';

                if (!categoryId) {
                    subcategorySelect.innerHTML = '<option value="">Select Subcategory (Optional)</option>';
                    return;
                }

                fetch('/api/subcategories?category=' + slug)
                    .then(response => response.json())
                    .then(data => {
                        subcategorySelect.innerHTML = '<option value="">Select Subcategory (Optional)</option>';
                        data.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub.id;
                            option.textContent = sub.name;
                            subcategorySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching subcategories:', error);
                        subcategorySelect.innerHTML = '<option value="">Select Subcategory (Optional)</option>';
                    });
            });
        });
    </script>
@endsection
