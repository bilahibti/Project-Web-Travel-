@extends('backend.v_layouts.app') 
@section('content') 

<div class="container-fluid py-4">

    @if(auth()->user()->hasRole('admin'))
        @include('backend.v_dashboard.admin')

    @elseif(auth()->user()->hasRole('staff'))
        @include('backend.v_dashboard.staff')

    @else
        <div class="alert alert-danger">Role is not recognized</div>
    @endif

</div>

@endsection