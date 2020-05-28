<?php
require_once '../conf/const.php';
require_once '../model/sign_up_func.php';

// session_start();
// if(isset($_SESSION['user_id']) === true){
//     redirect_to('../mypage/mypage.php');
// }
// $user_id = $_SESSION['user_id'];


$errors = [];
$success = '';
$user_name = '';
$password = '';
$mail = '';
$gender = '';
$birthdate = '';

$request_method = get_request_method();
$log = set_time();
if($request_method === 'POST'){
    $user_name = get_post_data('user_name');
    if(is_blank($user_name) === true){
        $errors[] = 'ユーザー名を入力してください';
    }else if(is_match($user_name, 2) !== true){
        $errors[] = 'ユーザー名は2字以上の半角英数字で入力してください';
    }else if(str_count($user_name, 30) === false){
        $errors[] = 'ユーザー名は30字以下の半角英数字で入力してください';
    }
    
    $password = get_post_data('password');
    if(is_blank($password) === true){
        $errors[] = 'パスワードを入力してください';
    }else if(is_match($password, 5) !== true){
        $errors[] = 'パスワードは5字以上の半角英数字で入力してください';
    }else if(str_count($password, 30) === false){
        $errors[] = 'パスワードは30字以下の半角英数字で入力してください';
    }
    
    // $mail = get_post_data('mail');
    // if(is_blank($mail) === true){
    //     $errors[] = 'メールアドレスを入力してください';
    // }else if(is_valid_mail($mail) !== true){
    //     $errors[] = '不正なメールアドレスです';
    // }
    
    $gender = get_post_data('gender');
    if(is_blank($gender) === true){
        $errors[] = '性別を選択してください';
    }else if(is_valid_gender($gender) !== true){
        $errors[] = '性別は男性、女性、その他のいずれかを選択してください';
    }
    
    // $birthdate = get_post_data('birthdate');
    // if(is_blank($birthdate) === true){
    //     $errors[] = '誕生日を入力してください';
    // }
    // var_dump($_POST);
    // var_dump($log);
    $link = get_db_connect();
    if(count($errors) === 0){
        //同名アカウント存在確認
        if(check_name($user_name, $link) === []){
            //user_table追加
            if(insert_user($user_name, $password, $mail, $gender, $birthdate, $link) === FALSE){
                $errors[] = 'users_table追加失敗';
            }else{
                $success = '新規登録が完了しました。ログインボタンを押しログインをお願いします。';
            }
        }else{
            $errors[] = '登録失敗しました。同名アカウントが存在しています。';
        }
    }
    close_db_connect($link);
}

include_once '../view/sign_up_view.php';