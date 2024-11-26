<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.6.0/css/all.css">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>


<body class="container">
    <header class="header">
        {{-- <a href="/mypage"> --}}
            <i class="fa-solid fa-square-poll-horizontal horizontal"></i>
        </a>
        {{-- ↑  アイコンのシャドーは擬似要素の影響（？）でうまく表示されず、保留。 --}}

        <h1 class="header-ttl">Rese</h1>
    </header>
    
    <main class="main">
        @yield('content')
    </main>
</body>

</html>

