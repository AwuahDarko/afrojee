@extends('backend.layouts.app')

@section('link')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />
@endsection

@section('title')
    Edit Product
@endsection

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom p-4">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show text-light" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-light">{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <p class="fw-bold mb-3">Edit Product</p>

                        <form role="form" class="text-start" method="POST" action="{{ route('admin.products.edit') }}"
                            id="product-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">

                            {{-- Name --}}
                            <div class="input-group input-group-outline my-3">
                                <input type="text" class="form-control" name="name" required
                                    placeholder="Name of product" value="{{ old('name', $product->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Default Price --}}
                            <div class="input-group input-group-outline my-3">
                                <input type="number" step="0.01" min="0" class="form-control" name="price" required
                                    placeholder="Default Price" value="{{ old('price', $product->price) }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Default Quantity --}}
                            <div class="input-group input-group-outline my-3">
                                <input type="number" min="0" class="form-control" name="quantity" required
                                    placeholder="Default Quantity" value="{{ old('quantity', $product->quantity) }}">
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Weight --}}
                            <div class="input-group input-group-outline my-3">
                                <input type="number" step="0.01" min="0" class="form-control" name="weight" required
                                    placeholder="Product weight (Kg)" value="{{ old('weight', $product->weight) }}">
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div class="input-group input-group-outline my-3">
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- MULTIPLE IMAGES SECTION --}}
                            <div class="mt-4">
                                <p class="fw-bold mb-2">Product Images 
                                    <small class="text-muted">
                                        ({{ $product->images->count() }} images) 
                                        <i class="bi bi-info-circle"> Add new or edit existing</i>
                                    </small>
                                </p>
                                
                                {{-- Existing Images --}}
                                @if($product->images->count() > 0)
                                    <div class="row mb-3">
                                        @foreach($product->images->sortBy('sort_order') as $index => $image)
                                            <div class="col-md-3 mb-3">
                                                <div class="card h-100">
                                                    <img src="{{ $image->image_path }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                                    <div class="card-body p-2">
                                                        <input type="hidden" name="existing_images[{{ $image->id }}][id]" value="{{ $image->id }}">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input existing-primary" 
                                                                   type="radio" name="primary_image" 
                                                                   value="existing_{{ $image->id }}"
                                                                   {{ $image->is_primary ? 'checked' : '' }}>
                                                            <label class="form-check-label small">Primary</label>
                                                        </div>
                                                        <input type="number" class="form-control form-control-sm" 
                                                               name="existing_images[{{ $image->id }}][sort_order]" 
                                                               value="{{ $image->sort_order }}" 
                                                               min="0" style="font-size: 0.8rem;">
                                                        <button type="button" class="btn btn-danger btn-sm w-100 mt-1 remove-existing-image"
                                                                data-image-id="{{ $image->id }}">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- New Images Upload --}}
                                <div id="new-images-container">
                                    @if($product->images->count() === 0)
                                        <div class="image-row mb-3 p-3 border rounded bg-light">
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    <input type="file" class="form-control" name="images[0][file]" accept="image/png, image/jpg, image/jpeg, image/bmp" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input primary-radio" type="radio" name="primary_image" value="0" checked>
                                                        <label class="form-check-label">Primary</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" class="form-control" name="images[0][sort_order]" value="0" placeholder="Order" min="0">
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="image-preview" style="width: 100px; height: 100px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-image w-100">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-dark btn-sm" id="add-new-image">Add New Image</button>
                                @error('images')
                                    <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Hidden Fields for Quill --}}
                            <input type="hidden" name="description" id="description" value="{{ $product->description }}">
                            <input type="hidden" name="how_to_use" id="how_to_use" value="{{ $product->how_to_use }}">
                            <input type="hidden" name="ingredients" id="ingredients" value="{{ $product->ingredients }}">

                            {{-- Quill Editors --}}
                            <p class="mt-4">Description</p>
                            <div id="desc-editor" class="my-3"></div>

                            <p>How to Use</p>
                            <div id="how-editor" class="my-3"></div>

                            <p>Ingredients</p>
                            <div id="ingre-editor" class="my-3"></div>

                            {{-- Sizes Section --}}
                            <div class="mt-4">
                                <p class="fw-bold mb-2">Sizes</p>
                                <div id="sizes-container">
                                    @if (!empty($product->sizes))
                                        @foreach ($product->sizes as $index => $size)
                                            <div class="size-row mb-2">
                                                <div class="row">
                                                    <div class="col-md-3 mb-2">
                                                        <input type="text" class="form-control"
                                                            name="sizes[{{ $index }}][size]"
                                                            value="{{ $size->size }}" placeholder="Size (e.g., Small)">
                                                        <input type="hidden" name="sizes[{{ $index }}][id]" value="{{ $size->id }}">
                                                    </div>
                                                    <div class="col-md-2 mb-2">
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="sizes[{{ $index }}][price]"
                                                            value="{{ $size->price }}" placeholder="Price">
                                                    </div>
                                                    <div class="col-md-2 mb-2">
                                                        <input type="number" class="form-control"
                                                            name="sizes[{{ $index }}][quantity]"
                                                            value="{{ $size->quantity }}" placeholder="Quantity">
                                                    </div>
                                                    <div class="col-md-2 mb-2">
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="sizes[{{ $index }}][weight]"
                                                            value="{{ $size->weight }}" placeholder="Weight (kg)">
                                                    </div>
                                                    <div class="col-md-2 mb-2">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-size w-100">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        {{-- Default empty row --}}
                                        <div class="size-row mb-2">
                                            <div class="row">
                                                <div class="col-md-3 mb-2">
                                                    <input type="text" class="form-control" name="sizes[0][size]"
                                                        placeholder="Size (e.g., Small)">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="sizes[0][price]" placeholder="Price">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <input type="number" class="form-control"
                                                        name="sizes[0][quantity]" placeholder="Quantity">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="sizes[0][weight]" placeholder="Weight (kg)">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-size w-100">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-dark btn-sm mt-2" id="add-size">Add Size</button>
                            </div>

                            {{-- Submit --}}
                            <div class="text-center mb-4 mt-4">
                                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Update Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Quill editors
            const desc = new Quill('#desc-editor', { theme: 'snow' });
            const how = new Quill('#how-editor', { theme: 'snow' });
            const ingre = new Quill('#ingre-editor', { theme: 'snow' });

            // Load existing HTML
            desc.clipboard.dangerouslyPasteHTML(0, `{!! $product->description !!}`);
            how.clipboard.dangerouslyPasteHTML(0, `{!! $product->how_to_use !!}`);
            ingre.clipboard.dangerouslyPasteHTML(0, `{!! $product->ingredients !!}`);

            // Store Quill values before submitting
            document.getElementById('product-form').addEventListener('submit', function() {
                document.getElementById('description').value = desc.root.innerHTML;
                document.getElementById('how_to_use').value = how.root.innerHTML;
                document.getElementById('ingredients').value = ingre.root.innerHTML;
            });

            // Dynamic sizes section
            document.getElementById('add-size').addEventListener('click', function() {
                const container = document.getElementById('sizes-container');
                const index = container.children.length;
                const newRow = document.createElement('div');
                newRow.className = 'size-row mb-2';
                newRow.innerHTML = `
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="text" class="form-control" name="sizes[${index}][size]" placeholder="Size (e.g., Medium)">
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="number" step="0.01" class="form-control" name="sizes[${index}][price]" placeholder="Price">
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="number" class="form-control" name="sizes[${index}][quantity]" placeholder="Quantity">
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="number" step="0.01" class="form-control" name="sizes[${index}][weight]" placeholder="Weight (kg)">
                        </div>
                        <div class="col-md-2 mb-2">
                            <button type="button" class="btn btn-danger btn-sm remove-size w-100">Remove</button>
                        </div>
                    </div>
                `;
                container.appendChild(newRow);
            });

            // Remove size
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-size')) {
                    e.target.closest('.size-row').remove();
                }
            });

            // NEW: Multiple Images Logic
            let newImageIndex = {{ $product->images->count() > 0 ? $product->images->count() : 1 }};

            // Add new image row
            document.getElementById('add-new-image').addEventListener('click', function() {
                const container = document.getElementById('new-images-container');
                const newRow = document.createElement('div');
                newRow.className = 'image-row mb-3 p-3 border rounded bg-light';
                newRow.innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <input type="file" class="form-control" name="images[${newImageIndex}][file]" accept="image/png, image/jpg, image/jpeg, image/bmp" required>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input primary-radio" type="radio" name="primary_image" value="${newImageIndex}">
                                <label class="form-check-label">Primary</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="images[${newImageIndex}][sort_order]" value="${newImageIndex}" placeholder="Order" min="0">
                        </div>
                        <div class="col-md-3">
                            <div class="image-preview" style="width: 100px; height: 100px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-image w-100">Remove</button>
                        </div>
                    </div>
                `;
                container.appendChild(newRow);
                newImageIndex++;
            });

            // Remove new image row
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-image')) {
                    const rows = document.querySelectorAll('#new-images-container .image-row');
                    if (rows.length > 1 || {{ $product->images->count() > 0 ? 'true' : 'false' }}) {
                        e.target.closest('.image-row').remove();
                    }
                }
                
                // Remove existing image (mark for deletion)
                if (e.target.classList.contains('remove-existing-image')) {
                    if (confirm('Are you sure you want to remove this image?')) {
                        e.target.closest('.col-md-3').remove();
                        const imageId = e.target.dataset.imageId;
                        // Add hidden input to mark for deletion
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'delete_images[]';
                        hiddenInput.value = imageId;
                        document.getElementById('product-form').appendChild(hiddenInput);
                    }
                }
            });

            // Image preview for new uploads
            document.addEventListener('change', function(e) {
                if (e.target.type === 'file') {
                    const file = e.target.files[0];
                    if (file) {
                        const preview = e.target.closest('.row').querySelector('.image-preview');
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.innerHTML = `<img src="${e.target.result}" style="max-width:100%; max-height:100%; object-fit: cover;">`;
                        }
                        reader.readAsDataURL(file);
                    }
                }
            });

            // Ensure only one primary image
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('primary-radio') || e.target.classList.contains('existing-primary')) {
                    // Remove checked from all other primary radios
                    document.querySelectorAll('input[name="primary_image"]').forEach(radio => {
                        if (radio !== e.target) radio.checked = false;
                    });
                    e.target.checked = true;
                }
            });
        });
    </script>
@endsection