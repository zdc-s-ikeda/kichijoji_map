<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>新規登録</title>
  <!--スタイルシートのリンク記入-->
  <link type="text/css" rel="stylesheet" href="">
</head>
<body>
  <div class="content">
    <div class="sign_up">
      <div class="err-msg"><?php display_error($errors); ?></div>
      <div class="success-msg"><?php display_success($success); ?></div>
      <form method="post" action="sign_up.php">
        <div>ユーザー名：<input type="text" name="user_name" placeholder="半角英数字2字以上30文字以内"></div>
        <div>パスワード：<input type="password" name="password" placeholder="半角英数字5字以上30文字以内"></div>
        <div>メールアドレス(任意)：<input type="text" name="mail" placeholder="example@zenrin-datacom.net"> </div>
        <div>
            性別：
            <select name="gender">
                <option value="1">男性</option>
                <option value="2">女性</option>
                <option value="3">その他</option>
            </select>
        </div>
        <div>生年月日(任意)：<input type="date" name="birthdate"></div>
        <div><input type="submit" value="登録"></div>
      </form>
      <!--ログインページのリンク記入-->
      <div class="login-link"><a href="../login/login.php">ログイン</a></div>
    </div>
  </div>
</body>
</html>
