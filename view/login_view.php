<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ログインページ</title>
</head>
<body>
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
</body>
</html>
