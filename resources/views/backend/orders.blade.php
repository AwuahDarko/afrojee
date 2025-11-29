@extends('backend.layouts.app')
@section('title', 'Orders Management')

@section('content')

    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-0 mt-n4 mx-3 z-index-2 position-relative">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 px-3">
                            <h6 class="text-white text-capitalize">Orders Overview</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <h6>Total Orders</h6>
                                <h4>{{ $stats['total'] ?? '0' }}</h4>
                            </div>
                            <div class="col-md-3">
                                <h6>Pending</h6>
                                <h4>{{ $stats['pending'] ?? '0' }}</h4>
                            </div>
                            <div class="col-md-3">
                                <h6>Completed</h6>
                                <h4>{{ $stats['completed'] ?? '0' }}</h4>
                            </div>
                            <div class="col-md-3">
                                <h6>Total Revenue</h6>
                                <h4> {{ number_format($stats['revenue'] ?? 0, 2) }} {{app_currency()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <form method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                placeholder="Order ID or Customer">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="payment_status" class="form-select">
                                <option value="">All Payments</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid
                                </option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <div class="row g-2">
                                <div class="col-md-12 mb-2">
                                    <select id="quickDateFilter" class="form-select form-select-sm">
                                        <option value="">Quick Date Filters</option>
                                        <option value="last_month">Last Month</option>
                                        <option value="1_week">1 Week Ago</option>
                                        <option value="2_weeks">2 Weeks Ago</option>
                                        <option value="custom">Custom Range</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="dateFromWrapper" style="display: none;">
                                    <label class="form-label small mb-0">From</label>
                                    <input type="date" name="date_from" id="dateFrom" value="{{ request('date_from') }}" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-6" id="dateToWrapper" style="display: none;">
                                    <label class="form-label small mb-0">To</label>
                                    <input type="date" name="date_to" id="dateTo" value="{{ request('date_to') }}" class="form-control form-control-sm">
                                </div>
                                <!-- Legacy single date field (hidden, kept for compatibility) -->
                                <input type="hidden" name="date" value="{{ request('date') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-dark w-100" type="submit">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 mt-n4 mx-3 z-index-2 position-relative">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 px-3">
                            <h6 class="text-white text-capitalize">Orders Table</h6>
                        </div>
                    </div>

                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Order</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Customer</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Amount
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Payment
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Date</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $order->order_number }}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $order->shippingAddress->first_name ?? 'N/A' }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $order->shippingAddress->last_name ?? '' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-xs font-weight-bold">   {{ number_format($order->total_amount, 2) }} {{app_currency()}}</span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge badge-sm bg-gradient-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge badge-sm bg-gradient-secondary">{{ ucfirst($order->status) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                                            </td>
                                            <td class="align-middle text-end">
                                                <div class="dropdown">
                                                    <a class="text-secondary font-weight-bold text-xs dropdown-toggle"
                                                        data-bs-toggle="dropdown" href="#" role="button">
                                                        Actions
                                                    </a>
                                                    <ul class="dropdown-menu text-center">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.orders.view', $order->id) }}">View</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;" class="btn btn-sm btn-dark mb-0"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#orderModal{{ $order->id }}">
                                                                Update
                                                            </a>
                                                            <!-- <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateOrderModal{{ $order->id }}">Update Status</a> -->
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">No orders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div>
                                {{ $orders->links() }}
                            </div>
                        </div>



                    </div>


                </div>
            </div>
        </div>
    </div>
    @foreach ($orders as $order)
        <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form method="POST" action="{{ route('admin.orders.update') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Order #{{ $order->order_number }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Order Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                        Processing
                                    </option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
                                </select>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="notify_user"
                                    id="notifyUser{{ $order->id }}" value="1">
                                <label class="form-check-label" for="notifyUser{{ $order->id }}">
                                    Notify customer by email
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-dark">Save Changes</button>
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quickDateFilter = document.getElementById('quickDateFilter');
    const dateFromWrapper = document.getElementById('dateFromWrapper');
    const dateToWrapper = document.getElementById('dateToWrapper');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    
    // Show date inputs if custom dates are already set
    if (dateFrom.value || dateTo.value) {
        dateFromWrapper.style.display = 'block';
        dateToWrapper.style.display = 'block';
        quickDateFilter.value = 'custom';
    }
    
    quickDateFilter.addEventListener('change', function() {
        const today = new Date();
        let fromDate = '';
        let toDate = '';
        
        // Clear previous values
        dateFrom.value = '';
        dateTo.value = '';
        dateFromWrapper.style.display = 'none';
        dateToWrapper.style.display = 'none';
        
        switch(this.value) {
            case 'last_month':
                // First day of last month
                const firstDayLastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                // Last day of last month
                const lastDayLastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
                fromDate = formatDate(firstDayLastMonth);
                toDate = formatDate(lastDayLastMonth);
                dateFrom.value = fromDate;
                dateTo.value = toDate;
                dateFromWrapper.style.display = 'block';
                dateToWrapper.style.display = 'block';
                break;
                
            case '1_week':
                // 1 week ago (7 days)
                const oneWeekAgo = new Date(today);
                oneWeekAgo.setDate(today.getDate() - 7);
                fromDate = formatDate(oneWeekAgo);
                toDate = formatDate(today);
                dateFrom.value = fromDate;
                dateTo.value = toDate;
                dateFromWrapper.style.display = 'block';
                dateToWrapper.style.display = 'block';
                break;
                
            case '2_weeks':
                // 2 weeks ago (14 days)
                const twoWeeksAgo = new Date(today);
                twoWeeksAgo.setDate(today.getDate() - 14);
                fromDate = formatDate(twoWeeksAgo);
                toDate = formatDate(today);
                dateFrom.value = fromDate;
                dateTo.value = toDate;
                dateFromWrapper.style.display = 'block';
                dateToWrapper.style.display = 'block';
                break;
                
            case 'custom':
                // Show date inputs for custom range
                dateFromWrapper.style.display = 'block';
                dateToWrapper.style.display = 'block';
                break;
                
            default:
                // Clear everything
                dateFromWrapper.style.display = 'none';
                dateToWrapper.style.display = 'none';
        }
    });
    
    // Show custom inputs when user manually changes dates
    dateFrom.addEventListener('change', function() {
        if (this.value && quickDateFilter.value !== 'custom') {
            quickDateFilter.value = 'custom';
            dateFromWrapper.style.display = 'block';
            dateToWrapper.style.display = 'block';
        }
    });
    
    dateTo.addEventListener('change', function() {
        if (this.value && quickDateFilter.value !== 'custom') {
            quickDateFilter.value = 'custom';
            dateFromWrapper.style.display = 'block';
            dateToWrapper.style.display = 'block';
        }
    });
    
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
});
</script>
@endsection
