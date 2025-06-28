<option value="0">Select Region</option>
@foreach ($zones as $zone)
<option value="{{$zone->id}}"> {{$zone->zone_name}} </option>
@endforeach