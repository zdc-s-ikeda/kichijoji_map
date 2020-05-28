<?php

define('DB_HOST',   'localhost'); // データベースのホスト名又はIPアドレス
define('DB_USER',   getenv('DB_USER'));  // MySQLのユーザ名
define('DB_PASSWD', getenv('DB_USER'));    // MySQLのパスワード
define('DB_NAME',   getenv('DB_USER'));    // データベース名
define('HTML_CHARACTER_SET', 'UTF-8');  // HTML文字エンコーディング
define('DB_CHARACTER_SET',   'UTF8');   // DB文字エンコーディング