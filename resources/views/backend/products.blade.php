@extends('backend.layouts.app')

@section('title')
    Products
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 afrojee-spaceout afrojee-row">
                        <h6 class="text-white text-capitalize ps-3">All Products</h6>
                        <a class="text-white pe-3" href="{{ route('admin.products.new') }}">New </a>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Weight (Kg)</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Price</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Quantity</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Created at</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="{{ $product->image }}"
                                                        class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"> {{ $product->name }} </h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $product->category->name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $product->weight }}</p>
                                            {{-- <p class="text-xs text-secondary mb-0">Organization</p> --}}
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-secondary text-xs font-weight-bold">
                                               {{app_currency()}} {{ number_format($product->price, 2) }} </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold"> {{ $product->quantity }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($product->status === 1)
                                                <span class="badge badge-sm bg-gradient-success">Active</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                            @endif
                                        </td>

                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $product->created_at }} </span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('admin.products.view', ['id' => $product->id]) }}"
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Edit">
                                                Edit
                                            </a>
                                            <br>
                                            @if ($product->status === 1)
                                                <a href="{{ route('admin.products.deactivate', ['id' => $product->id]) }}"
                                                    class="text-secondary font-weight-bold text-xs text-danger"
                                                    data-toggle="tooltip" data-original-title="DeActivate">
                                                    Deactivate
                                                </a>
                                            @else
                                                <a href="{{ route('admin.products.activate', ['id' => $product->id]) }}"
                                                    class="text-secondary font-weight-bold text-xs text-success"
                                                    data-toggle="tooltip" data-original-title="Activate">
                                                    Activate
                                                </a>
                                            @endif
                                            <br>
                                            @if ($product->featured === 1)
                                                <a href="{{ route('admin.products.remove', ['id' => $product->id]) }}"
                                                    class="text-secondary font-weight-bold text-xs text-danger"
                                                    data-toggle="tooltip" data-original-title="Remove">
                                                    Remove
                                                </a>
                                            @else
                                                <a href="{{ route('admin.products.feature', ['id' => $product->id]) }}"
                                                    class="text-secondary font-weight-bold text-xs text-success"
                                                    data-toggle="tooltip" data-original-title="Feature">
                                                    Feature
                                                </a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>

                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
