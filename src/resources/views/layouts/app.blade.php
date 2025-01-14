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
	<maim>
		<div class="header-menu">
			@section('search')
			<div class="menu-container">
				<input type="checkbox" id="menu-toggle">
				<h1 class="header-logo">Rese</h1>
				<label class="header-button" for="menu-toggle">
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
						@if(auth()->user()->admin === 2 || auth()->user()->admin === 0)
						<li class="header-nav__item">
							<a class="header-nav__link" href="/">Home</a>
						</li>
						@endif

						<li class="header-nav__item">
							<form class="form-logout" action="/logout" method="post">
								@csrf
								<button class="header-nav__button">Logout</button>
							</form>
						</li>
						@if(auth()->user()->admin === 0)
						<li class="header-nav__item">
							<a class="header-nav__link" href="/admin">Admin</a>
						</li>
						<li class="header-nav__item">
							<a class="header-nav__link" href="/admin/email">Mail</a>
						</li>
						@endif

						@if(auth()->user()->admin === 1)
						<li class="header-nav__item">
							<a class="header-nav__link" href="/owner/shop">Shop</a>
						</li>
						<li class="header-nav__item">
							<a class="header-nav__link" href="/owner/register">Register</a>
						</li>
						@endif

						@if(auth()->user()->admin === 2)
						<li class="header-nav__item">
							<a class="header-nav__link" href="/mypage">Mypage</a>
						</li>
						@endif
					</ul>
				</nav>
				@endauth
			</div>

			@show
		</div>

		<div class="wrapper">
			@yield('content')
		</div>

		</main>

</body>

</html>