<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
    <style>
      
      body {
         color: #6b6b6b;
         background-color: #faf5e4;
         padding: 0px;
         margin: 0px;
      }
      #map_box {
        width: 500px;
        height: 500px;
        text-align: center;
      }
      .side_img {
        width: 100px;
        height: 100px;
      }
      p {
        word-wrap: break-word;
      }
      #header {
        background-color: #f8b400;
        width: 100%;
      }
      #header_li li {
        display: inline;
      }
      #main {
        display: flex;
      }
      .icon {
        width: 130px;
      }
      #center {
        flex: 1;
        padding: 40px;
      }
      #add {
        width: 300px;
      }
      #place_order {
        width: 30px;
      }
      #place_name {
        font-weight: bold;
      }
      #list_add_button {
        background-color: #ffffff;
        margin-bottom: 20px;
        margin-left: 5px;
        border-radius: 30px;
      }
      #list_add_button:hover {
      background-color: #0fabbc;
      margin-bottom: 20px;
      margin-left: 5px;
      border-radius: 30px;
      }
      #sidebar {
        color: #ffffff;
        background-color: #f8b400;
        width: 350px;
        height: 1000px;
      }
      #sidebar_list_name {
        font-size: 25px;
        font-weight: bold;
      }
      #place_name {
        font-weight: bold;
      }
      #logo {
        width: 45%;
      }
      #map_bottom li {
        display: inline;
      }
    </style>
</head>
<body>
    <section id="header">
    <label><img id="logo" src="../view/logo.png"></label>
      <div id="map_bottom">
    <li><a href="../mypage/mypage.php"><img class="icon" src="../view/home_clicked.png" alt="ホーム"></a></li>
    <li><a href="../route/route.php"><img class="icon" src="../view/myroute.png" alt="マイルート"></a></li>
    <li><a href="../post/post.php"><img class="icon" src="../view/post.png" alt="投稿"></a></li>
    </div>
    </section>
    
    <div id="main">
    <section id="center">
      <form action="../mypage/mypage.php" method="post">
        <select name="category">
          <option value = "0" <?php if($category === '0') { print 'selected'; } ?>>カテゴリーを選んでください</option>
          <option value = "1" <?php if($category === '1') { print 'selected'; } ?>>遊び</option>
          <option value = "2" <?php if($category === '2') { print 'selected'; } ?>>休憩</option>
          <option value = "3" <?php if($category === '3') { print 'selected'; } ?>>ご飯</option>
        </select>
        <input type="hidden" name="sql_kind" value="category">
        <input type="submit" value="送信">
      </form>
    <div id="map_box"></div>
      
    <div id="message">
      <?php foreach ($errors as $error) { ?>
      <p><?php print h($error); ?></p>
      <?php } ?>
      <?php foreach ($messages as $message) { ?>
      <p><?php print h($message); ?></p>
      <?php } ?>
    </div>
    
    <div id="added">
      <ul>
        <?php foreach ($list_items as $list_item) { ?>
        <li><?php print h($list_item['place_name']); ?></li>
        <?php } ?>
      </ul>
    </div>
    </section>
    <section id="sidebar">
      
    <!--  <p id="sidebar_list_name">リスト名：<?php print h($route_table[0]['route_name']); ?></p>-->
    <!--  <form>-->
    <!--  <a href="../user_page.php">投稿者：<?php print h($route_table[0]['user_id']); ?></a>-->
    <!--  <input type="hidden" name="use_id" value="<?php print h($route_table[0]['user_id']); ?>">-->
    <!--  </form>-->
      
    <!--  <div class="side_item">-->
    <!--  <?php foreach ($list_items as $list_item) { ?>-->
    <!--  <p></p><?php print h($list_item['place_name']); ?>-->
    <!--  <label>URL：<a href="<?php print h($list_item['url']); ?>"><?php print h($list_item['url']); ?></a></label></p>-->
    <!--  <img src="../images/<?php print h($list_item['img']); ?>" class="side_img">-->
    <!--  <p>コメント：<?php print h($list_item['comment']); ?></p>-->
    <!--  <?php } ?>-->
    <!--  </div>-->
      
      <table class="side_item">
        <?php foreach ($list_items as $list_item) { ?>
        <tr>
          <td id="place_name"><?php print h($list_item['place_name']); ?></td>
          <td>URL：<a href="<?php print h($list_item['url']); ?>"><?php print h($list_item['url']); ?></a></label></td>
        </tr>
        <tr>
          <td><img src="<?php print "../images/" . h($list_item['img']); ?>" class="side_img"></td>
          <td>コメント：<?php print h($list_item['comment']); ?></td>
        </tr>
        <?php } ?>
      </table>
    </section>
    </div>

    <script>
      function init(){
        var kichijoji = {
                    lat: 35.7031754,
                    lng: 139.5713603
                };
        //$itemsをjs形式で呼び出し
        var items = JSON.parse('<?php echo $items_json; ?>');
        console.log(items);
        //map_box要素を取得
        var map_box = document.getElementById('map_box');
        //mapを表示
        var map = new google.maps.Map(
          map_box,
          {
            center: kichijoji,
            zoom: 12,
            disableDefaultUI: true,
            zoomControl: true,
            clickableIcons: false,
          }
        );
        
        //post_place_tableの数だけマーカーを立てる
        var markers = [];
        for (var i = 0; i < items.length; i++) {
                
          var place_name = items[i]["place_name"];
          var place_id = items[i]["place_id"];
          
          //マーカーを立てる letは{}の中のみ有効　ブロックスコープ
          let marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(items[i]["lat"],items[i]["lng"])
          });
          
          //インフォメーションウィンドウの表示
          let infoWindow = new google.maps.InfoWindow({
            content: postForm(items[i])
          });
            
          // var div_id = getElementById('form');
          // div_id = postForm(place_id);
            
          //マーカーにイベントを追加
          marker.addListener('click', function() {
            infoWindow.open(map, marker);
          });
        
          //マーカーを配列にpushして代入
          markers.push(marker);
        }
        
        function postForm(item) {
                      
            //要素を作成
            var form = document.createElement('form');
            var request = document.createElement('input');
            var hidden = document.createElement('input');
            var div = document.createElement('div');
            var img = document.createElement('img');
            var p = document.createElement('p');
            
            img.src = '../images/' + item['img'];
            img.className = 'icon';
            
            p.innerHTML = item['place_name'];
            
            //メソッド、パスを指定
            form.method = 'POST';
            //form.action = 'aatest.php';
            
            //タイプ等を指定
            request.type = 'submit';
            request.value = 'リストに追加';
            
            hidden.type = 'hidden';
            hidden.name = 'place_id';
            hidden.value = item['place_id'];
            
            //要素に要素を追加
            form.appendChild(request);
            form.appendChild(hidden);
            div.appendChild(p);
            div.appendChild(img);
            div.appendChild(form);
            return div;
        }
  }
    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>

</body>
</html>
