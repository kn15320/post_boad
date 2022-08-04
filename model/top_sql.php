<?php
    require_once("../commons/post_boad-db.php");
    post_dbconnection();

    function date_count(){
        global $pdo;

        $sql = "SELECT COUNT(ID) FROM st2109005_kawamura.user WHERE DATE between date_format(now(), '%Y-%m-01') and last_day(now())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r(current($data[0]));
    };

    function post_count(){
        global $pdo;

        $sql = "SELECT COUNT(*) FROM st2109005_kawamura.post";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data_1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r(current($data_1[0]));
    };

    function display_p(){
        global $pdo;
        
        $sql = "SELECT * FROM st2109005_kawamura.post ORDER BY DATE DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['data'] = $data;
    }

    function display_c(){
        global $pdo;
        
        $sql_c = "SELECT * FROM st2109005_kawamura.comment ORDER BY DATE DESC";
        $stmt1_c = $pdo->prepare($sql_c);
        $stmt1_c->execute();
        $data_c = $stmt1_c->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['data_c'] = $data_c;
    }
    
    function add_function(){
        global $pdo;
        
        $sql = "INSERT INTO st2109005_kawamura.post (TITLE, USER_ID_E_MAIL, POSTED_CONTENT, DATE) VALUES (:TITLE, :USER_ID_E_MAIL, :POSTED_CONTENT, now())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':TITLE', $_POST["title"], PDO::PARAM_STR);
        $stmt->bindValue(':USER_ID_E_MAIL', $_SESSION["login"], PDO::PARAM_STR);
        $stmt->bindValue(':POSTED_CONTENT', $_POST["post_text"], PDO::PARAM_STR);
        $stmt->execute();
        
    };

    function com_function(){
        global $pdo;
        $comment = isset($_POST['post_text_c']) ? $_POST['post_text_c'] : NULL;

        $sql = "INSERT INTO st2109005_kawamura.comment (POST_ID, COMMENT_USER_ID, COMMENT_CONTENT, DATE) VALUES (:POST_ID, :COMMENT_USER_ID, :COMMENT_CONTENT, now())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':POST_ID', $_POST["post_id"], PDO::PARAM_INT);
        $stmt->bindValue(':COMMENT_USER_ID', $_SESSION["login"], PDO::PARAM_STR);
        $stmt->bindValue(':COMMENT_CONTENT', $comment, PDO::PARAM_STR);
        $stmt->execute();
    };

    
    
?>