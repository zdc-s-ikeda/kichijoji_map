<?php

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

function get_request_method() {
   return $_SERVER['REQUEST_METHOD'];
}

function is_post(){
    return get_request_method() === 'POST';
}

function get_post($name){
    if (isset($_POST[$name]) === TRUE){
        return trim($_POST[$name]);
    }
    return '';
}

function is_blank($value){
    return $value === '';
}

function redirect_to($url){
    header('Location: ' . $url);
    exit;
}

function set_time(){
    return date('Y-m-d H:i:s');
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

function insert_post_place($place_name, $user_id, $comment, $img, $lat, $lng, $url, $link){
    $log = set_time();
    $status = 0;
    $sql = "INSERT INTO
                post_place_table(
                    place_name,
                    user_id,
                    comment,
                    img,
                    status,
                    lat,
                    lng,
                    url,
                    created_date,
                    updated_date)
            VALUES(
                '{$place_name}',
                '{$user_id}',
                '{$comment}',
                '{$img}',
                '{$status}',
                '{$lat}',
                '{$lng}',
                '{$url}',
                '{$log}',
                '{$log}')";
    return result_query($link, $sql);
}

function display_error($errors){
    if(count($errors) !== 0){
        foreach($errors as $error){
            "<p>" . print h($error) . "</p>";
        }
    }
}

//実行結果表示(success)
function display_success($success){
    if($success !== ''){
        "<p>" . print h($success) . "</p>";
    }
}