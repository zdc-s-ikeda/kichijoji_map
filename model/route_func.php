<?php

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

//DBハンドル取得
function get_db_connect() {
 
    // コネクション取得
    if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
        die('error: ' . mysqli_connect_error());
    }
 
    // 文字コードセット
    mysqli_set_charset($link, DB_CHARACTER_SET);
 
    return $link;
}

//直前のクエリで生成したIDを取得
function close_db_connect($link) {
    // 接続を閉じる
    mysqli_close($link);
}

//queryの実行
function result_query($link, $sql){
    return mysqli_query($link, $sql);
}

//クエリを実行しその結果を配列で取得する
function get_as_array($link, $sql){
    // 返却用配列
    $data = [];
    // クエリを実行する
    if ($result = mysqli_query($link, $sql)) {
        // １件ずつ取り出す
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        // 結果セットを開放
        mysqli_free_result($result);
    }
    return $data;
}

//クエリを実行しその結果を配列(1行)で取得する
function get_as_row($link, $sql){
    if($result = mysqli_query($link, $sql)){
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $row;
    }
    return [];
}

//変数確認
function dd($var){
  var_dump($var);
  exit();
}

//route_table select
function select_route($route_id,$link){
    $sql = "SELECT
                lat,
                lng,
                route_order
            FROM
                route_table
            WHERE
                route_id = '{$route_id}'
            ORDER BY 
                route_order";
    return get_as_array($link, $sql);
    
}

//place_list_table select
function select_place_list($user_id, $link){
    $sql = "SELECT
                place_name,
                comment,
                img,
                status,
                lat,
                lng,
                url,
                category,
                place_list_table.place_id,
                place_order
            FROM
                place_list_table
            JOIN
                post_place_table
            ON
                place_list_table.place_id = post_place_table.place_id
            WHERE
                place_list_table.user_id = '{$user_id}'
            ORDER BY
                place_order";
    return get_as_array($link, $sql);
}

function delete_place($place_id, $user_id, $link){
    $sql = "DELETE FROM
                place_list_table
            WHERE
                place_id = '{$place_id}'
            AND
                user_id = '{$user_id}'";
    return result_query($link, $sql);
}

function select_place_order($place_id, $link){
    $sql = "SELECT
                place_order
            FROM
                place_list_table
            WHERE
                place_id = '{$place_id}'";
    return get_as_row($link, $sql);
}
function update_place($place_id, $place_order, $link){
    $sql = "UPDATE
                place_list_table
            SET
                place_order = '{$place_order}'
            WHERE
                place_id = '{$place_id}'";
    return result_query($link, $sql);
}

function update_place_orders_down($place_id, $place_order, $old_place_order, $user_id, $link){
    $sql = "UPDATE
                place_list_table
            SET
                place_order = place_order + 1
            WHERE
                place_order >= '{$place_order}'
            AND
                place_order < '{$old_place_order}'
            AND
                place_id != '{$place_id}'
            AND
                user_id = '{$user_id}'";
    return result_query($link, $sql);
}
function update_place_orders_up($place_id, $place_order, $old_place_order, $user_id, $link){
    $sql = "UPDATE
                place_list_table
            SET
                place_order = place_order - 1
            WHERE
                place_order > '{$old_place_order}'
            AND
                place_order <= '{$place_order}'
            AND
                place_id != '{$place_id}'
            AND
                user_id = '{$user_id}'";
    return result_query($link, $sql);
}

function is_blank($value){
    return $value === '';
}

function get_post($name){
    if (isset($_POST[$name]) === TRUE){
        return trim($_POST[$name]);
    }
    return '';
}

function redirect_to($url){
    header('Location: ' . $url);
    exit;
}

function get_request_method() {
   return $_SERVER['REQUEST_METHOD'];
}

function is_post(){
    return get_request_method() === 'POST';
}

function set_time(){
    return date('Y-m-d H:i:s');
}

function is_category($value){
    return preg_match('/[123]/', $value) === 1;
}