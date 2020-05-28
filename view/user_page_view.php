<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ユーザーページ</title>
    <style type="text/css">

        h1 {
            width: 800px;
            border-bottom: solid;
        }
        h2 {
            font-size: 20px;
        }

        .header {
            display: flex;
            vertical-align: middle;
        }
        .place {
            display: flex;
        }
        #list {
            width: 800px;
            height: 600px;
            border: solid 1px;
        }
        #map_box {
            width: 800px;
            height: 600px;
        }
        img {
            width: 200px;
        }

    </style>
</head>
<body>
    <div class="header">
        <h1 class="header">Pinto Travel</h1>
        <p class="header">ユーザー名：<?php print h($user_info['user_name']); ?></p>
    </div>
    <div id="map_box"></div>
    <div id="list">
            <?php foreach ($places as $place) { ?>
                <p><?php print h($place['place_name']); ?></p>
                <img src="<?php print '../image/' . h($place['img']); ?>">
            <?php } ?>
        </div>
    </div>
    <div class="route">
    <h2>ルート</h2>
        <form method="post" action="../route/route.php">
            <select name="route_id">
            <?php foreach ($route_list as $route) { ?>
                <option value="<?php print h($route['route_id']); ?>"><?php print h($route['route_name']); ?></option>
            <?php } ?>
            </select>
            <input type="submit" value="search">

        </form>
    </div>
    <!-- 上で設定した（入力した）API_KEYをここで出力し、init（イニシャライズ：何かの立ち上げに使われる）関数を実行 -->
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>

    <script>
      function init(){
        // $list_itemsを呼び出し
        var list_items = JSON.parse('<?php echo $list_items_json; ?>');
        
        // map_boxで上のdivを受け取る
        var map_box = document.getElementById('map_box');
        // var mapにマップを表示させる
        var map = new google.maps.Map(
          map_box, // 第１引数はマップ表示対象の要素。
          {
            // 第２引数で各種オプションを設定
            center: new google.maps.LatLng(list_items[0]["lat"], list_items[0]["lng"]), // 地図の中心
            zoom: 10, // 拡大のレベルを15に。（1 - 18くらい）
            disableDefaultUI: true, // 各種UIをOFFに
            zoomControl: true, // 拡大縮小だけできるように
            clickableIcons: false, // クリック関連の機能をoffに。
          }
        )
         
        var markers = [];
        for (var list_item of list_items) {
            var marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(list_item["lat"], list_item["lng"])
            });
        }
        
        markers.push(marker);
      }
    </script>
</body>
</html>