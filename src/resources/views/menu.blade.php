@extends('layouts.usermenu')

@section('content')


<div class="user-menu">
        <a href="/">Home</a>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
        <a href="/mypage">Mypage</a>
</div>



@endsection