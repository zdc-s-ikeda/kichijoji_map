<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
    <style>
      
      body {
         color: #6b6b6b;
         padding: 40px;
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
        width: 100%;
      }
      #header_li li {
        display: inline;
      }
      #main {
        display: flex;
      }
      .icon {
        width: 100px;
      }
      #center {
        flex: 1;
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
        background-color: #0fabbc;
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
        width: 20%;
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
    <li><a href="../top/top.php"><img class="icon" src="../view/home.png" alt="ホーム"></a></li>
    <li><a href="../mypage/mypage.php"><img class="icon" src="../view/mypage.png" alt="ホーム"></a></li>
    <li><a href="../route/route.php"><img class="icon" src="../view/myroute.png" alt="マイルート"></a></li>
    <li><a href="../post/post.php"><img class="icon" src="../view/post.png" alt="投稿"></a></li>
    </div>
    </section>
    
    <div id="main">
    <section id="center">
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

    <div id="add">
      <label id="add_top_comment">行きたい場所をリストに追加</laber><br>
      <?php foreach ($items as $item) { ?>
        <form method="post" action="mypage.php">
          <label id="place_name"><?php print h($item['place_name']) ?></label><br>
          <label>　順番：<input id="place_order" type="text" name="place_order"></label>
          <input type="hidden" name="place_id" value="<?php print h($item['place_id']); ?>">
          <input id="list_add_button" type="submit" value="リストに追加"><br>
          </label>
        </form>
      <?php } ?>
    </div>
    
    <section id="sidebar">
      
      <p id="sidebar_list_name">リスト名：<?php print h($route_table[0]['route_name']); ?></p>
      <form>
      <a href="../user_page.php">投稿者：<?php print h($route_table[0]['user_id']); ?></a>
      <input type="hidden" name="use_id" value="<?php print h($route_table[0]['user_id']); ?>">
      </form>
      
      <!--<div class="side_item">-->
      <!--<?php foreach ($side_items as $side_item) { ?>-->
      <!--<p></p><?php print h($side_item['place_name']); ?>-->
      <!--<label>URL：<a href="<?php print h($side_item['url']); ?>"><?php print h($side_item['url']); ?></a></label></p>-->
      <!--<img src="../images/<?php print h($side_item['img']); ?>" class="side_img">-->
      <!--<p>コメント：<?php print h($side_item['comment']); ?></p>-->
      <!--<?php } ?>-->
      <!--</div>-->
      
      <table class="side_item">
        <?php foreach ($side_items as $side_item) { ?>
        <tr>
          <td id="place_name"><?php print h($side_item['place_name']); ?></td>
          <td>URL：<a href="<?php print h($side_item['url']); ?>"><?php print h($side_item['url']); ?></a></label></td>
        </tr>
        <tr>
          <td><img src="../images/<?php print h($side_item['img']); ?>" class="side_img"></td>
          <td>コメント：<?php print h($side_item['comment']); ?></td>
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
        for (var item of items) {
              
        var i = 0;
        
        //マーカーを立てる
        var added_marker = new google.maps.Marker({
          map: map,
          position: new google.maps.LatLng(item["lat"],item["lng"])
          });
        
        //インフォメーションウィンドウの表示
        var infoWindow = new google.maps.InfoWindow({
          content: item["place_name"]
          });
          
        added_marker.addListener('click', 
        function () {
          infoWindow.open(map, this);
        });
        
        var place_name = item["place_name"];
        var place_id = item["place_id"];
        
        function postForm(place_name, place_id) {
                    
                    //要素を作成
                    var form = document.createElement('form');
                    var request = document.createElement('input');
                    var hidden = document.createElement('input');
                    
                    //メソッド、パスを指定
                    form.method = 'POST';
                    //form.action = 'aatest.php';
                    
                    //タイプ等を指定
                    request.type = 'submit';
                    request.value = place_name;
                    
                    hidden.type = 'hidden';
                    hidden.name = 'place_id';
                    hidden.value = place_id;
                    
                    //要素に要素を追加
                    form.appendChild(request);
                    form.appendChild(hidden);
                    return form;
                }
        infoWindow.setContent(postForm(place_name, place_id));
        
        //マーカーを配列にpushして代入
        markers.push(added_marker);
      }
  }
    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>

</body>
</html>
