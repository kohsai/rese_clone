@extends('layouts.app')

@section('content')

<div class="main-ttl">
  <form action="{{ route('login.store') }}" method="post">
@csrf

<div class="login-title">Login</div>


<div class="input-container">
  <i class="fa-solid fa-envelope envelope"></i>
    <input type="email" placeholder="Email" name="email" value="{{ old('email') }}">

    @error('email')
    <p>{{ $message }}</p>
    @enderror
</div>

<div class="input-container">
  <i class="fa-solid fa-unlock-keyhole keyhole"></i>
    <input type="password" placeholder="Password" name="password">

    @error('password')
    <p>{{ $message }}</p>
    @enderror
</div>

<div class="btn-container">
    <input type="submit" value="ログイン">
  </div>
  </form>
</div>
@endsection

