@extends('backend.layouts.app')

@section('title', 'Add New Review')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('admin.reviews') }}" class="btn btn-outline-secondary btn-sm me-3">
                            <i class="material-symbols-rounded text-xs">arrow_back</i>&nbsp;Back
                        </a>
                        <div>
                            <h5 class="mb-0">Add New Review</h5>
                            <p class="text-sm mb-0">Create a new customer review</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Customer Information -->
                                <div class="card mb-4">
                                    <div class="card-header pb-0">
                                        <h6>Customer Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group input-group-outline mb-3 @error('name') is-invalid @enderror">
                                                    <label class="form-label">Customer Name *</label>
                                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                                </div>
                                                @error('name')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group input-group-outline mb-3 @error('email') is-invalid @enderror">
                                                    <label class="form-label">Email Address</label>
                                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                                </div>
                                                @error('email')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <div class="col-12">
                                                <div class="input-group input-group-outline mb-3 @error('product_name') is-invalid @enderror">
                                                    <label class="form-label">Product/Service Name</label>
                                                    <input type="text" name="product_name" class="form-control" value="{{ old('product_name') }}">
                                                </div>
                                                @error('product_name')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group input-group-outline mb-3 @error('product_id') is-invalid @enderror">
                                                    <label class="form-label" for="product_id">Product *</label>
                                                    <small class="text-muted d-block mb-1" style="font-size: xx-small;">(Required for product-specific reviews)</small>
                                                    <select id="product_id" name="product_id" class="form-select" required>
                                                        <option value="">Select Product</option>
                                                        @foreach(\App\Models\Product::where('status', 1)->orderBy('name')->get() as $product)
                                                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }} ({{ $product->getPrice() }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('product_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                @error('product_id')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Review Content -->
                                <div class="card mb-4">
                                    <div class="card-header pb-0">
                                        <h6>Review Content</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group input-group-outline mb-3 @error('title') is-invalid @enderror">
                                                    <label class="form-label">Review Title *</label>
                                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                                </div>
                                                @error('title')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Rating *</label>
                                                    <div class="rating-input">
                                                        @for($i = 1; $i <= 5; $i++)
                                                        <label class="rating-star">
                                                            <input type="radio" name="rating" value="{{ $i }}" 
                                                                   {{ old('rating', 5) == $i ? 'checked' : '' }} required>
                                                            <i class="fas fa-star"></i>
                                                        </label>
                                                        @endfor
                                                    </div>
                                                    @error('rating')
                                                    <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group input-group-outline mb-3 @error('review') is-invalid @enderror">
                                                    <label class="form-label">Review Text *</label>
                                                    <textarea name="review" class="form-control" rows="5" required>{{ old('review') }}</textarea>
                                                </div>
                                                @error('review')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Review Image -->
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h6>Review Image</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Upload Image</label>
                                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                                            <small class="text-muted">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
                                            @error('image')
                                            <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div id="image-preview" class="mt-3" style="display: none;">
                                            <img id="preview-img" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Review Settings -->
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h6>Review Settings</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Status *</label>
                                            <select name="status" class="form-select" required>
                                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                            @error('status')
                                            <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" 
                                                   {{ old('is_featured') ? 'checked' : '' }}>
                                            <label class="form-check-label">Mark as Featured</label>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn bg-gradient-primary">
                                                <i class="material-symbols-rounded text-xs">save</i>&nbsp;Create Review
                                            </button>
                                            <a href="{{ route('admin.reviews') }}" class="btn btn-outline-secondary">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Help -->
                                <div class="card mt-4">
                                    <div class="card-header pb-0">
                                        <h6>Tips</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled text-sm">
                                            <li class="mb-2"><i class="material-symbols-rounded text-success text-xs">check_circle</i> Use genuine customer feedback</li>
                                            <li class="mb-2"><i class="material-symbols-rounded text-success text-xs">check_circle</i> Include specific product/service details</li>
                                            <li class="mb-2"><i class="material-symbols-rounded text-success text-xs">check_circle</i> Add customer photos when available</li>
                                            <li class="mb-2"><i class="material-symbols-rounded text-success text-xs">check_circle</i> Feature your best reviews</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.rating-input {
    display: flex;
    gap: 5px;
}

.rating-star {
    cursor: pointer;
    font-size: 1.5rem;
    color: #ddd;
    transition: color 0.2s;
}

.rating-star input {
    display: none;
}

.rating-star:hover,
.rating-star:has(input:checked),
.rating-star:has(input:checked) ~ .rating-star {
    color: #ffc107;
}

.rating-star:hover ~ .rating-star {
    color: #ddd;
}
</style>
@endpush

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

// Rating stars interaction
document.querySelectorAll('.rating-star').forEach((star, index) => {
    star.addEventListener('mouseover', function() {
        highlightStars(index + 1);
    });
});

document.querySelector('.rating-input').addEventListener('mouseleave', function() {
    const checkedInput = document.querySelector('input[name="rating"]:checked');
    if (checkedInput) {
        highlightStars(parseInt(checkedInput.value));
    } else {
        highlightStars(0);
    }
});

function highlightStars(rating) {
    document.querySelectorAll('.rating-star').forEach((star, index) => {
        if (index < rating) {
            star.style.color = '#ffc107';
        } else {
            star.style.color = '#ddd';
        }
    });
}

// Initialize rating display
document.addEventListener('DOMContentLoaded', function() {
    const checkedInput = document.querySelector('input[name="rating"]:checked');
    if (checkedInput) {
        highlightStars(parseInt(checkedInput.value));
    }
});
</script>
@endpush
@endsection
