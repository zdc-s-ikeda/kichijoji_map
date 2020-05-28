<?php
require_once '../conf/const.php';
require_once '../model/route_func.php';

session_start();
if(isset($_SESSION['user_id']) === false){
    redirect_to('login.php');
}
$user_id = $_SESSION['user_id'];


$route_id = 1;
$place_list = [];
$post_place_list = [];
$link = get_db_connect();
$errors = [];

if (is_post() === TRUE) {
    $route_id = get_post('route_id');
}
// $place_list = select_route($route_id, $link);
// if(empty($place_list) === TRUE){
//     $errors[] = 'route_table取得失敗';
// }
$post_place_list = select_place_list($route_id, $link);
if(empty($post_place_list) === TRUE){
    $errors[] = 'place_list_table取得失敗';
}

$place_list_json = json_encode($post_place_list, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

close_db_connect($link);


include_once '../view/route_view.php';
