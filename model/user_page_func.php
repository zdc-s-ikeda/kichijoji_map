<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

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

//トランザクション開始
function autocommit($link){
    mysqli_autocommit($link, false);
}

//トランザクション成功終了
function commit($link){
    mysqli_commit($link);
}

//トランザクション失敗終了
function rollback($link){
    mysqli_rollback($link);
}

//DB切断
function close_db_connect($link) {
    // 接続を閉じる
    mysqli_close($link);
}

//直前のクエリで生成したIDを取得
function insert_id($link){
    return mysqli_insert_id($link);
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

//クエリを実行しその結果を配列(1行)で取得する
function get_as_row($link, $sql){
    if($result = mysqli_query($link, $sql)){
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $row;
    }
    return [];
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

//0か1であるか
function is_zeroone($value){
    return preg_match('/[01]/', $value) === 1;
}

//n文字以上の半角英数字か
function is_match($value, $length){
    return preg_match('/\A[a-z\d]{' . $length . ',}+\z/', $value) === 1;
}

//リダイレクト
function redirect_to($url){
    header('Location: ' . $url);
    exit;
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


function get_session($name){
  if(isset($_SESSION[$name]) === true){
    return $_SESSION[$name];
  };
  return '';
}

function set_session($name, $value){
  $_SESSION[$name] = $value;
}

function set_error($error){
  $_SESSION['__errors'][] = $error;
}

function get_errors(){
  $errors = get_session('__errors');
  if($errors === ''){
    return [];
  }
  set_session('__errors',  []);
  return $errors;
}

function dd($var){
  var_dump($var);
}

function insert_place_data($link, $place_name, $comment, $filename, $status, $url, $lat, $lng){
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO
                post_place_table
                (place_name, comment, img, status, url, created_date, updated_date)
            VALUES('{$place_name}', '{$comment}', '{$filename}', '{$status}', '{$url}', {$lat}, {$lng}, '{$date}', '{$date}')";
    dd($sql);
    return execute_query($link, $sql);
}

function get_place_data($link){
    $sql = "SELECT
                place_id, place_name,
            FROM
                post_place_table";
    return get_as_array($link, $sql);
}

function is_post() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function execute_query($link, $sql) {
    return mysqli_query($link, $sql);
}

function get_route_info($link, $user_id){
    $sql = "
            SELECT
                *
            FROM
                route_table
            WHERE
                user_id = '{$user_id}'
            ";

    return get_as_array($link, $sql);
}

function get_route_place($link, $route_id) {
        $sql = "
                SELECT
                    place_name, img, comment, url
                FROM
                    route_table
                JOIN
                    place_list_table
                ON
                    route_table.route_id = place_list_table.route_id
                JOIN
                    post_place_table
                ON
                    place_list_table.place_id = post_place_table.place_id
                WHERE
                    route_table.route_id = '{$route_id}'
                ";
        return get_as_array($link, $sql);
}

function get_post_place($link, $user_id) {
    $sql = "
            SELECT
                *
            FROM
                post_place_table
            WHERE
                user_id = {$user_id}";
    return get_as_array($link, $sql);
}

function get_user_info($link, $user_id) {
    $sql = "
            SELECT
                *
            FROM
                users_table
            WHERE
                user_id = {$user_id}";
    return get_as_row($link, $sql);
}


//postされた値を受け取る
function get_post($key) {
    if (isset($_POST[$key]) === TRUE) {
        return trim($_POST[$key]);
    }
}


/*place_list_tableに登録されたピンを表示させる
そのためにここでもpost_place_tableと内部結合する必要ある？*/
// 全部のものをJOINでもってくる
function get_list($link) {
    $sql = "
            SELECT
            *
            FROM
                post_place_table
            JOIN
                users_table
            ON
                post_place_table.user_id = users_table.user_id
            JOIN
                place_list_table
            ON
                post_place_table.place_id = place_list_table.place_id
            JOIN
                route_table
            ON
                place_list_table.route_id = route_table.route_id
            WHERE
                route_table.route_id = 1
            ";
            
    return get_as_array($link, $sql);
}
