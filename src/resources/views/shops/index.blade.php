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
{{-- Auth::check(): ユーザーがログインしているかを確認。
ログイン済みならmenuルートに遷移。
未ログインならnotloggedinルートに遷移。 --}}
  <a href="{{ Auth::check() ? route('menu') : route('notloggedin') }}" class="icon-link">
  <span class="icon">
    <i class="fa-solid fa-square-poll-horizontal horizontal"></i></span>
  </a>

  <h1 class="header-ttl">Rese</h1>

  <!-- ログインしているユーザー名を表示 -->
  @if(Auth::check())
    <div class="user-name">
      <span>{{ Auth::user()->name }}さん</span> <!-- ユーザー名を表示 -->
    </div>
  @endif


  <div class="header-nav">

    <form action="{{ route('shops.search') }}" method="get">
      @csrf
      <div class="search-form-group">

        <select name="area">
          <option value="">All area</option>
          {{-- エリア一覧を$areasから取得し、選択肢として表示。 --}}
            @foreach ($areas as $area)
              <option value="{{ $area->id }}">{{ $area->area_name }}</option>
            @endforeach
        </select>

        <select name="genre">
          <option value="">All genre</option>
          {{-- ジャンル一覧を$genresから取得し、選択肢として表示。 --}}
            @foreach ($genres as $genre)
              <option value="{{ $genre->id }}">{{ $genre->genre_name }}</option>
            @endforeach
        </select>

        <i class="fa-solid fa-magnifying-glass magnifying"></i>
          <input type="text" name="keyword" placeholder="Search...">
          <div class="search-button">
            <input type="submit" value="検索">
          </div>
      </div>
    </form>
  </div>
</header>

    <!-- メッセージの表示 -->
  @if(session('message'))
    <div class="alert alert-info">
      {{-- セッションに格納されたメッセージがあれば、画面に表示。 --}}
        {{ session('message') }}
    </div>
  @endif


<main class="main">


  @foreach ($shops as $shop)
    <div class="shop-item">
      <div class="shop-image" style="background-image: url({{ $shop->image_url }})">
      </div>

    <div class="shop-info">
        <h3>{{ $shop->name }}</h3>

        <div class="shop-details">
        <span>#{{ $shop->area->area_name }}</span>
        <span>#{{ $shop->genre->genre_name }}</span>
        </div>

{{-- **Auth::check()**でログイン状態を確認。
ログイン済み: 店舗詳細ページへ遷移するルート（route('shops.show', $shop)）を設定。
未ログイン: #（現在のページを維持）を設定。 --}}
{{-- class属性:
未ログインの場合、disabledクラスを付与。これによりCSSで見た目を無効化。
onclick属性:
未ログインの場合、JavaScriptでクリック操作を無効化（return false;）。 --}}
    <a href="{{ Auth::check() ? route('shops.show', $shop) : '#' }}" class="detail-button @if(!Auth::check()) disabled @endif" @if(!Auth::check()) onclick="return false;" @endif>詳しく見る
    </a>


      <div class="heart-container">
        {{-- 店舗IDを渡して、「お気に入り」登録・解除を切り替える処理を実行。 --}}
        <form action="{{ route('shops.toggle-favorite', ['shop' => $shop->id]) }}" method="POST">
          @csrf
            <!-- 未ログインの場合はボタンが無効になる -->
            <button type="submit" @if(!Auth::check()) disabled @endif>
              <i class="fa-solid fa-heart heart @if($shop->isFavoritedByUser(auth()->id())) is-active @endif"></i>
            </button>
        </form>
      </div>
    </div>
  </div>
@endforeach
{{-- 店舗が見つからない場合のメッセージ --}}
@if (empty($shops))
<div class="alert alert-warning" >
検索条件に一致する店舗は見つかりませんでした。</div>
@endif



</main>

</body>
</html>