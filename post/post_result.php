<?php
require_once '../model/post_func.php';
require_once '../conf/const.php';


session_start();
if(isset($_SESSION['user_id']) === false){
    redirect_to('login.php');
}
$user_id = $_SESSION['user_id'];

$errors = [];
$success = '';

if (is_post() === TRUE) {
    $place_name = '';
    $comment = '';
    $url = '';
    $lat = '';
    $lng = '';
    $img = '';
    $img_dir = '../images/';
    //変数取得とエラーチェック
    $place_name = get_post('place_name');
    if(is_blank($place_name) === TRUE){
        $errors[] = '場所名を入力してください';
    }
    $comment = get_post('comment');
    $url = get_post('url');
    $lat = get_post('lat');
    if(is_blank($lat) === TRUE){
        $errors[] = '場所を指定してください';
    }
    $lng = get_post('lng');
    if(is_blank($lat) === TRUE){
       $errors[] = '場所を指定してください';
    }
    //ファイルがアップロードされたかの確認
    if (is_uploaded_file($_FILES['img']['tmp_name']) === TRUE) {
        //  画像タイプ取得
        $type = exif_imagetype($_FILES['img']['tmp_name']);
        $extention = '';
        //画像タイプのチェックと拡張子の設定
        if ($type === IMAGETYPE_JPEG) {
            $extention = 'jpg';
        } else if ($type === IMAGETYPE_PNG) {
            $extention = 'png';
        } else {
            $errors[] = '画像ファイルはjpgもしくはpngファイルにしてください';
        }
        //エラーがなければアップロード処理
        if (count($errors) === 0) {
            //ランダムな文字列の生成
            $random_string = substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, 20);
            //ファイル名を生成
            $img = $random_string . '.' . $extention;
            //同名ファイルが存在しなくなるまでファイル名を生成
            while (is_file($img_dir . $img) === TRUE) {
                $random_string = substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, 20);
                $img = $random_string . '.' . $extention;
            }
            if (move_uploaded_file($_FILES['img']['tmp_name'], $img_dir . $img) !== TRUE) {
                $errors[] = 'ファイルアップロードに失敗しました';
            }
        }
    } else {
        $errors[] = 'ファイルを選択してください';
    }
    if(count($errors) === 0){
        $link = get_db_connect();
        if(insert_post_place($place_name, $user_id, $comment, $img, $lat, $lng, $url, $link) === FALSE){
            $errors[] = 'insert_post_place失敗';
        }
    }
    if(count($errors) === 0){
        $success = '投稿に成功しました';
    }
}

include_once '../view/post_result_view.php';