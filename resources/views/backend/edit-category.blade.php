@extends('backend.layouts.app')

@section('title')
   Edit Category
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
                        <p>Create New Product Categrory</p>
                        <form role="form" class="text-start" method="POST" action="{{ route('admin.category.edit') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{$category->id}}">

                            <div class="input-group input-group-outline my-3">
                                <input type="text" class="form-control" name="name" required
                                    placeholder="Name of product category" value="{{ $category->name }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                          
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
