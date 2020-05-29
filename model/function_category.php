<?php

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}
function get_request_method() {
   return $_SERVER['REQUEST_METHOD'];
}
function is_post() {
    return get_request_method() === 'POST';
}
//postされた値を受け取る
function get_post($key) {
    if (isset($_POST[$key]) === TRUE) {
        return trim($_POST[$key]);
    }
}

function get_db_connect() {
    // コネクション取得
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
    if ($link === false) {
        die('error: ' . mysqli_connect_error());
    }
    // 文字コードセット
    mysqli_set_charset($link, DB_CHARACTER_SET);
    return $link;
}

function close_db_connect($link) {
    // 接続を閉じる
    mysqli_close($link);
}

function get_as_array($link, $sql) {

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

function get_as_row($link, $sql) {
    if ($result = mysqli_query($link, $sql)) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $row;
    }
    // return [];
}

function execute_query($link, $sql){
    $result = mysqli_query($link, $sql);
    if ($result === FALSE) {
        var_dump('sql失敗' . $sql);
    }
    return $result;
}

// 全部のものをJOINでもってくる
function get_list($user_id, $link) {
    $sql = "
            SELECT
            *
            FROM
                post_place_table
            WHERE
                post_place_table.user_id
            IN
                ('0','1','{$user_id}')
            ";
            
    return get_as_array($link, $sql);
}

function get_category ($category, $user_id, $link) {
    $sql = "
            SELECT
            *
            FROM
                post_place_table
            WHERE
                post_place_table.category = '{$category}'
            AND
                post_place_table.user_id 
            IN 
                ('0','1','{$user_id}')
            ";
            
    return get_as_array($link, $sql);
}

function redirect_to($url){
    header('Location: ' . $url);
    exit;
}