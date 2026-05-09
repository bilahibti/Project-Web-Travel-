@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal -->

<div  class="card">
    <h5 class="card-header">Hotel</h5> 
    <div class="table-responsive text-nowrap">
        <a href="{{ route('backend.hotel.create') }}">
            <button class="btn rounded-pill btn-primary btn-sm" style="border:none; outline:none; border-radius:12px; padding:6px 14px;">Add Hotel</button>
        </a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Photo</th>
                    <th>Destination</th>
                    <th>Hotel Name</th>
                    <th>Address</th>
                    <th>Price / Night</th>
                    <th>Star Rating</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody class="table-border-bottom-0">
                @foreach ($index as $row)
                <tr>
                    <!-- NUMBER -->
                    <td>{{ $loop->iteration }}</td>
                    <!-- PHOTO -->
                    <td>
                        @if ($row->foto)
                            <img src="{{ asset('storage/hotel/' . $row->foto) }}"
                                width="70"
                                class="rounded">
                        @else
                            <img src="{{ asset('backend/img/avatars/1.png') }}"
                                width="70"
                                class="rounded">
                        @endif
                    </td>

                    <!-- DESTINATION -->
                    <td>
                        @if ($row->destination)
                            {{ $row->destination->destination_name }}
                        @else
                            No Destination
                        @endif
                    </td>

                    <!-- HOTEL NAME -->
                    <td>{{ $row->hotel_name }}</td>
                    <!-- ADDRESS -->
                    <td>{{ $row->address }}</td>
                    <!-- PRICE -->
                    <td>
                        Rp {{ number_format($row->price_per_night, 0, ',', '.') }}
                    </td>

                    <!-- STAR -->
                    <td>
                        {{ $row->star_rating }} Star
                    </td>

                    <!-- STATUS -->
                    <td>
                        @if ($row->status == 'Available')
                            <span class="badge bg-label-success rounded-pill">
                                Available
                            </span>
                        @else
                            <span class="badge bg-label-warning rounded-pill">
                                Full Booked
                            </span>
                        @endif
                    </td>

                    <!-- ACTION -->
                    <td>
                        <div class="dropdown">
                            <button
                                type="button"
                                class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                                data-bs-toggle="dropdown">
                                <i class="icon-base ri ri-more-2-line icon-18px"></i>
                            </button>
                            <div class="dropdown-menu">
                                <!-- EDIT -->
                                <a class="dropdown-item"
                                    href="{{ route('backend.hotel.edit', $row->id) }}">
                                    <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                    Edit
                                </a>

                                <!-- DELETE -->
                                <form method="POST"
                                    action="{{ route('backend.hotel.destroy', $row->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="dropdown-item"
                                        data-konf-delete="{{ $row->hotel_name }}">
                                        <i class="icon-base ri ri-delete-bin-6-line me-1"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- contentAkhir -->
@endsection 