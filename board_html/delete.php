<?php

define('DB_DATABASE', 'Board_db');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', '1234567');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname=' . DB_DATABASE);

try {
  //connect　いろいろな処理を$dbを使って出来る！
  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
  //エラーが出たときにExceptionを出すという設定(決まり文句)
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  /*
  (1) exec(): 結果を返さない、安全なSQL
  (2) query(): 結果を返す、安全、何回も実行されないSQL
  (3) prepare(): 結果を返す（（もしかして$stmtが返ってくる？））、
  　安全対策が必要、複数回実行されるSQL→ユーザーが複数回記入するときなどに多用
  */
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

$sql = 'DELETE FROM board WHERE image_id = :image_id';
$stmt = $db->prepare($sql);
$stmt->bindValue(':image_id', (int)$_GET['id'], PDO::PARAM_INT);
$stmt->execute();

unset($db);
header('Location:index.php');
exit();
?>
