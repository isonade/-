<?php

ini_set('display_errors' , 1);

define('DSN' , 'mysql:dbhost=localhost;dbname=email_db');
define('DB_USERNAME' , 'dbuser');
define('DB_PASSWORD' , '7654321');

define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

require_once(__DIR__ . '/../lib/functions.php');
require_once(__DIR__ . '/autoload.php');//クラスのオートロード設定(よくわからない設定)

session_start();

 ?>
