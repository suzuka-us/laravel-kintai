<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')

    <style>
        /* ▼ 追加：ログアウトフォームを横並び用に調整 */
        .header-nav__form {
            display: inline;
            /* ボタンと同じ高さで横並びにする */
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">

                <a class="header__logo" href="/">
                    <img src="{{ asset('images/coachtech.png') }}" alt="ロゴ">
                </a>


                <nav>
                    <ul class="header-nav">
                        @if (Auth::check())

                        <!-- ログアウト -->
                        <li class="header-nav__item">
                            <form action="/logout" method="post" class="header-nav__form">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>

                        <!-- マイページ -->
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/mypage/profile">マイページ</a>
                        </li>

                        <!-- 出品 -->
                        <li class="header-nav__item">
                            <a class="header-nav__link header-nav__link--sell" href="/sell">出品</a>

                        </li>



                        @endif
                    </ul>
                </nav>

            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>