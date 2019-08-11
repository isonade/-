<?php

namespace MyApp;

class Controller {

  private $_errors;
  private $_values;

  public function __construct() {
    if (!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
    $this->_errors = new \stdClass();
    $this->_values = new \stdClass();
  }

//「Password」にエラーが出ても「email」は残る
  protected function setValues($key, $value) {
    $this->_values->$key = $value;
  }

  public function getValues() {
    return $this->_values;
  }


  protected function setErrors($key, $error) {
    $this->_errors->$key = $error;
  }

  public function getErrors($key) {
    return isset($this->_errors->$key) ?  $this->_errors->$key : '';
  }



  protected function hasError() {
    return !empty(get_object_vars($this->_errors));
  }

  protected function isLoggedIn() {
    // $_SESSION['me']というキーで情報を保持して、その中身を見てログインしているかを判断する。
    //「me」がセットされていて、かつ、空でないとする
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }

}
