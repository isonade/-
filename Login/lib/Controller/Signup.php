<?php

namespace MyApp\Controller;

//共通処理を書いたControllerクラスを継承すればOK
class Signup extends \MyApp\Controller {

  public function run() {
    //もしログインしていなければログインしなさいとする
    if ($this->isLoggedIn()) {
      //サイトURLに飛ぶ、configでIPアドレスとポート番号が入る設定にした。
      //ログインしていたらホームに飛ばせばよい
      header('Location: ' . SITE_URL );
      exit;
    }

    //新規登録にフォームがポストされたら
    //実際行うことは見通しよく別メソッドのpostProcessとする。
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  //将来の拡張性からprotectedで作成
  protected function postProcess() {
    // validate　フォームが投稿されたらデータを検証→それが良ければユーザーを作る→redirect to loginしてあげれば完了
    try {
      $this->_validate();
    } catch (\MyApp\Exception\InvalidEmail $e) {
//MyApp名前クラスの中に、Exceptionのサブクラスを作り、InvalidEmailの例外クラスを作る
      $this->setErrors('email', $e->getMessage());
    } catch (\MyApp\Exception\InvalidPassword $e) {
      $this->setErrors('password', $e->getMessage());
    }

//「Password」にエラーが出ても「email」は残る
    $this->setValues('email', $_POST['email']);

//エラーが出たときは「create user」に行ってほしくないので「return」で止める
    if ($this->hasError()) {
      return;
    } else {
          // create user
          try {
        $userModel = new \MyApp\Model\User();
        $userModel->create([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }
          // redirect to login
          header('Location: ' . SITE_URL . '/login.php');
      exit;
    }
  }

  private function _validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "Invalid Token!";
      exit;
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new \MyApp\Exception\InvalidEmail();
    }

    if (!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password'])) {
      throw new \MyApp\Exception\InvalidPassword();
    }
  }

}
?>
