<?php
    function post_dbconnection(){
        global $pdo, $e;
        try{
            //データベースに接続
            $pdo = new PDO(
                'mysql:dbname=st2109005_kawamura;host=localhost;charset=utf8mb4',//dbname=で参照DB名を切り替えられます。
                'root',//初期設定ではユーザー名は「root」になっています。
                'postboad001',//初期設定ではパスワードは「root」もしくは「''(空文字)」になっています。「'root'」でうまくいかない場合は「''」で試してみて下さい。
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]    
            );

        
        }catch(PDOException $e){
            //エラー発生時
            echo $e->getMessage();
            exit;
        }
    }
?>