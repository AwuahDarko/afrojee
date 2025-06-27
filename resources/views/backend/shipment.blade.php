@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header p-0 mt-n4 mx-3 z-index-2 position-relative">
          <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 px-3">
            <h6 class="text-white text-capitalize">Shipping Zones & Rates</h6>
          </div>
        </div>
        <div class="card-body px-3">
          <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.shipment.create') }}" class="btn btn-dark">Add Shipping Zone</a>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered align-items-center mb-0">
              <thead class="bg-light">
                <tr>
                  <th>Country</th>
                  <th>Zone Name</th>
                  <th>Region</th>
                  <th>Weight From (kg)</th>
                  <th>Weight To (kg)</th>
                  <th>Rate (GHS)</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($zones as $zone)
                  @forelse ($zone->rates as $rate)
                    <tr>
                      <td>{{ $zone->country->name }}</td>
                      <td>{{ $zone->zone_name }}</td>
                      <td>{{ $zone->region }}</td>
                      <td>{{ $rate->weight_from }}</td>
                      <td>{{ $rate->weight_to }}</td>
                      <td>{{ number_format($rate->rate, 2) }}</td>
                      <td class="text-end">
                        <a href="{{ route('admin.shipment.edit', $zone->id) }}" class="btn btn-sm btn-info">Edit Zone</a>
                        <form action="{{ route('admin.shipment.destroy', $zone->id) }}" method="POST" style="display:inline-block">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure? This will delete the entire zone and all its rates.')">Delete Zone</button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td>{{ $zone->zone_name }}</td>
                      <td>{{ $zone->region }}</td>
                      <td colspan="3" class="text-center text-muted">No rates defined</td>
                      <td class="text-end">
                        <a href="{{ route('admin.shipment.edit', $zone->id) }}" class="btn btn-sm btn-info">Add Rates</a>
                        <form action="{{ route('admin.shipment.destroy', $zone->id) }}" method="POST" style="display:inline-block">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete Zone</button>
                        </form>
                      </td>
                    </tr>
                  @endforelse
                @empty
                  <tr>
                    <td colspan="6" class="text-center">No shipping zones available.</td>
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