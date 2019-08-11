<?php

namespace MyApp\Controller;

//共通処理を書いたControllerクラスを継承すればOK
class Index extends \MyApp\Controller {

  public function run() {
    //もしログインしていなければログインしなさいとする
    if (!$this->isLoggedIn()) {
      // login
      //サイトURLに飛ぶ、configでIPアドレスとポート番号が入る設定にした。
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }

    // get users info
  }

}


 ?>
