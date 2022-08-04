<?php
    session_start();

    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
    $token = $_SESSION['token'];

    header('X-FRAME-OPTIONS: SAMEORIGIN');

    require_once('../controller/login_controller.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <title>ログイン</title>
        <meta charset="UTF-8">
    </head>
    <body>
    <h1>ログイン</h1>
    <?php
        error();
    ?>
    <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
        <p>ユーザーID(メールアドレス):<input type="text" name="mail" id="mail" size="50" ></p>
        <p id="comment"></P>
        <p>パスワード:<input type="password" name="password" id="pass" size="50" autocomplete="on"></p>
        <p id="comment_pass"></P>
        <p><input type="hidden" name="token" value="<?=$token;?>">
        <p><input type="submit" name="submit" value="ログイン">
    </form>        
    <p><a href="pre_user.php">新規会員登録はこちら</a></p>
    <script src="../js/validation.js"></script>
    </body>
<html>

