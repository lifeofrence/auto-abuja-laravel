@extends('layouts.admin')

@section('admin_content')
    <div class="page-header d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1">Create New Product</h4>
            <p class="text-muted mb-0">Add a new listing for a business</p>
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

                     <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                         @csrf

                         <div class="mb-3">
                             <label class="form-label text-muted small">Product Name</label>
                             <input type="text" name="name" id="product_name" class="form-control" value="{{ old('name') }}" required style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                         </div>

                         <div class="mb-3">
                             <label class="form-label text-muted small">Slug</label>
                             <input type="text" name="slug" id="product_slug" class="form-control" value="{{ old('slug') }}" required style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                             <small class="text-muted d-block mt-1">This will be auto-generated from the name, but you can edit it.</small>
                         </div>

                         <div class="row">
                             <div class="col-md-6 mb-3">
                                 <label class="form-label text-muted small">Business / Vendor</label>
                                 <select name="business_id" class="form-select" required style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                                     <option value="">Select Business</option>
                                     @foreach($businesses as $business)
                                         <option value="{{ $business->id }}" {{ old('business_id') == $business->id ? 'selected' : '' }}>{{ $business->business_name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="col-md-6 mb-3">
                                 <label class="form-label text-muted small">Price</label>
                                 <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                             </div>
                         </div>

                         <div class="row">
                             <div class="col-md-6 mb-3">
                                 <label class="form-label text-muted small">Category</label>
                                 <select name="category_id" id="category_id" class="form-select" required style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                                     <option value="">Select Category</option>
                                     @foreach($categories as $category)
                                         <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="col-md-6 mb-3">
                                 <label class="form-label text-muted small">Subcategory</label>
                                 <select name="subcategory_id" id="subcategory_id" class="form-select" style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                                     <option value="">Select Subcategory (Optional)</option>
                                 </select>
                             </div>
                         </div>

                         <div class="mb-3">
                             <label class="form-label text-muted small">Description</label>
                             <textarea name="description" class="form-control" rows="4" style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">{{ old('description') }}</textarea>
                         </div>
                         
                         <div class="mb-4">
                             <label class="form-label text-muted small">Product Image (Required)</label>
                             <input type="file" name="image" class="form-control" accept="image/*" required style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                         </div>

                         <div class="mb-4">
                             <label class="form-label text-muted small">Additional Gallery Images (Optional)</label>
                             <input type="file" name="additional_images[]" class="form-control" accept="image/*" multiple style="border-radius: 8px; border: 1px solid #eef2f6; padding: 10px 15px;">
                         </div>

                         <button type="submit" class="btn w-100" style="background: var(--primary-color, #F68B1E); color: #fff; border: none; padding: 12px; font-weight: 600; border-radius: 8px;">
                             <i class="fa fa-plus me-1"></i> Create Product
                         </button>
                     </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            const subcategorySelect = document.getElementById('subcategory_id');
            const nameInput = document.getElementById('product_name');
            const slugInput = document.getElementById('product_slug');

            // Auto-generate slug from name
            nameInput.addEventListener('input', function() {
                const slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
                slugInput.value = slug + '-' + Math.floor(Math.random() * 10000);
            });

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
