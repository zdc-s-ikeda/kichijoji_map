<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>投稿結果</title>
    <style type="text/css">
      header {
        background-color: #E4F9FF;
      }
      li {
        padding: 0px;
        list-style: none;
        display: inline;
      }
      img {
        width: 7%;
        height: 7%;
      }
    </style>
</head>
<body>
    <header>
      <ul class="list">
        <li><a href="../mypage/mypage.php"><img class="icon" src="../view/home.png" alt="ホーム"></a></li>
        <li><a href="../mypage/mypage.php"><img class="icon" src="../view/mypage.png" alt="マイページ"></a></li>
        <li><a href="../route/route.php"><img class="icon" src="../view/myroute.png" alt="マイルート"></a></li>
        <li><a href="../post/post.php"><img class="icon" src="../view/post.png" alt="投稿"></a></li>
      </ul>
    </header>
    <div class="err-msg"><?php display_error($errors); ?></div>
    <div class="success-msg"><?php display_success($success); ?></div>
</body>
</html>