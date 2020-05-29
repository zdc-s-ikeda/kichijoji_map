<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>投稿結果</title>
    <style type="text/css">
      header {
        background-color: #E4F9FF;
      }
      img {
        width: 7%;
        height: 7%;
      }
      #map_bottom li {
        display: inline;
      }
      #map_box {
        width: 800px;
        height: 500px;
        text-align: center;
        margin: 0 auto;
      }
    </style>
</head>
<body>
    <section id="header">
      <label><img id="logo" src="../view/logo.png"></label>
      <div id="map_bottom">
      <li><a href="../mypage/mypage.php"><img class="icon" src="../view/home.png" alt="ホーム"></a></li>
      <li><a href="../route/route.php"><img class="icon" src="../view/myroute_clicked.png" alt="マイルート"></a></li>
      <li><a href="../post/post.php"><img class="icon" src="../view/post.png" alt="投稿"></a></li>
      </div>
    </section>
    <p>現在修正中です</p>
    <div class="err-msg"><?php display_error($errors); ?></div>
    <div class="success-msg"><?php display_success($success); ?></div>
</body>
</html>