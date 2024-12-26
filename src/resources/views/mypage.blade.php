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

<main class="mypage-main">

@if(Auth::check())
    <div class="mypage-name">
        <h2>{{ Auth::user()->name }}さん</h2> <!-- ユーザー名を表示 -->
    </div>

<div class="mypage-container">

<!-- 左側: 予約情報 -->
        <div class="reservations">
            <h3>予約状況</h3>
            <div class="reservation-list">
                <!-- 仮の予約情報 -->
                <div class="reservation-item">
                    <p>Shop: 仙人</p>
                    <p>Date: 2021-04-01</p>
                    <p>Time: 17:00</p>
                    <p>Number: 1人</p>
                </div>
                <!-- 繰り返し分の予約情報 -->
            </div>
        </div>

        {{-- <右側: お気に入り店舗> --}}
    <div class="favorites">
        <h3>お気に入り店舗</h3>
        <div class="favorites-container">
            @if(!empty($favorites) && count($favorites) > 0)
            @foreach ($favorites as $shop)
            <div class="shop-item">
                <div class="shop-image" style="background-image: url({{ $shop->image_url }});">
            </div>
            <div class="shop-info">
            <h3>{{ $shop->name }}</h3>
                <div class="shop-details">
                <span>#{{ $shop->area->area_name }}</span>
                <span>#{{ $shop->genre->genre_name }}</span>
            </div>
        <form action="{{ route('shops.show', $shop) }}" method="GET">
            <button type="submit" class="detail-button">詳しく見る</button>
        </form>
            <div class="heart-container">
                <i class="fa-solid fa-heart heart is-active"></i>
            </div>
        </div>
    </div>
    @endforeach
    @else
        <p>お気に入り店舗はありません。</p>
    @endif
    </div>
</div>
</div>
@endif

</main>
</body>
</html>








