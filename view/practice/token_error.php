<?php
    session_start();
    
    $_SESSION["token"] = base64_encode(openssl_random_pseudo_bytes(32));
    $token = $_SESSION["token"];
    
    $text = '不正アクセスの可能性があります。'. "\n".'仮登録からやり直してください。';

    echo $text;
?>