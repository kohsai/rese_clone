@extends('layouts.app')

@section('content')

<form class="main-ttl" method="post" action="{{ route('shops.store') }}">

@csrf

<div class="registration-title">Register a new store</div>

<div class="input-container">
    <i class="fa-regular fa-image store-image" ></i>
    <input type="file" placeholder="お店の画像" name="image">
        {{-- @error('name')
    <p>{{ $message }}</p>
    @enderror --}}
</div>


<div class="input-container">
    <i class="fa-solid fa-store store-mark"></i>
    <input type="text" placeholder="店舗名" name="name">
        {{-- @error('name')
    <p>{{ $message }}</p>
    @enderror --}}
</div>


  <div class="input-container">
<i class="fa-solid fa-map-location map-location"></i>
    <input type="text" placeholder="地域" name="area">

    {{-- @error('email')
    <p>{{ $message }}</p>
    @enderror --}}
  </div>

  <div class="input-container">
    <i class="fa-solid fa-utensils utensils"></i>
    <input type="text" placeholder="ジャンル" name="genre">
    {{-- @error('password')
    <p>{{ $message }}</p>
    @enderror --}}
  </div>

<div class="input-container">
<i class="fa-solid fa-circle-info info" ></i>
    <textarea name="description"></textarea>
        {{-- @error('name')
    <p>{{ $message }}</p>
    @enderror --}}
</div>

<div class="btn-container">
    <input type="submit" value="登録">
</div>

</form>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@endsection
