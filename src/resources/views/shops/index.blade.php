<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.6.0/css/all.css">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>


<body class="container">

<header class="header">
  <span class="icon">
    <i class="fa-solid fa-square-poll-horizontal horizontal"></i></span>

    <h1 class="header-ttl">Rese</h1>

    <div class="header-nav">

      <div class="search-form-group">
        <select name="area">
          <option value="all">All area</option>
        </select>

        <select name="genre">
          <option value="all">All genre</option>
        </select>

        <form action="/search" method="get">
          <i class="fa-solid fa-magnifying-glass magnifying"></i>
           <input type="text" name="query" placeholder="Search...">
        </form>
      </div>
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
      <span>#{{ $shop->area }}</span>
      <span>#{{ $shop->genre }}</span>
    </div>

    <form action="{{ route('shops.show', $shop) }}" method="POST">
    @csrf
    <input type="submit" value="詳しく見る" class="detail-button">
    <div class="heart-container">
    <i class="fa-solid fa-heart heart"></i>
    </div>
    </form>
  </div>
</div>
    @endforeach


</main>

</body>

</html>
