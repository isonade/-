<?php

/*
MyApp
index.php controller
MyApp\Controller\Index
-> lib/Controller/Index.php
*/

//S（スタンダード）P（PHP）L（ライブラリ）
spl_autoload_register(function($class){
//クラスに渡ってくる名前が「MyApp」から始まるときファイルを読み込むと書く
//ドットインストール＃05の説明
  $prefix = 'MyApp\\';
  if (strpos($class, $prefix) === 0) {
    $className = substr($class, strlen($prefix));
    $classFilePath = __DIR__ . '/../lib/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($classFilePath)) {
      require $classFilePath;
    }
  }
});
 ?>
