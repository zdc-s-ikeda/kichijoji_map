<?php

require_once '../model/function.php';
require_once '../conf/const.php';

$errors = [];
$messages = [];

//セッションでuser_idとってくる
session_start();
if(isset($_SESSION['user_id']) === false){
    redirect_to('../login/login.php');
}
$user_id = $_SESSION['user_id'];

//db接続
$link = get_db_connect();

//user_name取得
$user_info = get_user_info($link, $user_id);

//カテゴリの取得
$category = get_category($link);
//リストに格納されたアイテムの表示
$list_items = get_list($link, $user_id);

$list_items_json = json_encode($list_items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

//post_places_tableの情報取得
//$items = get_post_places($link);
//$itemsをjs形式に変換(itemsには、name, comment, imgが一つずつ入っている)
//$items_json = json_encode($items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);


//db切断
close_db_connect($link);


//postされてきた値をリストに追加
if (is_post() === TRUE) {
    
    //値を受け取り
    $place_id = get_post('place_id');
    $place_order = get_post('place_order');
    
    //db接続
    $link = get_db_connect();
    
    //リストに場所を追加
    $result = insert_to_place_list_table($link, $place_id, $place_order, $user_id);
    
    if ($result === FALSE) {
        $errors[] = 'リストに追加失敗';
    } else {
        $messages[] = 'リストに追加成功';
    }
    
    
    //db切断
    close_db_connect($link);
}


include_once '../view/mypage_view.php';