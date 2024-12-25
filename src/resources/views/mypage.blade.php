<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.6.0/css/all.css">
</head>


<body class="container">

<header class="header">
<!-- アイコンをクリックしたら遷移先を変える -->
    <a href="{{ Auth::check() ? route('menu') : route('notloggedin') }}" class="icon-link">
        <span class="icon">
        <i class="fa-solid fa-square-poll-horizontal horizontal"></i></span>
    </a>

    <h1 class="header-ttl">Rese</h1>
</header>

<main class="main">

    @if(Auth::check())
    <div class="mypage-name">
    <h2>{{ Auth::user()->name }}さん</h2> <!-- ユーザー名を表示 -->
    </div>
    @endif







</main>
</body>
</html>








