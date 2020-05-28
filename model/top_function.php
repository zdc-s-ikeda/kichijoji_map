<?php
//おすすめリストを取得
function get_favarite_route($link) {
    $sql = "
            SELECT
                route_name, route_id, users_table.user_name, users_table.user_id
            FROM
                route_table
            JOIN
                users_table
            ON
                route_table.user_id = users_table.user_id
            ";
    return get_as_array($link, $sql);
}

function get_img($link, $route_id) {
    
    $sql = "
            SELECT
                img
            FROM
                post_place_table
            JOIN
                place_list_table
            ON
                post_place_table.place_id = place_list_table.place_id
            WHERE
                route_id = '{$route_id}'
            ";
    $result = get_as_array($link, $sql);

    return $result;
}

function redirect_to($url){
    header('Location: ' . $url);
    exit;
}