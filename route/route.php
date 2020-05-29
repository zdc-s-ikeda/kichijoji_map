<?php
require_once '../conf/const.php';
require_once '../model/route_func.php';

session_start();
if(isset($_SESSION['user_id']) === false){
    redirect_to('login.php');
}
$user_id = $_SESSION['user_id'];


$place_list = [];
$post_place_list = [];
$link = get_db_connect();
$errors = [];

$post_place_list = select_place_list($user_id, $link);
if(empty($post_place_list) === TRUE){
    $errors[] = 'place_list_table取得失敗';
}
$place_list_json = json_encode($post_place_list, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
$place_list_json = str_replace('\r\n', '<br>', $place_list_json);
$place_list_json = str_replace('\n', '<br>', $place_list_json);
$place_list_json = str_replace('　', '', $place_list_json);
$place_list_json = str_replace('\t', '', $place_list_json);

close_db_connect($link);


include_once '../view/route_view.php';
