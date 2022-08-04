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
    
    $sql = "SELECT USER_ID_E_MAIL FROM st2109005_kawamura.user";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                var_dump($data);

?>