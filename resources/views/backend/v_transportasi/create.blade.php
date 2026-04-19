@extends('Backend.V_Layouts.App') 
@section('content') 
<!-- contentAwal -->

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-6 gy-6">
            <div class="col-xxl">
                <div class="card">
                    <form class="form-horizontal" action="{{ route('backend.transportasi.store') }}" method="post" enctype="multipart/form-data">
                        @csrf 
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Tambah Transportasi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mt-1 g-5">
                                <label class="col-sm-2 col-form-label" for="basic-default-jenis-transportasi">Jenis Transportasi</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="jenis_transportasi" value="{{ old('jenis_transportasi') }}" class="form-control @error('jenis_transportasi') is-invalid @enderror" placeholder="Masukkan Jenis Transportasi"> 
                                    @error('jenis_transportasi') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-1 g-5">
                                <label class="col-sm-2 col-form-label" for="basic-default-nama-transportasi">Nama Transportasi</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="nama_transportasi" value="{{ old('nama_transportasi') }}" class="form-control @error('nama_transportasi') is-invalid @enderror" placeholder="Masukkan Nama Transportasi"> 
                                    @error('nama_transportasi') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-1 g-5">
                                <label class="col-sm-2 col-form-label" for="basic-default-kota-keberangkatan">Kota Keberangkatan</label>
                                <div class="col-sm-10">
                                    <input type="text" name="kota_keberangkatan" value="{{ old('kota_keberangkatan') }}" class="form-control @error('kota_keberangkatan') is-invalid @enderror" placeholder="Masukkan Kota Keberangkatan"> 
                                    @error('kota_keberangkatan') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>
                            </div>

                            <div class="row mt-1 g-5">
                                <label class="col-sm-2 col-form-label" for="basic-default-kota-tujuan">Kota Tujuan</label>
                                <div class="col-sm-10">
                                    <input type="text" name="kota_tujuan" value="{{ old('kota_tujuan') }}" class="form-control @error('kota_tujuan') is-invalid @enderror" placeholder="Masukkan Kota Tujuan"> 
                                    @error('kota_tujuan') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>
                            </div>

                            <div class="row mt-1 g-5">
                                <label class="col-sm-2 col-form-label" for="basic-default-waktu-berangkat">Waktu Berangkat</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" name="waktu_berangkat" value="{{ old('waktu_berangkat') }}" class="form-control @error('waktu_berangkat') is-invalid @enderror" placeholder="Masukkan Waktu Berangkat"> 
                                    @error('waktu_berangkat') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>
                            </div>

                            <div class="row mt-1 g-5">
                                <label class="col-sm-2 col-form-label" for="basic-default-waktu-tiba">Waktu Tiba</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" name="waktu_tiba" value="{{ old('waktu_tiba') }}" class="form-control @error('waktu_tiba') is-invalid @enderror" placeholder="Masukkan Waktu Tiba"> 
                                    @error('waktu_tiba') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>
                            </div>

                            <div class="row mt-1 g-5">
                                <label class="col-sm-2 col-form-label" for="basic-default-harga">Harga</label>
                                <div class="col-sm-10">
                                    <input type="text" onkeypress="return hanyaAngka(event)" name="harga" value="{{ old('harga') }}" class="form-control @error('harga') is-invalid @enderror" placeholder="Masukkan Harga"> 
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
                                        <option value="" {{ old('status') == '' ? 'selected' : '' }}> - Pilih Status 
                                            -    
                                        </option> 
                                        <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}> Tersedia</option> 
                                        <option value="Full Booked" {{ old('status') == 'Full Booked' ? 'selected' : '' }}> Full Booked 
                                        </option> 
                                    </select> 
                                    @error('status') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('backend.transportasi.index') }}" class="btn btn-secondary">
                                        Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 