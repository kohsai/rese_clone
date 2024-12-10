@extends('layouts.app')

@section('content')


<div class="register-thanks">会員登録ありがとうございます
    <form action="{{ route('login') }}" method="get">
@csrf
     <div class="loginbtn-container">
    <input type="submit" value="ログインする"></input>
    </div>
  </form>
</div>


@endsection

