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

                            {{-- Image --}}
                            <div class="input-group input-group-outline my-3">
                                <input type="file" class="form-control" name="image" id="image"
                                    accept="image/png, image/jpg, image/jpeg, image/bmp">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Preview Current Image --}}
                            @if ($product->image)
                                <div class="text-center mb-3">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image"
                                        class="rounded shadow-sm" width="120">
                                </div>
                            @endif

                            {{-- Hidden Fields for Quill --}}
                            <input type="hidden" name="description" id="description" value="{{ $product->description }}">
                            <input type="hidden" name="how_to_use" id="how_to_use" value="{{ $product->how_to_use }}">
                            <input type="hidden" name="ingredients" id="ingredients" value="{{ $product->ingredients }}">

                            {{-- Quill Editors --}}
                            <p>Description</p>
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
                                                <div class="col-3 mb-2">
                                                    <input type="text" class="form-control input-group-outline" name="sizes[0][size]"
                                                        placeholder="Size (e.g., Small)" style="border: 1px solid #ced4da;">
                                                </div>
                                                <div class="col-2 mb-2">
                                                    <input type="number" step="0.01" class="form-control input-group-outline"
                                                        name="sizes[0][price]" placeholder="Price" style="border: 1px solid #ced4da;">
                                                </div>
                                                <div class="col-2 mb-2">
                                                    <input type="number" class="form-control input-group-outline"
                                                        name="sizes[0][quantity]" placeholder="Quantity" style="border: 1px solid #ced4da;">
                                                </div>
                                                <div class="col-2 mb-2">
                                                    <input type="number" step="0.01" class="form-control input-group-outline"
                                                        name="sizes[0][weight]" placeholder="Weight (kg)" style="border: 1px solid #ced4da;">
                                                </div>
                                                <div class="col-2 mb-2">
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

    <script defer>
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
                        <div class="col-3 mb-2">
                            <input type="text" class="form-control input-group-outline" name="sizes[${index}][size]" placeholder="Size (e.g., Medium)" style="border: 1px solid #ced4da;">
                        </div>
                        <div class="col-2 mb-2">
                            <input type="number" step="0.01" class="form-control input-group-outline" name="sizes[${index}][price]" placeholder="Price" style="border: 1px solid #ced4da;">
                        </div>
                        <div class="col-2 mb-2">
                            <input type="number" class="form-control input-group-outline" name="sizes[${index}][quantity]" placeholder="Quantity" style="border: 1px solid #ced4da;">
                        </div>
                        <div class="col-2 mb-2">
                            <input type="number" step="0.01" class="form-control input-group-outline" name="sizes[${index}][weight]" placeholder="Weight (kg)" style="border: 1px solid #ced4da;">
                        </div>
                        <div class="col-2 mb-2">
                            <button type="button" class="btn btn-danger btn-sm remove-size w-100">Remove</button>
                        </div>
                    </div>
                `;
                container.appendChild(newRow);
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-size')) {
                    e.target.closest('.size-row').remove();
                }
            });
        });
    </script>
@endsection
