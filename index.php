<?php
    define('DB_DATABASE', 'dbname');
    // define('DB_USERNAME', 'username');
    define('DB_USERNAME', 'root');
    // define('DB_PASSWORD', 'passwd');
     define('DB_PASSWORD', 'tTme');
    define('PDO_DSN', 'mysql:dbhost=localhost;dbname=' . DB_DATABASE);
    // 接続
try {
    $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
var_dump($db);
    //INSERT
    // $db ->exec("insert into user (email,password,plan,status,start_date,update_date) values ('ttt@vvv','xxx','1','A','2019/05/02','2019/06/12')");
    // echo "user added!";
  // disconnect
//  $db = null;

  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}
//接続

// $sql ="SELECT *FROM 'user' WHERE'no' = ? AND CONVERT(AES_DECRYPT(UNHEX('email'),))";
$sql ="SELECT * FROM user";
$stmt = $db -> prepare($sql);
$stmt->execute();

 ?>

 <!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="utf-8">
     <title>管理画面</title>
   </head>
   <body>
     <h2>管理画面</h2>
     <table border="1">
    <tr>
      <th>ID</th>
      <th>メールアドレス</th>
      <th>プラン</th>
      <th>ステータス</th>
      <th>作成日時</th>
      <th>更新日時</th>
    </tr>

    <?php foreach ($stmt as $row) : ?>
    <tr>
      <td><?php echo $row['no'] ; ?></td>
      <td><?php echo $row['email'] ; ?></td>
      <td><?php echo $row['plan'] ; ?>円/月コース</td>
      <!-- <td><?php echo $row['subscription_id'] ; ?></td> -->
      <td>
        <?php if ($row['status'] == 0) { ?>
          <?php $span = "<span style='color:blue'> ログオフ </span>";
          echo $span;?>
        <?php }else{ ?>
          <?php $span = "<span style='color:red'> ログイン </span>";
          echo $span;?>
        <?php } ?>
      </td>
      <td><?php echo $row['start_date'] ; ?></td>
      <td><?php echo $row['update_date'] ; ?></td>
    </tr>
    <?php endforeach ; ?>

  </table>
   </body>
 </html>
