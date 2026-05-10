@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal --> 
 
<div class="container-fluid py-4">

    <h4 class="mb-4">Dashboard Travel Admin</h4>

    {{-- FILTER --}}
    <div class="card mb-4">
        <div class="card-body d-flex gap-3">
            <input type="text" class="form-control" placeholder="Search data...">
            <select class="form-control">
                <option>All Location</option>
            </select>
            <select class="form-control">
                <option>All Status</option>
            </select>
        </div>
    </div>

    {{-- TAB --}}
    <ul class="nav nav-tabs mb-3" id="tabMenu">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#travel">Travel Packages</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#hotel">Hotels</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#flight">Flights</a>
        </li>
    </ul>

    <div class="tab-content">

        {{-- ================= TRAVEL PACKAGES ================= --}}
        <div class="tab-pane fade show active" id="travel">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Package Name</th>
                                <th>Destination</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paket as $item)
                            @php
                                $percent = ($item->booked / $item->quota) * 100;
                            @endphp
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->destination }}</td>
                                <td>
                                    <small>{{ $item->booked }} / {{ $item->quota }}</small>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary"
                                             style="width: {{ $percent }}%">
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->price) }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ================= HOTEL ================= --}}
        <div class="tab-pane fade" id="hotel">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Hotel Name</th>
                                <th>Address</th>
                                <th>Room Type</th>
                                <th>Price / Night</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hotel as $item)
                            @php
                                $percent = ($item->booked / $item->quota) * 100;
                            @endphp
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    <small>{{ $item->booked }} / {{ $item->quota }}</small>
                                    <div class="progress">
                                        <div class="progress-bar bg-success"
                                             style="width: {{ $percent }}%">
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->price) }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ================= FLIGHT ================= --}}
        <div class="tab-pane fade" id="flight">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Airline</th>
                                <th>Route</th>
                                <th>Seats Booked</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transportation as $item)
                            @php
                                $percent = ($item->booked / $item->quota) * 100;
                            @endphp
                            <tr>
                                <td>{{ $item->airline }}</td>
                                <td>{{ $item->from }} → {{ $item->to }}</td>
                                <td>
                                    <small>{{ $item->booked }} / {{ $item->quota }}</small>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning"
                                             style="width: {{ $percent }}%">
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->price) }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- contentAkhir --> 
@endsection