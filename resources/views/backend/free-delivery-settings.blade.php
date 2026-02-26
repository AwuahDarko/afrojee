@extends('backend.layouts.app')

@section('title', 'Free Delivery Settings')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul class="mb-0">
            @foreach ($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="card mb-4">
        <div class="card-header p-0 mt-n4 mx-3 z-index-2 position-relative">
          <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 px-3">
            <h6 class="text-white text-capitalize mb-0">Free Delivery Rules</h6>
          </div>
        </div>
        <div class="card-body px-4">
          <p class="text-muted small mb-4">
            When enabled, orders that meet <strong>all</strong> of the conditions below get free shipping at checkout.
            The minimum is checked against the order subtotal <em>after</em> any first-order discount.
          </p>

          <form action="{{ route('admin.free-delivery.update') }}" method="POST" class="text-start">
            @csrf

            <div class="mb-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="enabled" id="freeDeliveryEnabled"
                  value="1" {{ $settings->enabled ? 'checked' : '' }}>
                <label class="form-check-label" for="freeDeliveryEnabled">
                  <strong>Enable free delivery</strong> — Apply these rules at checkout
                </label>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label" for="min_order_amount">Minimum order amount ({{ app_currency() }}) <span class="text-danger">*</span></label>
              <div class="input-group input-group-outline">
                <input type="number" name="min_order_amount" id="min_order_amount"
                  class="form-control" step="0.01" min="0" required
                  value="{{ old('min_order_amount', $settings->min_order_amount) }}"
                  placeholder="e.g. 70.00">
              </div>
              <small class="text-muted">Orders with discounted subtotal at or above this amount can qualify (in selected countries).</small>
            </div>

            <div class="mb-4">
              <label class="form-label">Countries that qualify for free delivery</label>
              <div class="input-group input-group-outline">
                <select name="country_ids[]" id="country_ids" class="form-control" multiple size="8">
                  @foreach ($countries as $c)
                    <option value="{{ $c->id }}" {{ in_array($c->id, $settings->country_ids ?? [], true) ? 'selected' : '' }}>
                      {{ $c->name }}
                    </option>
                  @endforeach
                </select>
              </div>
              <small class="text-muted">Hold Ctrl/Cmd to select multiple. Only these countries get free delivery when the minimum is met.</small>
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-dark">Save settings</button>
            </div>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h6 class="mb-2">Current behaviour</h6>
          <ul class="mb-0 small text-muted">
            <li>Free delivery is <strong>{{ $settings->enabled ? 'on' : 'off' }}</strong>.</li>
            <li>Minimum order: <strong>{{ app_currency() }} {{ number_format($settings->min_order_amount, 2) }}</strong> (after discounts).</li>
            <li>Eligible countries: <strong>@php $eligibleNames = collect($countries)->whereIn('id', $settings->country_ids ?? [])->pluck('name')->join(', '); @endphp{{ $eligibleNames ?: 'None selected' }}</strong>.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
