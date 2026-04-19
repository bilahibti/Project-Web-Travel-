@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal -->

<div  class="card">
    <h5 class="card-header">Hotel</h5> 
    <div class="table-responsive text-nowrap">
        <a href="{{ route('backend.hotel.create') }}">
            <button class="btn rounded-pill btn-primary btn-sm" style="border:none; outline:none; border-radius:12px; padding:6px 14px;">Tambah</button>
        </a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th> 
                    <th>Nama Hotel</th> 
                    <th>Alamat</th> 
                    <th>Harga Per Malam</th> 
                    <th>Rating</th>
                    <th>Status</th> 
                    <th>Aksi</th>
                </tr>
            </thead>

            @foreach ($index as $row)
            <tbody class="table-border-bottom-0">
                <tr>
                    <td> {{ $loop->iteration }} </td> 
                    <td> {{$row->nama_hotel}} </td> 
                    <td> {{$row->alamat}} </td> 
                    <td> {{$row->harga_per_malam}} </td>
                    <td> {{$row->rating}} </td>  
                    <td> @if ($row->status == 'Tersedia')
                            <span class="badge bg-label-success rounded-pill">Tersedia</span>
                        @else
                            <span class="badge bg-label-warning rounded-pill">Full Booked</span>
                        @endif 
                    </td>
                    <td>
                        <div class="dropdown">
                            <button
                                type="button"
                                class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                                data-bs-toggle="dropdown">
                                <i class="icon-base ri ri-more-2-line icon-18px"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('backend.hotel.edit', $row->id) }}">
                                    <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                    Edit
                                </a>
                                <form method="POST"
                                    action="{{ route('backend.hotel.destroy', $row->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="dropdown-item"
                                            data-konf-delete="{{ $row->nama_hotel }}">
                                        <i class="icon-base ri ri-delete-bin-6-line me-1"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
</div>

<!-- contentAkhir -->
@endsection 