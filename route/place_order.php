<?php
require_once '../conf/const.php';
require_once '../model/route_func.php';



if(is_post() === true){

    $place_id = get_post('place_id');
    $place_order = get_post('place_order');

    if($place_id !== ''){
        $link = get_db_connect();
        if(update_place($place_id, $place_order, $link) === false){
            close_db_connect($link);
            exit('順番の更新に失敗しました。');
        }
        close_db_connect($link);
    }
}


redirect_to('route.php');