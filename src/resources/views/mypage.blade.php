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
    <span class="icon">
        <i class="fa-solid fa-square-poll-horizontal horizontal"></i></span>

        <h1 class="header-ttl">Rese</h1>
    </header>

    <main class="mypage-main">

        @if (Auth::check())
            <div class="mypage-name">
                <h2>{{ Auth::user()->name }}さん</h2> <!-- ユーザー名を表示 -->
            </div>

        <div class="mypage-container">

        <!-- 左側: 予約情報 -->
        <div class="reservations">
            <h3>予約状況</h3>
                <div class="reservation-list">
                    <!-- 予約情報をループで表示 -->
                    @foreach ($reservations as $index => $reservation)
                        <div class="reservation-item">
                            <div class="reservation-header">
                                <i class="fa-solid fa-clock"></i>
                                <span class="reservation-number">予約{{ $index + 1 }}</span> <!-- 何番目の予約か表示 -->
                            </div>

                            <div class="reservation-details">
                                <p>店舗名: {{ $reservation->shop->name }}</p> <!-- 店舗名 -->

                                <p>予約日: {{ \Carbon\Carbon::parse($reservation->start_at)->format('Y-m-d') }}</p> <!-- 予約日 -->

                                <p>時間: {{ \Carbon\Carbon::parse($reservation->start_at)->format('H:i') }}</p> <!-- 予約時間 -->

                                <p>人数: {{ $reservation->num_of_users }}人</p> <!-- 予約人数 -->
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        {{-- <右側: お気に入り店舗> --}}
        <div class="favorites">
            <h3>お気に入り店舗</h3>
                <div class="favorites-container">
                @if (!empty($favorites) && count($favorites) > 0)
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

{{--
@foreach ($reservations as $reservation)
    <div class="reservation-item">
        <div class="reservation-header">
        <i class="fa-solid fa-clock"></i>
        <span class="reservation-number">予約{{ $reservation->id }}</span>
        <button class="delete-button" onclick="deleteReservation({{ $reservation->id }})">×</button>
    </div>
    <div class="reservation-details">
        <p>Shop: {{ $reservation->shop->name }}</p>
        <p>Date: {{ $reservation->date }}</p>
        <p>Time: {{ $reservation->time }}</p>
        <p>Number: {{ $reservation->number }}人</p>
    </div>
    </div>
@endforeach --}}
