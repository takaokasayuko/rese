<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rese</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/emails/send-email.css') }}">
</head>

<body>
  <maim>
    @yield('content')
    <p class="message-attention">
      本メールにお心当たりがない場合は、恐れ入りますが破棄していただきますようお願いいたします。
      Rese
    </p>
    </main>
</body>

</html>