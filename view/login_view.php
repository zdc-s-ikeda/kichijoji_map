<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ログインページ</title>
  <style type="text/css">
    body {
      color: #6b6b6b;
      background-color: #faf5e4;
      margin: 0px;
    }
    header {
      background-color: #f8b400;
    }
    #logo {
      width: 45%;
    }
    .article1 {
      padding: 20px;
    }
  </style>
</head>
<body>
    <header>
    <label><img id="logo" src="../view/logo.png"></label>
  </header>
  <div class="article1">
    <h1>ようこそ、ログインしてください</h1>
    <!-- 送信先のURLがactionに入る -->
    <form method="post" action="login_process.php">
      <div><input type="text" name="user_name" placeholder="ユーザー名"></div>
      <div><input type="password" name="password" placeholder="パスワード"></div>
      <div><button type="submit">ログイン</div>
    </form>
    <div>
      <!--新規登録のファイルへ -->
      <h2><a href="../sign_up/sign_up.php">初めての方はこちら</a></h2>
    </div>
  </div>
</body>
</html>
