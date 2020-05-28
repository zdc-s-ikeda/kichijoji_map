<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>pin_to_travel top</title>
        <style>
            img {
                width: 100px;
                height: 100px;
            }
            p {
        word-wrap: break-word;
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
        <!--ヘッダー-->
        <section id="header">
          <label><img id="logo" src="../view/logo.png"></label>
          <div id="map_bottom">
            <li><a href="../top/top.php"><img class="icon" src="../view/home.png" alt="ホーム"></a></li>
            <li><a href="../mypage/mypage.php"><img class="icon" src="../view/mypage.png" alt="ホーム"></a></li>
            <li><a href="../route/route.php"><img class="icon" src="../view/myroute.png" alt="マイルート"></a></li>
            <li><a href="../post/post.php"><img class="icon" src="../view/post.png" alt="投稿"></a></li>
        </div>
        </section>
        
        <section id="main">
                <?php 
                $i = 0;
                foreach ($items as $item) { ?>
                    <!--<div style="background-image url:('../images/'<?php print h($imgs[$i]['img']); ?>)">-->
                    <tr>
                    <th>
                    <h1>おすすめルート</h1>
                    <form>
                        <p>リスト名：<?php print h($item['route_name']); ?></p>
                        <input type="hidden" name="route_id" value="<?php print h($item['route_id']); ?>">
                        <input type="submit" value="ルートを表示">
                    </form>
                     <form>
                        <p>ユーザー名：<?php print h($item['user_name']); ?></p>
                        <input type="hidden" name="user_id" value="<?php print h($item['user_id']); ?>">
                        <input type="submit" value="ユーザーページを表示">
                    </form>
                    </th>
                    </tr>
                    
                    <tr>
                    <td>
                        <img src="../images/<?php print h($imgs[$i]['img']); ?>">
                    </td>
                    </tr>
                    </div>
                <?php 
                $i ++; } ?>
                
                
            </table>
        </section>
        
        
    </body>
</html>