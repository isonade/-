<?php

namespace MyApp\Controller;

//共通処理を書いたControllerクラスを継承すればOK
class Login extends \MyApp\Controller {

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
    } catch (\MyApp\Exception\EmptyPost $e) {
//入力が空の時
      $this->setErrors('login', $e->getMessage());
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
        $user = $userModel->login([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
//「Email」と「Password」が合致しないとき
      } catch (\MyApp\Exception\UnmatchEmailOrPassword $e) {
        $this->setErrors('login', $e->getMessage());
        return;
      }

          //login処理→ login 処理はユーザー情報が $_SESSION['me'] に入ったかどうかで判定していたので、このようにしてあげれば OK
          session_regenerate_id(true);//セッションハイジャックを防止するため、毎回新しい値をセットする
            $_SESSION['me'] = $user;

          // redirect to login
          header('Location: ' . SITE_URL );
      exit;
    }
  }

  private function _validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "Invalid Token!";
      exit;
    }

    if (!isset($_POST['email']) || !isset($_POST['password'])) {
      echo "Invalid Form!";
      exit;
    }

    if ($_POST['email'] === '' || $_POST['password'] === '') {
      throw new \MyApp\Exception\EmptyPost();
    }
  }

}
?>
