@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header bg-gradient-dark shadow-dark border-radius-lg p-4">
                        <h6 class="text-white mb-0">Edit Shipping Zone - {{ $zone->zone_name }}</h6>
                    </div>

                    <div class="card-body px-4">
                        <form action="{{ route('admin.shipment.update', $zone->id) }}" method="POST">
                            @csrf
                            @method('POST')

                            <!-- Zone Name -->
                            <div class="mb-3">
                                <label class="form-label">Zone Name</label>
                                <input type="text" name="zone_name" value="{{ $zone->zone_name }}" class="form-control"
                                    required>
                            </div>

                            <!-- City/Region -->
                            <div class="mb-3">
                                <label class="form-label">City / Region</label>
                                <input type="text" name="region" value="{{ $zone->region }}" class="form-control" required>
                            </div>

                            <!-- Shipping Rates Table -->
                            <div class="mb-4">
                                <label class="form-label d-block">Shipping Rates by Weight (kg)</label>

                                <table class="table table-bordered table-striped" id="ratesTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Weight From (kg)</th>
                                            <th>Weight To (kg)</th>
                                            <th>Rate (GHS)</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($zone->rates as $i => $rate)
                                            <tr>
                                                <td><input type="number" step="0.01" name="rates[{{ $i }}][weight_from]"
                                                        value="{{ $rate->weight_from }}" class="form-control" required></td>
                                                <td><input type="number" step="0.01" name="rates[{{ $i }}][weight_to]"
                                                        value="{{ $rate->weight_to }}" class="form-control" required></td>
                                                <td><input type="number" step="0.01" name="rates[{{ $i }}][rate]"
                                                        value="{{ $rate->rate }}" class="form-control" required></td>
                                                <td class="text-center">
                                                    <input type="hidden" name="rates[{{ $i }}][id]" value="{{ $rate->id }}">
                                                    <button type="button" class="btn btn-sm btn-danger remove-rate">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <button type="button" class="btn btn-outline-dark btn-sm" id="addRateRow">
                                    <i class="fas fa-plus"></i> Add Rate
                                </button>
                            </div>

                            <!-- Submit -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-dark">Update Zone & Rates</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let rateIndex = {{ count($zone->rates) }};

        document.getElementById('addRateRow').addEventListener('click', function () {
            const tableBody = document.querySelector('#ratesTable tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="number" step="0.01" name="rates[${rateIndex}][weight_from]" class="form-control" required></td>
                <td><input type="number" step="0.01" name="rates[${rateIndex}][weight_to]" class="form-control" required></td>
                <td><input type="number" step="0.01" name="rates[${rateIndex}][rate]" class="form-control" required></td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-rate"><i class="fas fa-trash"></i></button></td>
            `;
            tableBody.appendChild(newRow);
            rateIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-rate')) {
                e.target.closest('tr').remove();
            }
        });
    </script>
@endpush
