<?php

require_once '../model/function_user_page2.php';
require_once '../conf/const.php';


$link = get_db_connect();

// $categoryの初期化
$category = 0;

if (is_post() === TRUE) {
    $category = get_post('category');
    $list_items = get_category($category, $link);
} else {
    $list_items = get_list($link);
}

// js形式に変換
$list_items_json = json_encode($list_items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
var_dump($list_items);

//db切断
close_db_connect($link);

include_once '../view/user_page_view2.php';