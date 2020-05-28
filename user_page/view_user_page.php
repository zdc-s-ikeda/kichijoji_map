<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="utf-8" />
    <title>ユーザーページ</title>
    <style type="text/css">
      
    </style>
</head>
<body>
    <h1>プロフィール</h1>
    <form method="post">
    <ul>
        <li>ユーザーID：<?php echo $user_id; ?></li>
        <li>ユーザー名：<?php echo $user_name; ?></li>
        <li>パスワード：<?php echo $password; ?></li>
        <li>メールアドレス：<?php echo $email; ?></li>
        <li>性別：<?php echo $gender; ?></li>
        <li>生年月日：<?php echo $birthdate; ?></li>
        <li>登録日：<?php echo $created_date; ?></li>
        <li>更新日：<?php echo $updated_date; ?></li>
    </ul>
    </form>
    // <a href="logout.php?logout">ログアウト</a>
    </div>
</body>
</html>