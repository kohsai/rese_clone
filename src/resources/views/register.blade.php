@extends('layouts.app')

@section('content')

<form class="main-ttl">
    <action="/register" method="post">
@csrf

<div class="registration-title">Registration</div>

<div class="input-container">
  <i class="fa-solid fa-user-large user-icon"></i>
    <input type="text" placeholder="Username" name="name" value="{{ old('name') }}">
        {{-- @error('name')
    <p>{{ $message }}</p>
    @enderror --}}
</div>


  <div class="input-container">
<i class="fa-solid fa-envelope envelope"></i>
    <input type="email" placeholder="Email" name="email" value="{{ old('email') }}">

    {{-- @error('email')
    <p>{{ $message }}</p>
    @enderror --}}
  </div>

  <div class="input-container">
<i class="fa-solid fa-unlock-keyhole keyhole"></i>
    <input type="password" placeholder="Password" name="password">
    {{-- @error('password')
    <p>{{ $message }}</p>
    @enderror --}}
  </div>
</form>

  <div class="btn-container">
    <input type="submit" value="登録">
  </div>
@endsection

