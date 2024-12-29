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

<main class="show-main">
  {{-- 左側：店舗情報 --}}
  <div class="show-shop-info">
            <h2 class="shop-name">{{ $shop->name }}</h2>

            <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}" class="show-shop-image">

            <p class="shop-tags">#{{ $shop->area->area_name }} #{{ $shop->genre->genre_name }}</p>

            <p class="shop-descrition">{{ $shop->description }}</p>
    </div>


{{-- 右側の予約フォーム --}}
    <div class="reservation-form">
        <h2>予約</h2>
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">

                {{-- 日付入力 --}}
                <div class="show-form-group">
                    <label for="date">日付:</label>
                    <input type="date" name="date" id="date" required style="width: 200px;" value="{{ old('date', $confirmationData['date'] ?? '') }}">
                </div>

                {{-- 時間選択 --}}
                <div class="show-form-group">
                    <label for="time">時間:</label>
                      <select name="time" id="time" required>
                        @for ($hour = 10; $hour <= 22; $hour++)

                          <option value="{{ sprintf('%02d:00', $hour) }}"
                          {{ (session('confirmationData.time') ?? '') == sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                          {{ sprintf('%02d:00', $hour) }}</option>

                          <option value="{{ sprintf('%02d:30', $hour) }}"
                          {{ (session('confirmationData.time') ?? '') == sprintf('%02d:30', $hour) ? 'selected' : '' }}>
                          {{ sprintf('%02d:30', $hour) }}
                        </option>
                        @endfor
                      </select>
                </div>

                {{-- 人数選択 --}}
                <div class="show-form-group">
                    <label for="number">人数:</label>
                    <select name="number" id="number" required>
                        @for ($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}"
                            {{ session('confirmationData.number') == $i ? 'selected' : '' }}>
                              {{ $i }}人
                            </option>
                        @endfor
                    </select>
                </div>


              {{-- 確認ボタン --}}

            <button type="submit" formaction="{{ route('reservations.confirm') }}" class="show-confirm-button">
            確認する
            </button>

        <!-- 確認情報の表示 -->
      @if (!empty($confirmationData))
        <div>
          <p>日付: {{ $confirmationData['date'] }}</p>
          <p>時間: {{ $confirmationData['time'] }}</p>
          <p>人数: {{ $confirmationData['number'] }}</p>
        </div>
      @endif


        {{-- 予約ボタン --}}
      @if ($confirmationFlag ?? false)
          <button class="btn btn-primary">予約する</button>
      @else
          <button class="btn btn-primary" disabled>予約する</button>
      @endif


            </form>
    </div>
</main>

</body>

</html>
