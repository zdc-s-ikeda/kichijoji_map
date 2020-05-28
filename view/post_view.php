<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>投稿画面</title>
    <style type="text/css">

      #map { 
        width: 800px;
        height: 600px;
      }
      #post {
        background-color: #CCFFFF;
        width: 800px;
      }
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
      #logo {
        width: 20%;
      }
    </style>

    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>
    <script type="text/javascript">
    //<![CDATA[

    var map;
    
    // 初期化。bodyのonloadでinit()を指定することで呼び出してます
    function init() {

      // Google Mapで利用する初期設定用の変数
      var latlng = new google.maps.LatLng(35.702969, 139.579765);
      var opts = {
        zoom: 15,
        center: latlng,
        disableDefaultUI: true,
        zoomControl: true,
        clickableIcons: false,
      };

      // getElementById("map")の"map"は、body内の<div id="map">より
      map = new google.maps.Map(document.getElementById("map"), opts);

      google.maps.event.addListener(map, 'click', mylistener);
      
        
                // ジオコーダーの生成
        var geocoder = new google.maps.Geocoder();
        document.getElementById('search')
        .addEventListener(
        'click',
        function(){
              geocoder.geocode(
                // 第一引数にジオコーディングのオプションを設定
                {
                  address: document.getElementById('address').value
                },
                // 第二引数に結果取得時の動作を設定
                function(results, status){
                  // 失敗時の処理
                  if(status !== 'OK'){
                    alert('ジオコーディングに失敗しました。結果: ' + status);
                    return;
                  }
                  // 成功した場合、resultsの0番目に結果が取得される。
                  if(!results[0]){
                    alert('結果が取得できませんでした');
                    return;
                  }
                  // マップの中心を移動
                  //スクロールする
                  map.panTo(results[0].geometry.location);
                  
                //formatted_address 書式が整えられた住所の情報
                  document.getElementById('search_result').innerHTML = results[0].formatted_address;
                }
              );
            }
          );
          
          
          // クリック位置をリバースジオコーディング
            map.addListener('click', function(e){
              geocoder.geocode({
                location: e.latLng
              }, function(results, status){
                if(status !== 'OK'){
                  alert('リバースジオコーディングに失敗しました。結果: ' + status);
                  return;
                }
            
                // console.log(results);
                if(!results[0]){
                  alert('結果が取得できませんでした。');
                  return;
                }
            
                // クリックした位置にマーカーを立てる
                    var added_marker = new google.maps.Marker({
                      position: e.latLng, // クリックした箇所
                      map: map,
                      animation: google.maps.Animation.BOUNCE,
                      title: results[0].formatted_address
                    });
               
                
                
                //document.getElementById('searched_address').value = results[0].formated...
                //マーカークリックでマーカー、緯度経度削除
                added_marker.addListener('click', function(e){
                    this.setMap(null);
                    document.getElementById("show_lat").innerHTML = null;
                    document.getElementById("show_lng").innerHTML = null;
                    document.getElementById("show_lat").value = null;
                    document.getElementById("show_lng").value = null;
                });
              })
            });

    }

    function mylistener(event) {
      document.getElementById("show_lat").innerHTML = event.latLng.lat();
      document.getElementById("show_lng").innerHTML = event.latLng.lng();
      document.getElementById("lat").value = event.latLng.lat();
      document.getElementById("lng").value = event.latLng.lng();
      console.log(show_lat);
    }

    </script>
  </head>

  <body onload="init()">
    <header>
      <label><img id="logo" src="../view/logo.png"></label>
      <ul class="list">
        <li><a href="../top/top.php"><img class="icon" src="../view/home.png" alt="ホーム"></a></li>
        <li><a href="../mypage/mypage.php"><img class="icon" src="../view/mypage.png" alt="マイページ"></a></li>
        <li><a href="../route/route.php"><img class="icon" src="../view/myroute.png" alt="マイルート"></a></li>
        <li><a href="../post/post.php"><img class="icon" src="../view/post.png" alt="投稿"></a></li>
      </ul>
    </header>
    <div id="post">
      <form action="../post/post_result.php" method="post" enctype="multipart/form-data">
          <p><input type="text" name="place_name" placeholder="地名"><br>
          <p><textarea name="comment" rows="5" cols="40" placeholder="文章を入力(営業時間など)"></textarea><br>
          <p><input type="text" name="url" placeholder="URL"><br>
          <p><input type="text" name="cayegory" placeholder="1:遊び,2:休む,3:食べる"></p>
          <table>
            <tr><th>緯度</th><td id="show_lat"></td></tr>
            <tr><th>経度</th><td id="show_lng"></td></tr>
          </table>
          <input type="file" name="img">
          <p><input type="submit" value="投稿"></p>
          <input type="hidden" name="lat" id="lat" value="">
          <input type="hidden" name="lng" id="lng" value="">
      </form>
    </div>
    <p>
      <input type="text" id="address" placeholder="場所名や住所">
      <button id="search">検索</button>
    </p>
    <p id="search_result"></p>
    <div id="map" style="height:560px"></div>
  </body>

</html>