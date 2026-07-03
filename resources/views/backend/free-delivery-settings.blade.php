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
            <h6 class="text-white text-capitalize mb-0">Free Delivery</h6>
          </div>
        </div>
        <div class="card-body px-4">
          <p class="text-muted small mb-4">
            When enabled, orders that meet a <strong>rule</strong> below get free shipping. Each rule applies to one country with its own minimum order amount (checked after any first-order discount).
          </p>

          <form action="{{ route('admin.free-delivery.update') }}" method="POST" class="mb-4">
            @csrf
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="enabled" id="freeDeliveryEnabled"
                value="1" {{ $settings->enabled ? 'checked' : '' }}>
              <label class="form-check-label" for="freeDeliveryEnabled">
                <strong>Enable free delivery</strong> — Apply the rules below at checkout
              </label>
            </div>
            <button type="submit" class="btn btn-outline-dark btn-sm">Save</button>
          </form>

          <h6 class="mb-3">Rules (one per country)</h6>
          <div class="table-responsive mb-4">
            <table class="table table-bordered align-items-center mb-0">
              <thead class="bg-light">
                <tr>
                  <th>Country</th>
                  <th>Minimum order ({{ app_currency() }})</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($rules as $rule)
                  <tr>
                    <td>{{ $rule->country->name ?? $rule->country_id }}</td>
                    <td>{{ number_format($rule->min_order_amount, 2) }}</td>
                    <td class="text-end">
                      <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editRuleModal" data-rule-id="{{ $rule->id }}" data-country-id="{{ $rule->country_id }}" data-min="{{ $rule->min_order_amount }}">Edit</button>
                      <form action="{{ route('admin.free-delivery.rules.destroy', $rule) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this rule?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center text-muted">No rules yet. Add one below.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <h6 class="mb-2">Add rule</h6>
          <form action="{{ route('admin.free-delivery.rules.store') }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-4">
              <label class="form-label">Country</label>
              <select name="country_id" class="form-control" required>
                <option value="">Select country</option>
                @foreach ($countries as $c)
                  @if (!in_array($c->id, $usedCountryIds ?? [], true))
                    <option value="{{ $c->id }}" {{ (int) old('country_id') === (int) $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Min. order ({{ app_currency() }})</label>
              <input type="number" name="min_order_amount" class="form-control" step="0.01" min="0" required value="{{ old('min_order_amount', '70.00') }}" placeholder="70.00">
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-dark">Add rule</button>
            </div>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h6 class="mb-2">Current behaviour</h6>
          <ul class="mb-0 small text-muted">
            <li>Free delivery is <strong>{{ $settings->enabled ? 'on' : 'off' }}</strong>.</li>
            <li>
              @if ($rules->isEmpty())
                No rules — no free delivery by country.
              @else
                Rules: @foreach ($rules as $r) <strong>{{ $r->country->name ?? $r->country_id }}</strong>: {{ app_currency() }} {{ number_format($r->min_order_amount, 2) }}@if (!$loop->last), @endif @endforeach.
              @endif
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Edit rule modal --}}
<div class="modal fade" id="editRuleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editRuleForm" method="POST" action="">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Edit rule</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Country</label>
            <select name="country_id" class="form-control" required id="editCountryId">
              @foreach ($countries as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Min. order ({{ app_currency() }})</label>
            <input type="number" name="min_order_amount" class="form-control" step="0.01" min="0" required id="editMinAmount" placeholder="70.00">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-dark">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
document.getElementById('editRuleModal').addEventListener('show.bs.modal', function (e) {
  var btn = e.relatedTarget;
  var id = btn.getAttribute('data-rule-id');
  var countryId = btn.getAttribute('data-country-id');
  var min = btn.getAttribute('data-min');
  var form = document.getElementById('editRuleForm');
  form.action = '{{ url("admin/free-delivery/rules") }}/' + id;
  document.getElementById('editCountryId').value = countryId || '';
  document.getElementById('editMinAmount').value = min || '';
});
</script>
@endsection
