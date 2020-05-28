<?php

require_once '../model/function_category.php';
require_once '../conf/const.php';

$link = get_db_connect();

// $categoryの初期化
$category = '';

if (is_post() === TRUE) {
    $category = get_post('category');
    if($category === '1' || $category === '2' || $category === '3'){
        $list_items = get_category($category, $link);
    }else{
        $list_items = get_list($link);
    }
} else {
    $list_items = get_list($link);
}

// js形式に変換
$list_items_json = json_encode($list_items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

//db切断
close_db_connect($link);

include_once '../view/category_view.php';