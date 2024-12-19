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

    <form action="{{ route('shops.search') }}" method="get">
      @csrf
      <div class="search-form-group">

        <select name="area">
          <option value="">All area</option>
            @foreach ($areas as $area)
              <option value="{{ $area->id }}">{{ $area->name }}</option>
            @endforeach
        </select>

        <select name="genre">
          <option value="">All genre</option>
            @foreach ($genres as $genre)
              <option value="{{ $genre->id }}">{{ $genre->name }}</option>
            @endforeach
        </select>

        <i class="fa-solid fa-magnifying-glass magnifying"></i>
          <input type="text" name="keyword" placeholder="Search...">
          <div class="search-button">
            <input type="submit" value="検索">
          </div>
      </div>
    </form>
@if(isset($shops) && count($shops) > 0)
  @foreach ($shops as $shop)
    @endforeach
@else
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
        <span>#{{ $shop->area->name }}</span>
        <span>#{{ $shop->genre->name }}</span>
        </div>

        <form action="{{ route('shops.show', $shop) }}" method="POST">
        @csrf
        <input type="submit" value="詳しく見る" class="detail-button">
        </form>


      <div class="heart-container">
        <input type="checkbox" id="heart-checkbox-{{ $shop->id }}" class="hidden" @if($shop->isFavoritedByUser(auth()->id())) checked @endif>

        <label for="heart-checkbox-{{ $shop->id }}">

        <i class="fa-solid fa-heart heart @if($shop->isFavoritedByUser(auth()->id())) is-active @endif"
        data-shop-id="{{ $shop->id }}"></i></label>
      </div>



<script>
// （お気に入り登録・解除の処理）
function toggleFavorite(shopId) {

const checkbox = document.getElementById(`heart-checkbox-${shopId}`);
checkbox.checked = !checkbox.checked;


const heart = document.querySelector(`[data-shop-id="${shopId}"]`);

heart.classList.toggle('is-active');

// サーバーにリクエストを送信し、データベースを更新する処理
fetch(`/shops/${shopId}/favorite`, {
method: 'POST',
headers: {
'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
}
})
.then(response => {

// 成功時の処理

})

.catch(error => {

// エラー時の処理

});
}

</script>

  </div>
</div>
    @endforeach


</main>
</body>
</html>