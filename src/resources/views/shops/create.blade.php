@extends('layouts.app')

@section('content')

{{-- フォーム送信先のURLを指定します。この場合、shops.store という名前のルートに送信されます。 --}}
<form class="main-ttl" method="post" action="{{ route('shops.store') }}">

@csrf

<div class="registration-title">Register a new store</div>

<div class="input-container">
    <i class="fa-regular fa-image store-image" ></i>
    <input type="text" placeholder="画像のURL" name="image_url">
    
    @error('image_url')
    <p>{{ $message }}</p>
    @enderror
</div>


<div class="input-container">
    <i class="fa-solid fa-store store-mark"></i>
    <input type="text" placeholder="店舗名" name="name">
        @error('name')
    <p>{{ $message }}</p>
    @enderror
</div>


  <div class="input-container">
<i class="fa-solid fa-map-location map-location"></i>
    <input type="text" placeholder="地域" name="area">

    @error('area')
    <p>{{ $message }}</p>
    @enderror
  </div>

  <div class="input-container">
    <i class="fa-solid fa-utensils utensils"></i>
    <input type="text" placeholder="ジャンル" name="genre">
    @error('genre')
    <p>{{ $message }}</p>
    @enderror
  </div>

<div class="input-container">
<i class="fa-solid fa-circle-info info" ></i>
    <textarea name="description"></textarea>
        @error('description')
    <p>{{ $message }}</p>
    @enderror
</div>

<div class="btn-container">
    <input type="submit" value="登録">
</div>

</form>

@endsection
