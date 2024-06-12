<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/layouts.css')}}"/>
    @yield('css')
    @yield('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<header>
    <div class="header">
        <span class="nav_toggle">
            <i></i>
            <i></i>
            <i></i>
        </span>
        @auth
        <nav class="nav">
            <ul class="nav_menu_ul">
                <li class="nav_menu_li"><a href="/myPage">マイページ</a></li>
                <li class="nav_menu_li"><a href="/search">店舗検索</a></li>
                <li class="nav_menu_li">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                            <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                            </x-dropdown-link>
                    </form>
                </li>
                @if(Auth::user()->role > 9)
                <li class="nav_menu_li"><a href="/managementIndex">マネジメント画面</a></li>
                @endif
                @if(Auth::user()->role > 99)
                <li class="nav_menu_li"><a href="/accountIndex">アカウント画面</a></li>
                @endif
            </ul>
        </nav>
        @else
        <nav class="nav">
            <ul class="nav_menu_ul">
                <li class="nav_menu_li"><a href="/search">店舗検索</a></li>
                <li class="nav_menu_li"><a href="/login">ログイン</a></li>
                <li class="nav_menu_li"><a href="/register">会員登録</a></li>
            </ul>
        </nav>
        @endauth
        <span id="title">Rese</span>
    </div>
</header>
<body>
    <main>
    @yield('content')
    </main>
    <script>
    $(".nav_toggle").on("click", function () {
    $(".nav_toggle, .nav").toggleClass("show");
    });
    </script>
</body>
</html>