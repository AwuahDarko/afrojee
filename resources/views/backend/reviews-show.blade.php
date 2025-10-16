{{-- reviews-show.blade.php --}}
@extends('backend.layouts.app')

@section('title', 'Review Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('admin.reviews') }}" class="btn btn-outline-secondary btn-sm me-3">
                                <i class="material-symbols-rounded text-xs">arrow_back</i>&nbsp;Back to Reviews
                            </a>
                            <div>
                                <h5 class="mb-0">Review Details</h5>
                                <p class="text-sm mb-0">View complete review information</p>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="material-symbols-rounded text-xs">more_vert</i>&nbsp;Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.reviews.edit', $review) }}">
                                    <i class="material-symbols-rounded text-xs me-2">edit</i>Edit Review
                                </a></li>
                                @if($review->status === 'pending')
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="quickAction({{ $review->id }}, 'approve')">
                                    <i class="material-symbols-rounded text-xs me-2">check_circle</i>Approve
                                </a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="quickAction({{ $review->id }}, 'reject')">
                                    <i class="material-symbols-rounded text-xs me-2">cancel</i>Reject
                                </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="material-symbols-rounded text-xs me-2">delete</i>Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Review Content -->
                        <div class="col-md-8">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-0">{{ $review->title }}</h6>
                                            <div class="d-flex align-items-center mt-2">
                                                {!! $review->rating_stars !!}
                                                <span class="ms-2 text-sm">({{ $review->rating }}/5)</span>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            {!! $review->status_badge !!}
                                            @if($review->is_featured)
                                                <span class="badge bg-gradient-warning ms-2">
                                                    <i class="material-symbols-rounded text-xs">star</i> Featured
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="review-content">
                                        <p class="text-sm">{{ $review->review }}</p>
                                    </div>
                                    
                                    @if($review->image)
                                        <div class="mt-3">
                                            <img src="{{ $review->image_url }}" alt="Review Image" class="img-fluid rounded" style="max-height: 300px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Review Information -->
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <h6 class="mb-0">Review Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="info-item mb-3">
                                        <label class="text-sm text-secondary">Customer Name</label>
                                        <p class="text-sm font-weight-bold mb-0">{{ $review->name }}</p>
                                    </div>

                                    @if($review->email)
                                    <div class="info-item mb-3">
                                        <label class="text-sm text-secondary">Email</label>
                                        <p class="text-sm mb-0">{{ $review->email }}</p>
                                    </div>
                                    @endif

                                    @if($review->product)
                                    <div class="info-item mb-3">
                                        <label class="text-sm text-secondary">Product</label>
                                        <p class="text-sm mb-0">{{ $review->product->name }}</p>
                                    </div>
                                    @endif

                                    <div class="info-item mb-3">
                                        <label class="text-sm text-secondary">Submitted Date</label>
                                        <p class="text-sm mb-0">{{ $review->created_at->format('F j, Y \a\t g:i A') }}</p>
                                    </div>

                                    @if($review->approved_at)
                                    <div class="info-item mb-3">
                                        <label class="text-sm text-secondary">Approved Date</label>
                                        <p class="text-sm mb-0">{{ $review->approved_at->format('F j, Y \a\t g:i A') }}</p>
                                    </div>
                                    @endif

                                    @if($review->approvedBy)
                                    <div class="info-item mb-3">
                                        <label class="text-sm text-secondary">Approved By</label>
                                        <p class="text-sm mb-0">{{ $review->approvedBy->name }}</p>
                                    </div>
                                    @endif

                                    <div class="info-item mb-3">
                                        <label class="text-sm text-secondary">Last Updated</label>
                                        <p class="text-sm mb-0">{{ $review->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Quick Actions
function quickAction(reviewId, action) {
    const url = `{{ url('admin/reviews') }}/${reviewId}/${action}`;
    
    fetch(url, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Refresh page to show updated status
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    })
    .catch(error => {
        showNotification('An error occurred. Please try again.', 'error');
    });
}

// Notification function
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}
</script>
@endpush
@endsection