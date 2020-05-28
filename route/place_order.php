<?php
require_once '../conf/const.php';
require_once '../model/route_func.php';

session_start();
if(isset($_SESSION['user_id']) === false){
    redirect_to('../login/login.php');
}
$user_id = $_SESSION['user_id'];


if(is_post() === true){

    $place_id = get_post('place_id');
    $place_order = get_post('place_order');
    if($place_id !== ''){
        $link = get_db_connect();
        $old_place_order = select_place_order($place_id, $link);
        if(update_place($place_id, $place_order, $link) === false){
            close_db_connect($link);
            exit('順番の更新に失敗しました。');
        }
        if($old_place_order['place_order'] > $place_order){
            if(update_place_orders_down($place_id, $place_order, $old_place_order['place_order'], $user_id, $link) === false){
                close_db_connect($link);
                exit('順番の更新に失敗しました。');
            }
        }
        if($old_place_order['place_order'] < $place_order){
            if(update_place_orders_up($place_id, $place_order, $old_place_order['place_order'], $user_id, $link) === false){
                close_db_connect($link);
                exit('順番の更新に失敗しました。');
            }
        }
        close_db_connect($link);
    }
}


redirect_to('route.php');