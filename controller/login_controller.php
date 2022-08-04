<?php
    $errors = array();

    function error(){
        global $errors;
        if(count($errors) > 0){
            foreach($errors as $value){
                echo "<p class='error'>".$value."</p>";
            }
        }
    }

    if (isset($_SESSION["login"])) {
        session_regenerate_id(TRUE);
        header("Location: top.php");
        exit();
    }
    
    if(isset($_POST['submit'])){
        if(empty($_POST['mail']) || empty($_POST['password'])){
            $errors['mail,password'] = "メールアドレスとパスワードを入力してください";
        }else{
            $mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;
            
            if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
                $errors['mail_check'] = "メールアドレスの形式が正しくありません。";
            }
        
            require_once('../model/login_sql.php');

            for($i = 0; $i < count($data); $i++){    
                $decrypted = hex2bin($data[$i]["USER_ID_E_MAIL"]);
                
                $match = preg_match("/$decrypted/", $mail);
                
                if($match === 1){
                    if (password_verify($_POST['password'], $data[$i]["PASSWORD"])) {
                        session_regenerate_id(TRUE); 
                        $_SESSION["login"] = $_POST['mail'];
                        header("Location: top.php");
                        exit();
                        
                    }else{
                        $errors['mail,password']="メールアドレスかパスワードが違います";
                    }
                    
                }else{
                    $errors['mail,password']="メールアドレスかパスワードが違います";
                }
            }
        }
    }
?>