@extends('backend.v_layouts.app') 
@section('content') 

<div class="container-fluid py-4">

    @if(auth()->user()->hasRole('admin'))
        @include('backend.v_beranda.admin')

    @elseif(auth()->user()->hasRole('staff'))
        @include('backend.v_beranda.staff')

    @elseif(auth()->user()->hasRole('finance'))
        @include('backend.v_beranda.finance')

    @else
        <div class="alert alert-danger">Role tidak dikenali</div>
    @endif

</div>

@endsection