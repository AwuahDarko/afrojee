@extends('backend.layouts.app')

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
                            <h4>GHS {{ number_format($stats['revenue'] ?? 0, 2) }}</h4>
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
                            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="payment_status" class="form-select">
                            <option value="">All Payments</option>
                            <option value="paid" {{ request('payment_status')=='paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ request('payment_status')=='unpaid' ? 'selected' : '' }}>Unpaid
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date" value="{{ request('date') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
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
                                        (GHS)</th>
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
                                            <h6 class="mb-0 text-sm">{{ $order->customer->name ?? 'N/A' }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $order->customer->email ?? '' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-xs font-weight-bold">{{ number_format($order->total_amount, 2)
                                            }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-sm bg-gradient-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-gradient-secondary">{{ ucfirst($order->status)
                                            }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{
                                            $order->created_at->format('Y-m-d H:i') }}</span>
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

                    </div>
                </div>

                <div class="card-footer">
                    {{ $orders->withQueryString()->links() }}
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
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endforeach

@endsection