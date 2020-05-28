<?php
//特殊文字をHTMLエンティティに変換する
// ここのentity_strは'h'一文字に置き換えてok
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

//item_table追加
function insert_item($item_name, $price, $item_img, $open_status, $log, $link){
    $sql = "INSERT INTO 
                item_table(
                    item_name,
                    price,
                    item_img,
                    status,
                    created_date,
                    update_date)
            VALUES (
                '{$item_name}',
                '{$price}',
                '{$item_img}',
                '{$open_status}',
                '{$log}',
                '{$log}')";
    return result_query($link, $sql);
}

//stock_table追加
function insert_stock($item_id, $stock, $log, $link){
    $sql = "INSERT INTO 
                stock_table(
                    item_id, 
                    stock, 
                    created_date, 
                    update_date)
            VALUES(
                '{$item_id}',
                '{$stock}',
                '{$log}',
                '{$log}')";
    return result_query($link, $sql);
}

//stock_table更新
function update_stock($update_stock, $log, $item_id, $link){
    $sql = "UPDATE 
                stock_table 
            SET 
                stock = '{$update_stock}',
                update_date = '{$log}'
            WHERE
                item_id = '{$item_id}'";
    return result_query($link, $sql);
}

//item_table更新
function update_status($update_status, $log, $item_id, $link){
        $sql = "UPDATE 
                item_table 
            SET 
                status = '{$update_status}',
                update_date = '{$log}'
            WHERE
                item_id = '{$item_id}'";
    return result_query($link, $sql);
}

//item_table削除
function delete_item($item_id, $link){
    $sql = "DELETE FROM
                item_table
            WHERE
                item_id = '{$item_id}'";
    return result_query($link, $sql);
}

//stock_table削除
function delete_stock($item_id, $link){
    $sql = "DELETE FROM
                stock_table
            WHERE
                item_id = '{$item_id}'";
    return result_query($link, $sql);
}

//全ユーザーからcart_table削除
function delete_cart($item_id, $link){
    $sql = "DELETE FROM
                cart_table
            WHERE
                item_id = '{$item_id}'";
    return result_query($link, $sql);
}

//特定のユーザーからcart_table削除
function delete_cart_uid($item_id, $user_id, $link){
    $sql = "DELETE FROM
                cart_table
            WHERE
                item_id = '{$item_id}'
            AND
                user_id = '{$user_id}'";
    return result_query($link, $sql);
}

//商品一覧取得
function select_item($link){
    $sql = "SELECT
                item_table.item_id,
                item_img,
                item_name,
                price,
                stock,
                status
            FROM 
                item_table 
            JOIN 
                stock_table 
            ON
                item_table.item_id = stock_table.item_id";
    return get_as_array($link, $sql);
}

//特定ユーザーのカート取得
function select_cart($user_id, $link){
    $sql = "SELECT
                cart_table.item_id,
                amount,
                item_table.item_img,
                item_table.price,
                item_name
            FROM
                cart_table
            JOIN
                item_table
            ON
                cart_table.item_id = item_table.item_id
            WHERE
                user_id = '{$user_id}'";
    return get_as_array($link, $sql);
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

//同名アカウント存在確認
function check_name($user_name, $link){
    $sql = "SELECT
                user_name
            FROM
                ecuser_table
            WHERE
                user_name = '{$user_name}'";
    if(empty(get_as_row($link, $sql)) === TRUE){
        return [];
    }
    return 'false';
}

//SELECT結果行数カウント
function row_count($result){
    return mysqli_num_rows($result);
}

//ecuser_table追加
function insert_user($user_name, $password, $log, $link){
    $sql = "INSERT INTO
                ecuser_table(
                    user_name,
                    password,
                    created_date,
                    update_date)
            VALUES(
                '{$user_name}',
                '{$password}',
                '{$log}',
                '{$log}')";
    return result_query($link, $sql);
}

//同商品購入履歴確認
function check_amount($user_id, $item_id, $link){
    $sql = "SELECT
                amount
            FROM
                cart_table
            WHERE
                user_id = '{$user_id}'
            AND
                item_id = '{$item_id}'";
    $amount = get_as_row($link, $sql);
    if(empty($amount) === TRUE){
        return [];
    }
    return $amount;
}

//cart_table追加
function insert_cart($user_id, $item_id, $log, $link){
    $sql = "INSERT INTO
                cart_table(
                    user_id,
                    item_id,
                    amount,
                    created_date,
                    update_date)
            VALUES(
                '{$user_id}',
                '{$item_id}',
                '1',
                '{$log}',
                '{$log}')";
    return result_query($link, $sql);
}

//cart_table更新
function update_cart($amount, $log, $user_id, $item_id, $link){
    $sql = "UPDATE
                cart_table
            SET
                amount = '{$amount}',
                update_date = '{$log}'
            WHERE
                user_id = '{$user_id}'
            AND
                item_id = '{$item_id}'";
    return result_query($link, $sql);
}

//user_name取得
function get_user_name($user_id, $link){
    $sql = "SELECT
            user_name
        FROM
            ecuser_table
        WHERE
            user_id = '{$user_id}'";
    return get_as_row($link, $sql);
}

//ユーザー一覧取得
function select_user($link){
    $sql = "SELECT
                user_name,
                created_date
            FROM
                ecuser_table";
    return get_as_array($link, $sql);
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
  exit();
}