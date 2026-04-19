@extends('Backend.V_Layouts.App') 
@section('content') 
<!-- contentAwal -->

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-6 gy-6">
            <div class="col-xxl">
                <div class="card">
                    <form class="form-horizontal" action="{{ route('backend.hotel.update', $edit->id) }}"  method="post" enctype="multipart/form-data">
                        @csrf 
                        @method('PUT')
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Edit Hotel</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-4">
                                        <label class="form-label">Nama Hotel</label>
                                        <input type="text" name="nama_hotel"
                                        value="{{ old('nama_hotel', $edit->nama_hotel) }}"
                                        class="form-control @error('nama_hotel') is-invalid @enderror"
                                        placeholder="Masukkan Nama Hotel">
                                        @error('nama_hotel')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Alamat</label>
                                        <input type="text" name="alamat"
                                            value="{{ old('alamat', $edit->alamat) }}"
                                            class="form-control @error('alamat') is-invalid @enderror"
                                            placeholder="Masukkan Alamat">
                                        @error('alamat')
                                            <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea
                                        name="deskripsi"
                                        class="form-control @error('deskripsi') is-invalid @enderror"
                                        placeholder="Masukkan Deskripsi"
                                        style="height: 60px">{{ old('deskripsi', $edit->deskripsi) }}</textarea>
                                        @error('deskripsi') 
                                        <span class="invalid-feedback alert-danger" role="alert"> 
                                            {{ $message }} 
                                        </span> 
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Rating</label>
                                        <input type="text" name="rating"
                                            value="{{ old('rating', $edit->rating) }}"
                                            onkeypress="return hanyaAngka(event)"
                                            class="form-control @error('rating') is-invalid @enderror"
                                            placeholder="Masukkan Rating">
                                        @error('rating')
                                            <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Harga Per Malam</label>
                                        <input type="text" name="harga_per_malam"
                                            value="{{ old('harga_per_malam', $edit->harga_per_malam) }}"
                                            onkeypress="return hanyaAngka(event)"
                                            class="form-control @error('harga_per_malam') is-invalid @enderror"
                                            placeholder="Masukkan Harga Per Malam">
                                        @error('harga_per_malam')
                                            <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Status</label>
                                        <select name="status"
                                            class="form-control @error('status') is-invalid @enderror">
                                            <option value="">- Pilih Status -</option>
                                            <option value="Tersedia" {{ old('Status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="Full Booked" {{ old('Status') == 'Full Booked' ? 'selected' : '' }}>Full Booked</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 text-center">
                                    {{-- view image --}} 
                                    @if ($edit->foto) 
                                    <img id="preview-image" src="{{ asset('storage/img-hotel/' . $edit->foto) }}" 
                                    class="img-fluid rounded mb-3"
                                    style="width: 200px; height: auto; border-radius: 8px;">
                                    <p></p> 
                                    @else 
                                    <img id="preview-image" src="{{ asset('storage/img-user/1.png') }}" 
                                    class="img-fluid rounded mb-3"
                                    style="width: 200px; height: auto; border-radius: 8px;"> 
                                    <p></p> 
                                    @endif 

                                    <div class="mb-3">
                                        <label for="upload" class="btn btn-primary btn-sm">
                                            Upload New Photo
                                        </label>
                                        <input type="file"
                                            name="foto"
                                            id="upload"
                                            class="d-none"
                                            accept="image/png, image/jpeg"
                                            onchange="previewImage(this)">  
                                        @error('foto')
                                            <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="button"
                                        class="btn btn-outline-danger btn-sm mb-2"
                                        onclick="resetPreview()">
                                        Reset
                                    </button>

                                    <p class="text-muted small">
                                        Allowed JPG, GIF or PNG. Max size 800K
                                    </p>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('backend.hotel.index') }}" class="btn btn-secondary">
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

@push('scripts')
<script>
function previewImage(input) {
    const img = document.getElementById('preview-image');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function resetPreview() {
    const img = document.getElementById('preview-image');
    img.src = "{{ $edit->foto 
        ? asset('storage/img-hotel/'.$edit->foto) 
        : asset('storage/img-user/1.png') }}";
    document.getElementById('upload').value = '';
}
</script>
@endpush