<?php
    session_start();
    //クロスサイトリクエストフォージェリ（CSRF）対策
    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
    $token = $_SESSION['token'];
    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');
    
    //エラーメッセージの初期化
    $errors = array();
    //DB接続
    require_once("../commons/post_boad-db.php");
    post_dbconnection();
    //登録するもの
    $mail = "kawamura.n001@gmail.com";
    $password = "wer1234556";

    $sql = "INSERT INTO st2109005_kawamura.user (USER_ID_E_MAIL, PASSWORD, DATE) VALUES (:USER_ID_E_MAIL, :PASSWORD, now())";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':USER_ID_E_MAIL', $encrypted, PDO::PARAM_STR);
    $stm->bindValue(':PASSWORD', $password_hash, PDO::PARAM_STR);
    $stm->execute();
    $data = $stm->fetchAll(PDO::FETCH_ASSOC);

    var_dump($data);
?>