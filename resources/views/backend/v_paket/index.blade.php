@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal -->

<div  class="card">
    <h5 class="card-header">Paket</h5> 
    <div class="table-responsive text-nowrap">
        <a href="{{ route('backend.paket.create') }}">
            <button class="btn rounded-pill btn-primary btn-sm" style="border:none; outline:none; border-radius:12px; padding:6px 14px;">Tambah</button>
        </a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th> 
                    <th>Nama Paket</th>
                    <th>Destinasi</th> 
                    <th>Hotel</th>
                    <th>Transportasi</th>
                    <th>Durasi</th>
                    <th>Harga</th> 
                    <th>Status</th> 
                    <th>Aksi</th>
                </tr>
            </thead>

            @foreach ($index as $row)
            <tbody class="table-border-bottom-0">
                <tr>
                    <td> {{ $loop->iteration }} </td> 
                    <td> {{$row->nama_paket}} </td>
                    <td> {{$row->destinasi->nama_destinasi}} </td> 
                    <td> {{$row->hotel->nama_hotel}} </td>
                    <td> {{$row->transportasi->nama_transportasi}} </td> 
                    <td> {{$row->durasi}} </td>
                    <td> {{$row->harga}} </td> 
                    <td> 
                        @if ($row->status == 'Tersedia')
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
                                <a class="dropdown-item" href="{{ route('backend.paket.edit', $row->id) }}">
                                    <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                    Edit
                                </a>
                                <form method="POST"
                                    action="{{ route('backend.paket.destroy', $row->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="dropdown-item"
                                            data-konf-delete="{{ $row->nama_paket }}">
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