@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-gradient-dark shadow-dark border-radius-lg p-4">
                    <h6 class="text-white mb-0">Add Shipping Zone & Rates</h6>
                </div>

                <div class="card-body px-4">
                    <form action="{{ route('admin.shipment.store') }}" method="POST">
                        @csrf

                        <!-- Zone Name -->
                        <div class="mb-3">
                            <label class="form-label">Zone Name</label>
                            <input type="text" name="zone_name" class="form-control" required placeholder="e.g. Greater Accra">
                        </div>

                        <!-- City/Region -->
                        <div class="mb-3">
                            <label class="form-label">City / Region</label>
                            <input type="text" name="region" class="form-control" required placeholder="e.g. Accra">
                        </div>

                        <!-- Shipping Rates Table -->
                        <div class="mb-4">
                            <label class="form-label d-block">Shipping Rates by Weight (kg)</label>

                            <table class="table table-bordered table-striped" id="ratesTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 40%">Weight From (kg)</th>
                                        <th style="width: 40%">Weight To (kg)</th>
                                        <th style="width: 15%">Rate (GHS)</th>
                                        <th style="width: 5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="number" step="0.01" name="rates[0][weight_from]" class="form-control" required></td>
                                        <td><input type="number" step="0.01" name="rates[0][weight_to]" class="form-control" required></td>
                                        <td><input type="number" step="0.01" name="rates[0][rate]" class="form-control" required></td>
                                        <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-rate"><i class="fas fa-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="button" class="btn btn-outline-dark btn-sm" id="addRateRow">
                                <i class="fas fa-plus"></i> Add Rate
                            </button>
                        </div>

                        <!-- Submit -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-dark">Save Zone & Rates</button>
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
    let rateIndex = 1;

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
