<?php
// ファイルの読み込み（失敗すると処理停止）
require_once '../conf/const.php';
require_once '../model/ec_func.php';

session_start();
if(isset($_SESSION['user_id']) === TRUE){
    //ログイン済みならマイページへ
    redirect_to('../mypage/mypage.php');
}

$errors = [];
if(isset($_SESSION['login_error']) === TRUE){
    $errors[] = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

// ファイルの読み込み（失敗しても処理は停止しない）
include_once '../view/login_view.php';