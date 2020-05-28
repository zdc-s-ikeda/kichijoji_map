<?php

function get_request_method() {
   return $_SERVER['REQUEST_METHOD'];
}
function is_post() {
    return get_request_method() === 'POST';
}
function h($value) {
     return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
 }
//postされた値を受け取る
function get_post($key) {
    if (isset($_POST[$key]) === TRUE) {
        return trim($_POST[$key]);
    }
}
//db系
 //db接続
function get_db_connect() {
     if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
         die('error: '. mysqli_connect_error());
     }
     //文字コードセット
     mysqli_set_charset($link, DB_CHARACTER_SET);
     return $link;
 }
 
 //db接続解除
 //データベース接続を解除する
 function close_db_connect($link) {
     mysqli_close($link);
 }
 
 //クエリの実行、結果を配列で取得
 function get_as_array($link, $sql) {
     //返却用配列
     $messages = [];
     //クエリを実行する
     if ($result = mysqli_query($link, $sql)) {
         if (mysqli_num_rows($result) > 0) {
             //1件ずつ取り出す
             while ($row = mysqli_fetch_assoc($result)) {
                 $messages[] =$row;
             }
         }
         mysqli_free_result($result);
     }
     return $messages;
 }
 
 //クエリの実行、結果を行で取得
 function get_as_row($link, $sql) {
     $result = do_query($link, $sql);
     if ($result !== FALSE) {
         $row = mysqli_fetch_assoc($result);
         mysqli_free_result($result);
         return $row;
     }
 }
 
 //クエリ実行
 function do_query($link, $sql) {
     $result = mysqli_query($link, $sql);
     if ($result === FALSE) {
         var_dump('sql失敗' . $sql);
     }
     return $result;
 }

//
//mypage.php
//

//post_places_tableを表示
function get_post_places($link) {
    $sql = "
        SELECT
            *
        FROM
            post_place_table
        ";
    return get_as_array($link, $sql);
}

function insert_to_place_list_table($link, $place_id, $place_order, $route_id) {
    $log = date('Y-m-d h:i:s');
    $sql ="
        INSERT INTO
            place_list_table
            (user_id, 
            place_id, 
            place_order,
            created_date,
            updated_date)
        VALUES(
            '{$user_id}',
            '{$place_id}',
            '{$place_order}',
            '{$log}',
            '{$log}')
        ";
        return do_query($link, $sql);
}

function get_list($link, $user_id) {
    $sql = "
            SELECT
                place_name, comment, img, url
            FROM
                place_list_table
            JOIN
                post_place_table
            ON
                place_list_table.place_id = post_place_table.place_id
            WHERE
                place_list_table.user_id= '{$user_id}'
            
            "; 
    $list_items = get_as_array($link, $sql);
    dd($sql);
    return $list_items;
}

function get_route_table($route_id, $link) {
    $sql = "
            SELECT
                route_name, user_id
            FROM
                route_table
            WHERE
                route_id = '{$route_id}'
            ";
    $result =  get_as_array($link, $sql);
    return $result;
    
}

function get_side_items($route_id, $link) {
    $sql = "
            SELECT
                place_name, img, comment, url
            FROM
                route_table
            JOIN
                place_list_table
            ON
                route_table.route_id = place_list_table.route_id
            JOIN
                post_place_table
            ON
                place_list_table.place_id = post_place_table.place_id
            WHERE
                route_table.route_id = '{$route_id}'
            ";
    return get_as_array($link, $sql);
}

function redirect_to($url){
    header('Location: ' . $url);
    exit;
}

function get_user_info($link, $user_id) {
    $sql = "
            SELECT
                *
            FROM
                users_table
            WHERE
                user_id = '{$user_id}'
            ";
    return get_as_row($link, $sql);
}

function dd($var) {
    return var_dump($var);
}

