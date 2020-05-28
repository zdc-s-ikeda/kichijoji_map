<?php
require_once '../model/post_func.php';
require_once '../conf/const.php';

//sectionでuser_id持ってくる
session_start();
if(isset($_SESSION['user_id']) === false){
    redirect_to('login.php');
}
$user_id = $_SESSION['user_id'];


include_once '../view/post_view.php';