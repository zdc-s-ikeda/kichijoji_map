<?php 
/**
* DBハンドルを取得
* @return obj $link DBハンドル
*/
function get_db_connect() {
// コネクション取得
    if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
        die('error: ' . mysqli_connect_error());
    }
    // 文字コードセット
    mysqli_set_charset($link, DB_CHARACTER_SET);
        return $link;
}

/**
* DBとのコネクション切断
* @param obj $link DBハンドル
*/
function close_db_connect($link) {
    // 接続を閉じる
    mysqli_close($link);
}

/**
* クエリを実行しその結果を配列で取得する
*
* @param obj $link DBハンドル
* @param str $sql SQL文
* @return array 結果配列データ
*/
function get_as_array($link, $sql) {
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

/**
* プロフィールの一覧を取得する
*
* @param obj $link DBハンドル
* @return array プロフィール一覧配列データ
*/
function get_users_table_list($user_id, $user_name, $password, $mail, $gender, $birthdate, $log, $link) {
    // SQL生成
    $sql = 
        'SELECT 
            user_id, user_name, password, mail, gender, birthdate, created_date, updated_date 
        FROM 
            users_table';
    // クエリ実行
    return get_as_array($link, $sql);
}



