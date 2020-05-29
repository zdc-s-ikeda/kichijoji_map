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

//post_places_tableの値を$itemsに格納
$items = get_post_place($user_id, $link);

$category = '';
$sql_kind = '';
if (is_post() === TRUE) {
    $sql_kind = get_post('sql_kind');
    if($sql_kind === 'category'){
        $category = get_post('category');
        if($category === '1' || $category === '2' || $category === '3'){
            $items = get_category($category, $user_id, $link);
        }else{
            $items = get_post_place($user_id, $link);
        }
    }else{
            //ポストされた場所を追加
        $place_id = get_post('place_id');
        
        //db接続
        $link = get_db_connect();
        
        //ルートリストに場所を追加
        $result = insert_to_place_list_table($link, $place_id, $user_id);
        
        if ($result === FALSE) {
            $errors[] = 'リストに追加失敗';
        } else {
            $messages[] = 'リストに追加成功';
        }
        $items = get_list($user_id, $link);
    }
} else {
    $items = get_post_place($user_id, $link);
    var_dump($items);

}
//$itemsをjs形式に変換(itemsには、name, comment, imgが一つずつ入っている)
$items_json = json_encode($items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);


//自分のplace_list_tableリストに格納されたアイテムの表示
$list_items = get_list($user_id, $link);
close_db_connect($link);

$list_items_json = json_encode($list_items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

//post_places_tableの情報取得
//$items = get_post_places($link);
//$itemsをjs形式に変換(itemsには、name, comment, imgが一つずつ入っている)
//$items_json = json_encode($items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);





include_once '../view/mypage_view.php';