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
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 画像を取得
    $sql = 'SELECT * FROM board ORDER BY created_at DESC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $images = $stmt->fetchAll();

} else {
    // 画像を保存
    if (!empty($_FILES['image']['name'])) {
        $name = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $content = file_get_contents($_FILES['image']['tmp_name']);
        $size = $_FILES['image']['size'];
        $user = $_POST['user'];
        $comment = $_POST['comment'];

        $sql = 'INSERT INTO board(image_name, image_type, image_content, image_size, created_at, user, comment)
                VALUES (:image_name, :image_type, :image_content, :image_size, now(), :user, :comment)';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':image_name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':image_type', $type, PDO::PARAM_STR);
        $stmt->bindValue(':image_content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':image_size', $size, PDO::PARAM_INT);
        $stmt->bindValue(':user', $user, PDO::PARAM_STR);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
        $stmt->execute();
    }
    unset($db);
    header('Location:index.php');
    exit();
}

unset($db);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Image Test</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
  <div class="form">
      <form method="post" enctype="multipart/form-data">
          <div class="form-group">
              <p>投稿者</p>
              <input type="text" name="user" ><br>
              <p>コメント</p>
              <textarea name="comment" rows="4" cols="35"></textarea><br>
              <p>画像を選択</p>
              <input type="file" name="image" >
          </div>
          <button type="submit" class="btn">保存</button>
      </form>
  </div>

    <div class="row">
        <div class="col-md-8 border-right">
            <ul class="list">
                <?php for($i = 0; $i < count($images); $i++): ?>
                    <li>
                      <div class="text">
                        <h5>投稿者：<?= $images[$i]['user']; ?> </h5>
                        <h5>コメント：<br><?= $images[$i]['comment']; ?> </h5>
                      </div>
                      <div class="media-body">
                          <h5>写真：<?= $images[$i]['image_name']; ?> </h5>
                          <img src="image.php?id=<?= $images[$i]['image_id']; ?>" width="100px" height="auto" class="mr-3"><br>
                          <a href="javascript:void(0);" class="delete"
                              onclick="var ok = confirm('削除しますか？'); if (ok) location.href='delete.php?id=<?= $images[$i]['image_id']; ?>'">
                              <i class="far fa-trash-alt"></i> 削除</a>
                      </div>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

</body>
</html>
