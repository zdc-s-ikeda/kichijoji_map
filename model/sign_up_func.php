<?php
//特殊文字をHTMLエンティティに変換する
function entity_str($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

//特殊文字をHTMLエンティティに変換する(2次元配列の値)
function entity_assoc_array($assoc_array) {

    foreach ($assoc_array as $key => $value) {

        foreach ($value as $keys => $values) {
            // 特殊文字をHTMLエンティティに変換
            $assoc_array[$key][$keys] = entity_str($values);
        }

    }
 
    return $assoc_array;
 
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


//DB切断
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
        if (mysqli_num_rows($result) > 0) {
            // １件ずつ取り出す
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        // 結果セットを開放
        mysqli_free_result($result);
    }
    return $data;
}


//users_table追加
function insert_user($user_name, $password, $mail, $gender, $birthdate, $link){
    $log = set_time();
    $sql = "INSERT INTO 
                users_table(
                    user_name,
                    password,
                    mail,
                    gender,
                    birthdate,
                    created_date,
                    updated_date)
            VALUES (
                '{$user_name}',
                '{$password}',
                '{$mail}',
                {$gender},
                '{$birthdate}',
                '{$log}',
                '{$log}')";
    return result_query($link, $sql);
}


//リクエストメソッド取得
function get_request_method() {
   return $_SERVER['REQUEST_METHOD'];
}

//POSTデータ取得
function get_post_data($key) {
   $str = '';
   if (isset($_POST[$key]) === TRUE) {
       $str = trim($_POST[$key]);
   }
   return $str;
}

//年月日時分秒
function set_time(){
    return date('Y-m-d H:i:s');
}

//空かどうか
function is_blank($value){
    return $value === '';
}

//0以上の整数か
function is_number($value){
    return preg_match('/^0$|^-?[1-9][0-9]*$/', $value) === 1;
}

//genderチェック用 1~3であるか
function is_valid_gender($value){
    return preg_match('/[123]/', $value) === 1;
}

//username, passwdチェック用 n文字以上の半角英数字か
function is_match($value, $length){
    return preg_match('/\A[a-z\d]{' . $length . ',}+\z/', $value) === 1;
}

//username, passwdチェック用 文字数制限
function str_count($value, $length){
    if(mb_strlen($value) > $length){
        return false;
    }else{
        return true;
    }
}
//mailチェック用
function is_valid_mail($value){
    return preg_match('/[\w_\-\.]+@[[\w_\-\.]+/', $value) === 1;
}


//同名アカウント存在確認
function check_name($user_name, $link){
    $sql = "SELECT
                user_name
            FROM
                users_table
            WHERE
                user_name = '{$user_name}'";
    if(empty(get_as_row($link, $sql)) === TRUE){
        return [];
    }
    return false;
}

function get_as_row($link, $sql) {
    if ($result = mysqli_query($link, $sql)) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $row;
    }
    return [];
}


//実行結果表示(errors)
function display_error($errors){
    if(count($errors) !== 0){
        foreach($errors as $error){
            "<p>" . print entity_str($error) . "</p>";
        }
    }
}

//実行結果表示(success)
function display_success($success){
    if($success !== ''){
        "<p>" . print entity_str($success) . "</p>";
    }
}

function dd($var){
  var_dump($var);
  exit();
}

function redirect_to($url){
    header('Location: ' . $url);
    exit;
}