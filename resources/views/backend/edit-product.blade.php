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
                        <p>Edit Product</p>
                        <form role="form" class="text-start" method="POST" action="{{ route('admin.products.edit') }}"
                            id="product-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">

                            <div class="input-group input-group-outline my-3">
                                <input type="text" class="form-control" name="name" required
                                    placeholder="Name of product" value="{{ old('name', $product->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <input type="number" class="form-control" name="price" required
                                    placeholder="Product price" value="{{ old('price', $product->price) }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <input type="number" class="form-control" name="quantity" required
                                    placeholder="Product quantity" value="{{ old('quantity', $product->quantity) }}">
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <input type="number" class="form-control" name="weight" required
                                    placeholder="Product weight (Kg)" value="{{ old('weight', $product->weight) }}">
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <select name="category" id="category" class="form-control" value={{$product->category_id}}>
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                        <option 
                                         value="{{ $category->id }}"> {{ $category->name }} </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <input type="file" class="form-control" name="image" id="image" 
                                    accept="image/png, image/jpg, image/jpeg, image/bmp">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="hidden" name="description" id="description" value="{{ $product->description }}">
                            <input type="hidden" name="how_to_use" id="how_to_use" value="{{ $product->how_to_use }}">
                            <input type="hidden" name="ingredients" id="ingredients" value="{{ $product->ingredients }}">
                            <p>Description</p>
                            <div id="desc-editor" class="my-3"></div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <p>How to use</p>
                            <div id="how-editor" class="my-3"></div>
                            @error('how_to_use')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <p>Ingredients</p>
                            <div id="ingre-editor"></div>
                            @error('ingredients')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="text-center mb-4">
                                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Save</button>
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

            const desc = new Quill('#desc-editor', {
                theme: 'snow'
            });


            // desc.root.innerHTML = `{{ $product->description }}`
            desc.clipboard.dangerouslyPasteHTML(0, `{!! $product->description !!}`);


            const how = new Quill('#how-editor', {
                theme: 'snow'
            });
            // how.root.innerHTML = `{{ $product->how_to_use }}`
            how.clipboard.dangerouslyPasteHTML(0, `{!! $product->how_to_use !!}`);


            const ingre = new Quill('#ingre-editor', {
                theme: 'snow'
            });
            // ingre.root.innerHTML = `{{ $product->ingredients }}`
            ingre.clipboard.dangerouslyPasteHTML(0, `{!! $product->ingredients !!}`);


            //   var html = quill.root.innerHTML;
            //     console.log("HTML:", html);

            document.getElementById('product-form').addEventListener('submit', function() {
                document.getElementById('description').value = desc.root.innerHTML;;
                document.getElementById('how_to_use').value = how.root.innerHTML;;
                document.getElementById('ingredients').value = ingre.root.innerHTML;;
            });
        });
    </script>
@endsection
