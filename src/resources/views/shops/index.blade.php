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

  <!-- ログインしているユーザー名を表示 -->
  @if(Auth::check())
    <div class="user-name">
      <span>{{ Auth::user()->name }}さん</span> <!-- ユーザー名を表示 -->
    </div>
  @endif

  <!-- メッセージの表示 -->
  @if(session('message'))
    <div class="alert alert-info" style="color: #f39c12; padding: 5px; border: 1px solid #f39c12;">
        {{ session('message') }}
    </div>
  @endif


  <div class="header-nav">

    <form action="{{ route('shops.search') }}" method="get">
      @csrf
      <div class="search-form-group">

        <select name="area">
          <option value="">All area</option>
            @foreach ($areas as $area)
              <option value="{{ $area->id }}">{{ $area->area_name }}</option>
            @endforeach
        </select>

        <select name="genre">
          <option value="">All genre</option>
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
@if (empty($shops))
  <p>検索条件に一致する店舗は見つかりませんでした。</p>
@endif

  </div>
</header>


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

        <a href="{{ route('shops.show', $shop) }}" class="detail-button">詳しく見る</a>


      <div class="heart-container">
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
</main>

</body>
</html>