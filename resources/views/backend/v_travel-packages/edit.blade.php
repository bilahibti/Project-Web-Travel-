@extends('Backend.V_Layouts.App') 
@section('content') 
<!-- contentAwal -->

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-6 gy-6">>
            <div class="col-xxl">
                <div class="card">
                    <form class="form-horizontal" action="{{ route('backend.paket.update', $edit->id) }}"  method="post" enctype="multipart/form-data">
                        @csrf 
                        @method('PUT')
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Edit Paket</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row mt-1 g-5">
                                    <label class="col-sm-2 col-form-label" for="basic-default-nama-paket">Nama Paket</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nama_paket" value="{{ old('nama_paket', $edit->nama_paket) }}" class="form-control @error('nama_paket') is-invalid @enderror" placeholder="Masukkan Nama Paket"> 
                                        @error('nama_paket') 
                                        <span class="invalid-feedback alert-danger" role="alert"> 
                                            {{ $message }} 
                                        </span> 
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-1 g-5">
                                    <label class="col-sm-2 col-form-label" for="basic-default-nama-destinasi">Nama Destinasi</label>
                                    <div class="col-sm-10">
                                        <select class="form-control @error('destinasi') is-invalid @enderror" name="destinasi_id">
                                            <option value="" selected>--Pilih Destinasi--</option> 
                                            @foreach ($destinasi as $k) 
                                            <option value="{{ $k->id }}"> {{ $k->nama_destinasi }} </option> 
                                            @endforeach 
                                        </select>
                                        @error('destinasi_id') 
                                        <span class="invalid-feedback alert-danger" role="alert"> 
                                            {{ $message }} 
                                        </span> 
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-1 g-5">
                                    <label class="col-sm-2 col-form-label" for="basic-default-nama-hotel">Nama Hotel</label>
                                    <div class="col-sm-10">
                                        <select class="form-control @error('hotel') is-invalid @enderror" name="hotel_id">
                                            <option value="" selected>--Pilih Hotel--</option> 
                                            @foreach ($hotel as $k) 
                                            <option value="{{ $k->id }}"> {{ $k->nama_hotel }} </option> 
                                            @endforeach 
                                        </select> 
                                        @error('hotel_id')  
                                        <span class="invalid-feedback alert-danger" role="alert"> 
                                            {{ $message }} 
                                        </span> 
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-1 g-5">
                                    <label class="col-sm-2 col-form-label" for="basic-default-nama-transportasi">Nama Transportasi</label>
                                    <div class="col-sm-10">
                                        <select class="form-control @error('transportasi') is-invalid @enderror" name="transportasi_id">
                                            <option value="" selected>--Pilih Transportasi--</option> 
                                            @foreach ($transportasi as $k) 
                                            <option value="{{ $k->id }}"> {{ $k->nama_transportasi }} </option> 
                                            @endforeach 
                                        </select> 
                                        @error('transportasi_id')   
                                        <span class="invalid-feedback alert-danger" role="alert"> 
                                            {{ $message }} 
                                        </span> 
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-1 g-5">
                                    <label class="col-sm-2 col-form-label" for="basic-default-durasi">Durasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="durasi" value="{{ old('durasi', $edit->durasi) }}" class="form-control @error('durasi') is-invalid @enderror" placeholder="Masukkan Durasi"> 
                                        @error('durasi') 
                                        <span class="invalid-feedback alert-danger" role="alert"> 
                                            {{ $message }} 
                                        </span> 
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-1 g-5">
                                    <label class="col-sm-2 col-form-label" for="basic-default-harga">Harga</label>
                                    <div class="col-sm-10">
                                        <input type="text" onkeypress="return hanyaAngka(event)" name="harga" value="{{ old('harga', $edit->harga) }}" class="form-control @error('harga') is-invalid @enderror" placeholder="Masukkan Harga"> 
                                        @error('harga') 
                                        <span class="invalid-feedback alert-danger" role="alert"> 
                                            {{ $message }} 
                                        </span> 
                                        @enderror 
                                    </div>
                                </div>

                                <div class="row mt-1 g-5">
                                    <label class="col-sm-2 col-form-label" for="basic-default-status">Status</label>
                                    <div class="col-sm-10">
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="" {{ old('status', $edit->status) == '' ? 'selected' : '' }}> - 
                                                Pilih Status -</option>
                                            <option value="Tersedia" {{ old('status', $edit->status) == 'Tersedia' ? 'selected' : '' }}> 
                                                Tersedia</option> 
                                            <option value="Full Booked" {{ old('status', $edit->status) == 'Full Booked' ? 'selected' : '' }}> 
                                                Full Booked</option> 
                                        </select> 
                                         @error('status') 
                                        <span class="invalid-feedback alert-danger" role="alert"> 
                                            {{ $message }} 
                                        </span> 
                                        @enderror 
                                    </div>
                                </div>

                                <div class="row justify-content-end mt-6">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Perbarui</button>
                                        <a href="{{ route('backend.paket.index') }}"> 
                                            <button type="button" class="btn btn-secondary">Kembali</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 