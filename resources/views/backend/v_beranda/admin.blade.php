@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal --> 
 
<div class="container-fluid py-4">

    <h4 class="mb-4">Dashboard Travel Admin</h4>

    {{-- FILTER --}}
    <div class="card mb-4">
        <div class="card-body d-flex gap-3">
            <input type="text" class="form-control" placeholder="Cari data...">
            <select class="form-control">
                <option>Semua Lokasi</option>
            </select>
            <select class="form-control">
                <option>Semua Status</option>
            </select>
        </div>
    </div>

    {{-- TAB --}}
    <ul class="nav nav-tabs mb-3" id="tabMenu">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#travel">Paket Travel</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#hotel">Hotel</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#flight">Penerbangan</a>
        </li>
    </ul>

    <div class="tab-content">

        {{-- ================= PAKET TRAVEL ================= --}}
        <div class="tab-pane fade show active" id="travel">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Paket</th>
                                <th>Lokasi</th>
                                <th>Slot</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paket as $item)
                            @php
                                $percent = ($item->booked / $item->quota) * 100;
                            @endphp
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->location }}</td>
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
                                <th>Nama Hotel</th>
                                <th>Lokasi</th>
                                <th>Kamar Terisi</th>
                                <th>Harga / Malam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hotel as $item)
                            @php
                                $percent = ($item->booked / $item->quota) * 100;
                            @endphp
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->location }}</td>
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

        {{-- ================= PENERBANGAN ================= --}}
        <div class="tab-pane fade" id="flight">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Maskapai</th>
                                <th>Rute</th>
                                <th>Kursi Terisi</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transportasi as $item)
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