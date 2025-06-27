@extends('backend.layouts.app')

@section('title', 'Reviews Management')

@section('content')
<div class="container-fluid py-4">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-sm-6">
            <div class="card">
                <div class="card-header p-2 ps-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Total Reviews</p>
                            <h4 class="mb-0">{{ number_format($stats['total']) }}</h4>
                        </div>
                        <div class="icon icon-md icon-shape bg-gradient-primary shadow-primary text-center border-radius-lg">
                            <i class="material-symbols-rounded opacity-10">reviews</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-6">
            <div class="card">
                <div class="card-header p-2 ps-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Pending</p>
                            <h4 class="mb-0">{{ number_format($stats['pending']) }}</h4>
                        </div>
                        <div class="icon icon-md icon-shape bg-gradient-warning shadow-warning text-center border-radius-lg">
                            <i class="material-symbols-rounded opacity-10">pending</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-6">
            <div class="card">
                <div class="card-header p-2 ps-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Approved</p>
                            <h4 class="mb-0">{{ number_format($stats['approved']) }}</h4>
                        </div>
                        <div class="icon icon-md icon-shape bg-gradient-success shadow-success text-center border-radius-lg">
                            <i class="material-symbols-rounded opacity-10">check_circle</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-6">
            <div class="card">
                <div class="card-header p-2 ps-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Featured</p>
                            <h4 class="mb-0">{{ number_format($stats['featured']) }}</h4>
                        </div>
                        <div class="icon icon-md icon-shape bg-gradient-info shadow-info text-center border-radius-lg">
                            <i class="material-symbols-rounded opacity-10">star</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-6">
            <div class="card">
                <div class="card-header p-2 ps-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Avg Rating</p>
                            <h4 class="mb-0">{{ number_format($stats['average_rating'], 1) }}</h4>
                        </div>
                        <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark text-center border-radius-lg">
                            <i class="material-symbols-rounded opacity-10">grade</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-lg-flex">
                        <div>
                            <h5 class="mb-0">All Reviews</h5>
                            <p class="text-sm mb-0">Manage customer reviews and testimonials</p>
                        </div>
                        <div class="ms-auto my-auto mt-lg-0 mt-4">
                            <div class="ms-auto my-auto">
                                <a href="{{ route('admin.reviews.create') }}" class="btn bg-gradient-primary btn-sm mb-0">
                                    <i class="material-symbols-rounded text-xs">add</i>&nbsp;&nbsp;Add Review
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="card-header pb-0">
                    <form method="GET" action="{{ route('admin.reviews') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Search...</label>
                                    <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="rating" class="form-select">
                                    <option value="">All Ratings</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Stars</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="featured" class="form-select">
                                    <option value="">All Reviews</option>
                                    <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured</option>
                                    <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn bg-gradient-info btn-sm">Filter</button>
                                <a href="{{ route('admin.reviews') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body px-0 pb-0">
                    <form id="bulk-action-form" method="POST" action="{{ route('admin.reviews.bulk-action') }}">
                        @csrf
                        
                        <!-- Bulk Actions -->
                        <div class="row px-4 mb-3">
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <select name="action" class="form-select form-select-sm" style="width: auto;">
                                        <option value="">Bulk Actions</option>
                                        <option value="approve">Approve</option>
                                        <option value="reject">Reject</option>
                                        <option value="feature">Mark as Featured</option>
                                        <option value="unfeature">Remove from Featured</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary ms-2">Apply</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-flush" id="reviews-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th>Review</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Featured</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reviews as $review)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="reviews[]" value="{{ $review->id }}" class="review-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @if($review->image)
                                                <img src="{{ $review->image_url }}" class="avatar avatar-sm rounded-circle me-2" alt="Review Image">
                                                @endif
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $review->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ Str::limit($review->title, 50) }}</p>
                                                    @if($review->product_name)
                                                    <span class="badge badge-sm bg-gradient-info">{{ $review->product_name }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {!! $review->rating_stars !!}
                                                <span class="ms-2 text-sm">({{ $review->rating }})</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span id="status-{{ $review->id }}">
                                                {!! $review->status_badge !!}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" 
                                                       onclick="toggleFeatured({{ $review->id }})"
                                                       {{ $review->is_featured ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-xs text-secondary">{{ $review->created_at->format('M d, Y') }}</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown">
                                                    <i class="material-symbols-rounded">more_vert</i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('admin.reviews.show', $review) }}">View</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('admin.reviews.edit', $review) }}">Edit</a></li>
                                                    @if($review->status === 'pending')
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="quickAction({{ $review->id }}, 'approve')">Approve</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="quickAction({{ $review->id }}, 'reject')">Reject</a></li>
                                                    @endif
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" 
                                                              onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="material-symbols-rounded opacity-5" style="font-size: 3rem;">reviews</i>
                                                <h6 class="text-muted">No reviews found</h6>
                                                <p class="text-sm text-muted">Start by adding your first review.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>

                    @if($reviews->hasPages())
                    <div class="border-top py-3 px-3 d-flex align-items-center">
                        {{ $reviews->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

