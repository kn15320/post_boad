<?php
    session_start();

    $_SESSION["token"] = base64_encode(openssl_random_pseudo_bytes(32));
    $token = $_SESSION["token"];

    header('X-FRAME-OPTIONS: SAMEORIGIN');
    
    require_once("../commons/post_boad-db.php");
    post_dbconnection();
    
    $e_str = $_SESSION['E_MAIL'];
    $e_str_password = 'e13579';
    $method = 'aes-256-cbc';

    $ivLength = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivLength);
    $options = 0;
    
    $encrypted = openssl_encrypt($e_str, $method, $e_str_password, $options, $iv);



    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    //var_dump($password_hash);
    try{
        
        $sql = "INSERT INTO st2109005_kawamura.user(USER_ID_E_MAIL, PASSWORD, DATE) 
        VALUE(:USER_ID_E_MAIL, :PASSWORD, now())";

        $stm = $pdo->prepare($sql);
        $stm->bindValue(':USER_ID_E_MAIL', $encrypted, PDO::PARAM_STR);
        $stm->bindValue(':PASSWORD', $password_hash, PDO::PARAM_STR);
        $stm->execute();

        $sql = "UPDATE st2109005_kawamura.pre_user SET flag=1 WHERE E_MAIL=:E_MAIL";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':E_MAIL', $_SESSION['E_MAIL'], PDO::PARAM_STR);
        $stm->execute();

        $stm = null;//データベース接続切断

        $_SESSION = array();//セッション変数をすべて解除

        //セッションクッキーの削除
        if(isset($_COOKIE["PHPSESSID"])){
            echo '実行';
            setcookie("PHPSESSID", '', time() - 1800, '/');
        }
        //セッションを破棄する
        session_destroy();
    }catch(PDOException $e){
        //トランザクション取り消し(ロールバック)
        //var_dump($pdo);
        //$pdo->rollBack();
        
        $errors['error'] = "もう一度やり直してください。";
        print('Error:' . $e->getMessage());
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>登録完了</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <p>登録しました。</p>
        <p><a href ="./top.php">ログイン</a></p>
    </body>
