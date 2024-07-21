<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rese</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header-menu">

      <div class="menu-container">
        <input type="checkbox" id="menu-toggle">
        <h1 class="header-logo">Rese</h1>
        <label for="menu-toggle" class="header-button">

          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </label>

        @guest
        <nav class="nav">
          <ul class="header-nav">
            <li class="header-nav__item">
              <a class="header-nav__link" href="/">Home</a>
            </li>
            <li class="header-nav__item">
              <a class="header-nav__link" href="/register">Register</a>
            </li>
            <li class="header-nav__item">
              <a class="header-nav__link" href="/login">Login</a>
            </li>
          </ul>
        </nav>
        @endguest

        @auth
        <nav class="nav">
          <ul class="header-nav">
            <li class="header-nav__item">
              <a class="header-nav__link" href="/">Home</a>
            </li>
            <li class="header-nav__item">
              <form class="form" action="/logout" method="post">
                @csrf
                <button class="header-nav__button">Logout</button>
              </form>
            </li>
            <li class="header-nav__item">
              <a class="header-nav__link" href="/mypage">Mypage</a>
            </li>
          </ul>
        </nav>
        @endauth




      </div>

    </div>
  </header>

  <main>
    @yield('content')
  </main>

</body>

</html>