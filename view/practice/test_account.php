<?php
    $account = "kawamura.n001@gmail.com";
    $encrypted = bin2hex($account);

    $password_hash = password_hash('kawamura001', PASSWORD_DEFAULT);

    require_once("../commons/post_boad-db.php");
    post_dbconnection();

    $sql = "INSERT INTO st2109005_kawamura.user (USER_ID_E_MAIL, PASSWORD, DATE) VALUE (:USER_ID_E_MAIL, :PASSWORD, now())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':USER_ID_E_MAIL', $encrypted, PDO::PARAM_STR);
    $stmt->bindValue(':PASSWORD', $password_hash, PDO::PARAM_STR);
    $stmt->execute();

?>