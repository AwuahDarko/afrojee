@extends('backend.layouts.app')

@section('title', 'Edit Review')

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
                            <h5 class="mb-0">Edit Review</h5>
                            <p class="text-sm mb-0">Update review information</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reviews.update', $review) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
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
                                                <div class="input-group input-group-outline mb-3 is-filled @error('name') is-invalid @enderror">
                                                    <label class="form-label">Customer Name *</label>
                                                    <input type="text" name="name" class="form-control" value="{{ old('name', $review->name) }}" required>
                                                </div>
                                                @error('name')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group input-group-outline mb-3 {{ $review->email ? 'is-filled' : '' }} @error('email') is-invalid @enderror">
                                                    <label class="form-label">Email Address</label>
                                                    <input type="email" name="email" class="form-control" value="{{ old('email', $review->email) }}">
                                                </div>
                                                @error('email')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group input-group-outline mb-3 @error('product_id') is-invalid @enderror">
                                                    <label class="form-label">Product * <small class="text-muted">(Required for product-specific reviews)</small></label>
                                                    <select name="product_id" class="form-select" required>
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" {{ old('product_id', $review->product_id) == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }} ({{ $product->getPrice() }})
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                                                <div class="input-group input-group-outline mb-3 is-filled @error('title') is-invalid @enderror">
                                                    <label class="form-label">Review Title *</label>
                                                    <input type="text" name="title" class="form-control" value="{{ old('title', $review->title) }}" required>
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
                                                                   {{ old('rating', $review->rating) == $i ? 'checked' : '' }} required>
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
                                                <div class="input-group input-group-outline mb-3 is-filled @error('review') is-invalid @enderror">
                                                    <label class="form-label">Review Text *</label>
                                                    <textarea name="review" class="form-control" rows="5" required>{{ old('review', $review->review) }}</textarea>
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
                                        @if($review->image)
                                        <div class="mb-3">
                                            <label class="form-label">Current Image</label>
                                            <div class="current-image">
                                                <img src="{{ $review->image_url }}" alt="Current review image" class="img-fluid rounded" style="max-height: 200px;">
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ $review->image ? 'Replace Image' : 'Upload Image' }}</label>
                                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                                            <small class="text-muted">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
                                            @error('image')
                                            <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div id="image-preview" class="mt-3" style="display: none;">
                                            <label class="form-label">New Image Preview</label>
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
                                                <option value="pending" {{ old('status', $review->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ old('status', $review->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ old('status', $review->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                            @error('status')
                                            <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" 
                                                   {{ old('is_featured', $review->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label">Mark as Featured</label>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn bg-gradient-primary">
                                                <i class="material-symbols-rounded text-xs">save</i>&nbsp;Update Review
                                            </button>
                                            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-outline-info">
                                                <i class="material-symbols-rounded text-xs">visibility</i>&nbsp;View Review
                                            </a>
                                            <a href="{{ route('admin.reviews') }}" class="btn btn-outline-secondary">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Review Info -->
                                <div class="card mt-4">
                                    <div class="card-header pb-0">
                                        <h6>Review Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="info-item mb-2">
                                            <span class="text-sm text-secondary">Created:</span>
                                            <span class="text-sm">{{ $review->created_at->format('M d, Y \a\t H:i') }}</span>
                                        </div>
                                        <div class="info-item mb-2">
                                            <span class="text-sm text-secondary">Updated:</span>
                                            <span class="text-sm">{{ $review->updated_at->format('M d, Y \a\t H:i') }}</span>
                                        </div>
                                        @if($review->approved_at)
                                        <div class="info-item mb-2">
                                            <span class="text-sm text-secondary">Approved:</span>
                                            <span class="text-sm">{{ $review->approved_at->format('M d, Y \a\t H:i') }}</span>
                                        </div>
                                        @endif
                                        @if($review->approvedBy)
                                        <div class="info-item mb-2">
                                            <span class="text-sm text-secondary">Approved by:</span>
                                            <span class="text-sm">{{ $review->approvedBy->name }}</span>
                                        </div>
                                        @endif
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

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
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