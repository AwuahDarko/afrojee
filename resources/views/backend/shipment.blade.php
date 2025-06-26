@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header p-0 mt-n4 mx-3 z-index-2 position-relative">
          <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 px-3">
            <h6 class="text-white text-capitalize">Shipping Zones</h6>
          </div>
        </div>
        <div class="card-body px-3">
          <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.shipment.create') }}" class="btn btn-dark">Add Shipping Rate</a>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered align-items-center mb-0">
              <thead class="bg-light">
                <tr>
                  <th>Zone</th>
                  <th>Min Weight (kg)</th>
                  <th>Max Weight (kg)</th>
                  <th>Rate (GHS)</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($rates as $rate)
                  <tr>
                    <td>{{ $rate->zone->name }}</td>
                    <td>{{ $rate->min_weight }}</td>
                    <td>{{ $rate->max_weight }}</td>
                    <td>{{ number_format($rate->rate, 2) }}</td>
                    <td class="text-end">
                      <a href="{{ route('admin.shipment.edit', $rate->id) }}" class="btn btn-sm btn-info">Edit</a>
                      <form action="{{ route('admin.shipment.destroy', $rate->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center">No shipping rates available.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
