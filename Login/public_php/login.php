<?php

//ログイン

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Login();

$app->run();

//echo "login screen";
//exit;

 ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
   <meta charset="utf-8">
   <title>Log In</title>
   <link rel="stylesheet" href="styles.css">
 </head>
 <body>
   <div id="container">
     <form action="" method="post" id="login">
       <p>
         <input type="text" name="email" placeholder="email" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>">
       </p>
       <p>
         <input type="password" name="password" placeholder="password">
       </p>
       <p class="err"><?= h($app->getErrors('login')); ?></p>
       <div class="btn" onclick="document.getElementById('login').submit();">Log In</div>
       <p class="fontsize12"><a href="/signup.php">Sign Up</a></p>
       <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
     </form>
   </div>
 </body>
 </html>
