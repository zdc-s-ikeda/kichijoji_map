<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイルート</title>
    <style>
      body {
        color: #6b6b6b;
        padding: 20px;
      }
      #map_box {
        width: 500px;
        height: 500px;
      }
      #map_bottom li {
        display: inline;
      }
      .icon {
        width: 70px;
        height: 70px;
      }
      #place_order {
        width: 30px;
      }
      table {
      border-collapse: collapse;
      text-align: center;
      }
      table th, table td {
      border: solid 1px #0fabbc;
      padding: 5px;
      }
      .post_place_list_button {
        background-color: #ffffff;
        border-radius: 30px;
      }
      .display {
        background-color: #ffffff;
        border-radius: 30px;
      }
      #sidebar {
        color: #ffffff;
        background-color: #0fabbc;
        width: 200px;
        height: 650px;
        float: right;
      }
      #sidebar_list {
        font-weight: bold;
        text-align: center;
      }
      #logo {
        width: 20%;
      }

    </style>
</head>
<body>
    <label><img id="logo" src="../view/logo.png"></label>
    <div id="map_bottom">
    <li><a href="../top/top.php"><img class="icon" src="../view/home.png" alt="ホーム"></a></li>
    <li><a href="../mypage/mypage.php"><img class="icon" src="../view/mypage.png" alt="ホーム"></a></li>
    <li><a href="../route/route.php"><img class="icon" src="../view/myroute.png" alt="マイルート"></a></li>
    <li><a href="../post/post.php"><img class="icon" src="../view/post.png" alt="投稿"></a></li>
    </div>
    
    
    <h2>一覧</h2>
      <?php if(count($post_place_list) > 0){ ?>
        <table>
            <thead>
                <tr>
                    <th>場所名</th>
                    <th>コメント</th>
                    <th>表示</th>
                    <th>順番</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($post_place_list as $place){ ?>
                    <tr>
                        <td><a href="<?php echo h($place['url']); ?>"><?php echo h($place['place_name']); ?></a></td>
                        <td><?php echo h($place['comment']); ?></td>
                        <td>
                            <button
                                class="display"
                                data-lat="<?php echo h($place['lat']);?>"
                                data-lng="<?php echo h($place['lng']);?>"
                                data-name="<?php echo h($place['place_name']); ?>">
                                表示
                            </button>
                        </td>
                        <td>
                          <form method="post" action="../route/place_order.php">
                            <div>
                              <input id="place_order" type="number" name="place_order" value="<?php echo h($place['place_order']); ?>">
                              <input type="hidden" name="place_id" value="<?php echo h($place['place_id']); ?>">
                              <input class="post_place_list_button" type="submit" value="変更">
                            </div>
                          </form>
                        </td>
                        <td>
                          <form method="post" action="../route/place_list_delete.php">
                            <input type="hidden" name="place_id" value="<?php echo h($place['place_id']); ?>">
                            <input class="post_place_list_button" type="submit" value="削除">
                          </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>登録された場所はありません。</p>
    <?php } ?>
    </form>
    
    <p id="search_result"></p>
    <div id="map_box"></div>
    
    <script>
      function init(){
        var place_list = JSON.parse('<?php echo $place_list_json; ?>');
        var map_box = document.getElementById('map_box');
        var map = new google.maps.Map(
          map_box,
          {
            center: new google.maps.LatLng(place_list[0]["lat"],place_list[0]["lng"]),
            zoom: 15,
            disableDefaultUI: true,
            zoomControl: true,
            clickableIcons: false,
          }
        );
        var display_buttons = Array.from(document.getElementsByClassName('display'));
        //各ボタンにイベントを設定
        display_buttons.forEach(
          function(display_button){
            display_button.addEventListener(
              'click',
              function(){
                map.panTo(new google.maps.LatLng(display_button.dataset.lat,display_button.dataset.lng)); // スムーズに移動
              }
            );
          }
        );
       
        if(place_list.length === 1){
          var marker = new google.maps.Marker({
              position: new google.maps.LatLng(place_list[0]["lat"],place_list[0]["lng"]), // クリックした箇所
              map: map,
              animation: google.maps.Animation.DROP
            });
        }else if(place_list.length === 2){
          var request = {
            origin: new google.maps.LatLng(place_list[0]["lat"],place_list[0]["lng"]),
            destination: new google.maps.LatLng(place_list[place_list.length - 1]["lat"],place_list[place_list.length - 1]["lng"]),
            travelMode: google.maps.DirectionsTravelMode.WALKING, // 交通手段(歩行。DRIVINGの場合は車)
          };
          var d = new google.maps.DirectionsService(); // ルート検索オブジェクト
          var r = new google.maps.DirectionsRenderer({ // ルート描画オブジェクト
                  map: map, // 描画先の地図
                  preserveViewport: true, // 描画後に中心点をずらさない
                  })
          d.route(request, function(result, status){
              // OKの場合ルート描画
              if (status == google.maps.DirectionsStatus.OK) {
                  r.setDirections(result);
              }
          }); 
        }else if(place_list.length > 2){
          var waypoints = []
          for(var i = 1; i < (place_list.length - 1); i++){  
            waypoints.push({ location: new google.maps.LatLng(place_list[i]["lat"],place_list[i]["lng"])})
            }
        var request = {
          origin: new google.maps.LatLng(place_list[0]["lat"],place_list[0]["lng"]),
          destination: new google.maps.LatLng(place_list[place_list.length - 1]["lat"],place_list[place_list.length - 1]["lng"]),
          waypoints: waypoints,
          travelMode: google.maps.DirectionsTravelMode.WALKING, // 交通手段(歩行。DRIVINGの場合は車)
          };
          var d = new google.maps.DirectionsService(); // ルート検索オブジェクト
          var r = new google.maps.DirectionsRenderer({ // ルート描画オブジェクト
                  map: map, // 描画先の地図
                  preserveViewport: true, // 描画後に中心点をずらさない
                  })
          d.route(request, function(result, status){
              // OKの場合ルート描画
              if (status == google.maps.DirectionsStatus.OK) {
                  r.setDirections(result);
              }
          });
        }
      }
    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>
</body>
</html>
