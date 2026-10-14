<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link href="{{ asset('css/sanitize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <link href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css"
        rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/hamburger.js') }}" defer></script>
    @yield('js')
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__utilities">
                @auth
                    <a class="header__logo" href="/">
                        <img class="header__logo--image" src="{{ asset('images/logo.svg') }}" alt="フリマアプリ">
                    </a>
                @endauth
                @guest
                    <a class="header__logo" href="/guest">
                        <img class="header__logo--image" src="{{ asset('images/logo.svg') }}" alt="フリマアプリ">
                    </a>
                @endguest
                @php
                    $specificRoutes = [
                        'login',
                        'register',
                        'sell.index',
                        'purchase.edit.address',
                        'guest.unauthorized_access',
                        'item.create',
                    ];
                @endphp
                @unless (\Route::currentRouteNamed(...$specificRoutes))
                    <form class="header__search-form" action="/search" method="GET">
                        <input class="header__search-input" name="keyword" type="text" value="{{ request('keyword') }}"
                            placeholder="なにをお探しですか？">
                        <div class="btn__wrap">
                            <button class="header__search-button">検索</button>
                        </div>
                    </form>
                    <nav class="header__nav">
                        <ul class="header__nav-list">
                            @auth
                                <li class="header__nav-item">
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button class="header__nav-button">ログアウト</button>
                                    </form>
                                </li>
                                <li class="header__nav-item">
                                    <a class="header__nav-link" href="/my-page/listed">マイページ</a>
                                </li>
                                @can('user')
                                    <form action="/item/create" method="GET">
                                        <button class="header__nav-button header__nav-button--listing">出品</button>
                                    </form>
                                @endcan
                                @can('delete')
                                    <form action="/admin-page/users" method="GET">
                                        <button class="header__nav-button header__nav-button--admin">管理画面</button>
                                    </form>
                                @endcan
                            @endauth
                            @guest
                                <li class="header__nav-item">
                                    <form action="/login" method="GET">
                                        <button class="header__nav-button">ログイン</button>
                                    </form>
                                </li>
                                <li class="header__nav-item">
                                    <form action="/register" method="GET">
                                        <button class="header__nav-button">会員登録</button>
                                    </form>
                                </li>
                                <form action="/guest/unauthorized_access" method="GET">
                                    <button class="header__nav-button header__nav-button--listing">出品</button>
                                </form>
                            @endguest

                        </ul>
                    </nav>
                    {{-- ハンバーガーボタン --}}
                    <div class="header__hamburger-button">
                        <span class="header__hamburger-toggle">
                            <i></i>
                            <i></i>
                            <i></i>
                        </span>
                        <div class="header__hamburger-close-wrapper">
                            <span class="header__hamburger-close">✕</span>
                        </div>
                    </div>
                    {{-- クリックで表示されるメニュー --}}
                    <form class="header__hamburger-search-form" action="/search" method="GET">
                        <input class="header__hamburger-search-input" name="keyword" type="text"
                            value="{{ request('keyword') }}" placeholder="なにをお探しですか？">
                        <div class="btn__wrap">
                            <button class="header__hamburger-search-button"><i class="las la-search"></i></button>
                        </div>
                    </form>
                    <nav class="header__hamburger-nav">
                        <ul class="header__hamburger-nav-list">
                            @auth
                                <li class="header__hamburger-nav-item">
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button class="header__hamburger-nav-button">ログアウト</button>
                                    </form>
                                </li>
                                <li class="header__hamburger-nav-item">
                                    <a class="header__hamburger-nav-link" href="/my-page/listed">マイページ</a>
                                </li>
                                @can('user')
                                    <form action="/item/create" method="GET">
                                        <button
                                            class="header__hamburger-nav-button header__hamburger-nav-button--listing">出品</button>
                                    </form>
                                @endcan
                                @can('delete')
                                    <form action="/admin-page/users" method="GET">
                                        <button
                                            class="header__hamburger-nav-button header__hamburger-nav-button--admin">管理画面</button>
                                    </form>
                                @endcan
                            @endauth
                            @guest
                                <li class="header__hamburger-nav-item">
                                    <form action="/login" method="GET">
                                        <button class="header__hamburger-nav-button">ログイン</button>
                                    </form>
                                </li>
                                <li class="header__hamburger-nav-item">
                                    <form action="/register" method="GET">
                                        <button class="header__hamburger-nav-button">会員登録</button>
                                    </form>
                                </li>
                                <form action="/guest/unauthorized_access" method="GET">
                                    <button
                                        class="header__hamburger-nav-button header__hamburger-nav-button--listing">出品</button>
                                </form>
                            @endguest
                        </ul>
                    </nav>
                @endunless
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>
