<?php
require_once '../conf/const.php';
require_once '../model/ec_func.php';

// POST以外の場合ログイン画面に戻る
if(get_request_method() !== 'POST'){
    redirect_to('login.php');
}

session_start();
$user_name = get_post_data('user_name');
$password = get_post_data('password');

// DB接続
$link = get_db_connect();
$sql = "
SELECT
    user_id
FROM
    users_table
WHERE
    user_name = '{$user_name}'
AND
    password = '{$password}'
";

// 空の配列を用意
$user = [];
// //クエリを実行しその結果を配列(1行)で取得する
$user = get_as_row($link, $sql);

// DB切断
close_db_connect($link);

// user配列内user_idについて
if(isset($user['user_id']) === true){
    // クッキー内のuse_idと一致したら？
    $_SESSION['user_id'] = $user['user_id'];
    // マイページに
    redirect_to('../mypage/mypage.php');
}

$_SESSION['login_error'] = 'ログインに失敗しました';
redirect_to('login.php');