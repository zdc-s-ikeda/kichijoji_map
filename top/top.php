<?php
require_once '../conf/const.php';
require_once '../model/function.php';
require_once '../model/top_function.php';


$link = get_db_connect();

//おすすめ一覧の取得
$items = get_favarite_route($link);

//favorite routeのidを取得
$id_item = [];
foreach ($items as $item) {
    $id_item[] = $item['route_id'];
}

$imgs = [];
foreach ($id_item as $route_id) {
    $img = get_img($link, $route_id);
    
    $imgs[] = $img[0];
}

close_db_connect($link);


include_once '../view/top_view.php';