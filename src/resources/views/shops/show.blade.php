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
    <div class="shop-name-group">
    <a href="{{ route('shops.index') }}" class="back-to-shops">
      <i class="fa-solid fa-angle-left"></i>
    </a>

      {{-- Bladeテンプレートで$shop->nameを取得し、店舗の名前を表示。 --}}
            <h2 class="shop-name">{{ $shop->name }}</h2>

    </div>
    {{-- $shop->image_urlから店舗画像のURLを取得。
例: $shop->image_urlが"https://example.com/shop.jpg"なら、その画像が表示される。 --}}
{{-- alt属性:画像が読み込まれない場合、代替テキストとして店舗名（$shop->name）が表示される。
例: $shop->nameが「カフェABC」の場合、画像が表示されないときに「カフェABC」が表示。 --}}
            <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}" class="show-shop-image">

{{-- 地域タグ: #{{ $shop->area->area_name }}
$shop->area->area_nameは地域情報を表示。
例: 地域が「東京」なら、#東京と表示。 --}}

{{-- ジャンルタグ: #{{ $shop->genre->genre_name }}
$shop->genre->genre_nameはジャンル情報を表示。
例: ジャンルが「カフェ」なら、#カフェと表示。 --}}
            <p class="shop-tags">#{{ $shop->area->area_name }} #{{ $shop->genre->genre_name }}</p>

{{-- 内容: $shop->descriptionで店舗の詳細説明を表示。
例: $shop->descriptionが「おしゃれなカフェで美味しいコーヒーが楽しめます。」なら、その説明が表示。 --}}
            <p class="shop-descrition">{{ $shop->description }}</p>
    </div>


{{-- 右側の予約フォーム --}}
    <div class="reservation-form">
        <h2>予約</h2>

    {{-- 予約時刻に関するエラーメッセージの表示 --}}
    @if (session()->has('error_message'))
        <div class="alert alert-danger">
            {{ session('error_message') }}
        </div>
    @endif

    {{-- 予約重複エラーメッセージ表示 --}}
    @if ($errors->has('date'))
        <div class="alert alert-danger" style="margin-top: 20px;">
            {{ $errors->first('date') }}
        </div>
    @endif

            <form action="{{ route('reservations.confirm') }}" method="POST">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">

                {{-- 日付を選択する入力フィールド。sessionやoldを使って過去の入力値を保持。 --}}
                <div class="show-form-group">

      <label for="date">日付:</label>
      <input type="date" name="date" id="date" required style="width: 200px;"
      value="{{ session('confirmationData.date', old('data', '')) }}"
      min="{{ \Carbon\Carbon::today()->toDateString() }}">
      </div>

    {{-- 時間選択。過去の入力値に応じて選択状態を保持。 --}}
    <div class="show-form-group">
    <label for="time">時間:</label>
    <select name="time" id="time" equired>
    @for ($hour = 10; $hour <= 22; $hour++)
    <option value="{{ sprintf('%02d:00', $hour) }}"

    {{ (session('confirmationData.time') == sprintf('%02d:00', $hour)) ? 'selected' : '' }}>
    {{ sprintf('%02d:00', $hour) }}
    </option>

    <option value="{{ sprintf('%02d:30', $hour) }}"
    {{ (session('confirmationData.time') == sprintf('%02d:30', $hour)) ? 'selected' : '' }}>
    {{ sprintf('%02d:30', $hour) }}
    </option>
    @endfor
    </select>
    </div>

    {{-- 人数選択。過去の入力値に応じて選択状態を保持。 --}}
    <div class="show-form-group">
      <label for="number">人数:</label>
      <select name="number" id="number" required>
        @for ($i = 1; $i <= 20; $i++)
        <option value="{{ $i }}"
      {{ (session('confirmationData.number', old('number')) == $i) ? 'selected' : '' }}>
      {{ $i }}人
        </option>
        @endfor
      </select>
    </div>

    <div class="confirm-button-group">
  {{-- 確認するボタン。フォームを送信して予約内容を確認する。
type="submit": ボタンをクリックすると、フォームの内容を指定されたaction（reservations.confirm）へ送信。--}}
    <button type="submit" class="show-confirm-button">
    確認する
    </button>
    </form>

    {{-- 選びなおすボタン --}}
  {{-- リンクボタン: 予約情報をリセットするページ（reservations.reset）に移動。パラメータとしてshop_idを送信し、リセット対象の店舗を識別。 --}}
      <a href="{{ route('reservations.reset', ['shop' => $shop->id]) }}" class="select-again-button">
      選びなおす
      </a>
      </div>


        <!-- 確認情報の表示 -->
{{-- session('confirmationData')を利用し、予約内容が存在するかチェック。
存在する場合は以下の確認情報を表示。 --}}
      @if (session('confirmationData'))
            @php
            // 予約確認データを変数$confirmationDataに格納。
                $confirmationData = session('confirmationData');
            @endphp

        {{-- 確認情報の表示。Carbonライブラリを使って日付を「YYYY年MM月DD日」形式にフォーマット。 --}}
        <div class="confirmation-data">
          <p>店舗名: {{ $confirmationData['shop_name'] }}</p>
          <p>日付: {{ \Carbon\Carbon::parse($confirmationData['date'])->format('Y年m月d日') }}</p>
          <p>時間: {{ $confirmationData['time'] }}</p>
          <p>人数: {{ $confirmationData['number'] }}</p>
        </div>

      <!-- 予約確定ボタン -->
      <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
      {{-- 隠しフィールド（<input type="hidden">）:
      フォームに表示しない形で必要なデータを送信 --}}
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
        <input type="hidden" name="date" value="{{ $confirmationData['date'] }}">
        <input type="hidden" name="time" value="{{ $confirmationData['time'] }}">
        <input type="hidden" name="number" value="{{ $confirmationData['number'] }}">
        <button type="submit" class="reserve-button">予約する</button>
      </form>
@else
    <!-- セッションデータがない場合（まだ確認内容が作成されていない場合）、予約ボタンを無効化 -->
    <button type="button" class="reserve-button" disabled>予約する</button>
@endif


    </div>
</main>

</body>

</html>
