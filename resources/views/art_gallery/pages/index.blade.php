@extends('layouts.app')

@section('title', 'Art Gallery')

@section('body-class', 'bg-gray-100')

@push('styles')
    @include('partials.navbar-style')
@endpush

@push('scripts')
    @include('partials.navbar-script')
@endpush

@section('content')
<div class="mt-4">
    <div class="flex justify-center items-center">
        <form action="#">
            <input type="text" placeholder="Search.." name="search" class="hover:shadow-lg px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-red-500">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="card">
        <img src="img_avatar.png" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>Monalisa</b></h4>
            <p>Harga Rp. -</p>
        </div>
    </div>
    <div class="card">
        <img src="img_avatar.png" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>Banana Lakban Hitam</b></h4>
            <p>Harga Rp. -</p>
        </div>
    </div>
    <div class="card">
        <img src="img_avatar.png" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>Satoshi</b></h4>
            <p>Harga Rp. -</p>
        </div>
    </div>
    <div class="card">
        <img src="img_avatar.png" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>Mawar</b></h4>
            <p>Harga Rp. -</p>
        </div>
    </div> 
</div>
@endsection
