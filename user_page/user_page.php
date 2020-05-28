<?php

require_once '../model/user_page_func.php';
require_once '../conf/const.php';


session_start();
if(isset($_SESSION['user_id']) === false){
    redirect_to('login.php');
}
$user_id = $_SESSION['user_id'];

// JOINでつなげたテーブルの情報を表示
// db接続
$link = get_db_connect();

$list_items = get_list($link);
// js形式に変換
$list_items_json = json_encode($list_items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
//var_dump($list_items);

//ユーザー情報取得
$user_info = get_user_info($link, $user_id);
//これまでポストしたプレイスデータ取得
$places = get_post_place($link, $user_id);
//ルート情報の取得
$route_list = get_route_info($link, $user_id);
//ポストで選択されたルートID
if (is_post() === TRUE) {
    $route_id = get_post_data('route_id');
    dd($_POST);
}

$places_json = json_encode($places, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

close_db_connect($link);


include_once '../view/user_page_view.php';