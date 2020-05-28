<?php
// 設定ファイル読み込み
require_once 'const_user_page.php';
// 関数ファイル読み込み
require_once 'model_user_page.php';
 
$user_data = [];
 
// DB接続
$link = get_db_connect();
 
// プロフィール一覧を取得
$user_data = get_users_table_list($user_id, $user_name, $password, $mail, $gender, $birthdate, $log, $link);
 
// DB切断
close_db_connect($link);
