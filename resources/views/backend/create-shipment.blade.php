@extends('backend.layouts.app')

@section('title')
   Shipping Zones
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-gradient-dark shadow-dark border-radius-lg p-4">
                    <h6 class="text-white mb-0">Add Shipping Zone & Rates</h6>
                </div>

                <div class="card-body px-4">
                    <form role="form" class="text-start" action="{{ route('admin.shipment.store') }}" method="POST">
                        @csrf

                         <div class="mb-3 input-group input-group-outline">
                            <select name="country" class="form-control">
                                 <option value="0"> Select shipping country </option>
                                @foreach ($countries as $country)
                                <option value="{{$country->id}}"> {{ $country->name }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 input-group input-group-outline">
                            <label class="form-label">Zone Name</label>
                            <input type="text" name="zone_name" class="form-control" required placeholder="">
                        </div>

                        <div class="mb-3 input-group input-group-outline">
                            <label class="form-label">City / Region</label>
                            <input type="text" name="region" class="form-control" required placeholder="">
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-block">Shipping Rates by Weight (kg)</label>

                            <table class="table table-bordered table-striped" id="ratesTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 40%">Weight From (kg)</th>
                                        <th style="width: 40%">Weight To (kg)</th>
                                        <th style="width: 15%">Rate </th>
                                        <th style="width: 5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group input-group-outline">
                                                <input type="number" step="0.01" name="rates[0][weight_from]" class="form-control" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-outline">
                                                <input type="number" step="0.01" name="rates[0][weight_to]" class="form-control" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-outline">
                                                <input type="number" step="0.01" name="rates[0][rate]" class="form-control" required>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger remove-rate"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="button" class="btn btn-outline-dark btn-sm" id="addRateRow">
                                <i class="fas fa-plus"></i> Add Rate
                            </button>
                        </div>

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
