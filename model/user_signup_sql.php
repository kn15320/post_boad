<?php
    require_once("../commons/post_boad-db.php");
    post_dbconnection();

    function token(){
        global $pdo;
    
        $sql = "SELECT E_MAIL FROM st2109005_kawamura.pre_user WHERE TOKEN=(:TOKEN) AND flag =0 AND DATE > now() - interval 24 hour";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':TOKEN', $_SESSION['urltoken'], PDO::PARAM_STR);
        $stm->execute();

        $_SESSION['row_count'] = $stm->rowCount();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        
        $_SESSION['d_E_MAIL'] = $data[0]["E_MAIL"];
    }

    function user_add(){
        global $pdo;
    
		$encrypted = bin2hex($_SESSION['E_MAIL']);
        $password_hash =  password_hash($_SESSION['password'], PASSWORD_DEFAULT);
		
        $sql = "INSERT INTO st2109005_kawamura.user (USER_ID_E_MAIL, PASSWORD, DATE) VALUES (:USER_ID_E_MAIL, :PASSWORD, now())";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':USER_ID_E_MAIL', $encrypted, PDO::PARAM_STR);
        $stm->bindValue(':PASSWORD', $password_hash, PDO::PARAM_STR);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        
        $sql_1 = "UPDATE pre_user SET flag=1 WHERE E_MAIL=:E_MAIL";
        $stm_1 = $pdo->prepare($sql_1);
        
        $stm_1->bindValue(':E_MAIL', $_SESSION['d_E_MAIL'], PDO::PARAM_STR);
        $stm_1->execute();
        $data_1 = $stm_1->fetchAll(PDO::FETCH_ASSOC);
    };    
?>