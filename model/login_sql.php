<?php
    
    require_once("../commons/post_boad-db.php");
    post_dbconnection();
    
    $sql = "SELECT USER_ID_E_MAIL,PASSWORD FROM st2109005_kawamura.user";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>