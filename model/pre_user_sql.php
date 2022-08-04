<?php
    require_once("../commons/post_boad-db.php");
    post_dbconnection();
    
    function post_search(){
        global $pdo;

        $sql = "SELECT USER_ID_E_MAIL FROM st2109005_kawamura.user";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['data'] = $data;

    }
    
    function pre_db(){
        global $pdo;

        $encrypted = bin2hex($_POST['mail']);
        $sql = "INSERT INTO st2109005_kawamura.pre_user (TOKEN, DATE, E_MAIL, flag) VALUES (:TOKEN, now(), :E_MAIL, '0')";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':TOKEN', $_SESSION['urltoken'], PDO::PARAM_STR);
        $stm->bindValue(':E_MAIL', $encrypted, PDO::PARAM_STR);
        $stm->execute();
    }
?>