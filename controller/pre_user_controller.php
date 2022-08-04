<?php

    $errors = array();

    if (isset($_POST['submit'])) {
        if (empty($_POST['mail'])) {
            $errors['mail'] = 'メールアドレスが未入力です。';
        }else{
            $mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;
            
            if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
                $errors['mail_check'] = "メールアドレスの形式が正しくありません。";
            }
            
            require_once('../model/pre_user_sql.php');
            post_search();
            
            if(!empty($_SESSION['data'])){
                foreach($_SESSION['data'] as $key => $value){
                    $value["USER_ID_E_MAIL"];
                
                    $decrypted = hex2bin($value["USER_ID_E_MAIL"]);
                };
                    
                if($decrypted === $mail){
                    $errors['user_check'] = "このメールアドレスはすでに利用されております。";
                };
                
            }else{
                count($errors) === 0; 
            }
            
            if(count($errors) === 0){
                $urltoken = hash('sha256',uniqid(rand(),1));
                $_SESSION['urltoken'] = $urltoken;  
                $url = "http://localhost/ST2109005_kawamura/view/user_signup.php?urltoken=".$_SESSION['urltoken'];
                
                try{
                    require_once("../model/pre_user_sql.php");
                    pre_db();
                    
                    $message = "メール送信"."\n"."成功";     
                }catch (PDOException $e){
                    print('Error:'.$e->getMessage());
                    die();
                }
                
                $mailTo = $mail;
                $body = <<< EOM
                'この度はご登録いただきありがとうございます。
                24時間以内に下記のURLからご登録下さい。';
                {$url};
                EOM;
                mb_language('ja');
                mb_internal_encoding('UTF-8');
                $companymail = "xxx@example.com";
                
                $header = 'From: 管理者' . '<' . $companymail. '>';
                $registation_subject = "登録画面";
                
                if(mb_send_mail($mailTo, $registation_subject, $body, $header, '-f'. $companymail)){      
                    $_SESSION = array();
                    if (isset($_COOKIE['PHPSESSID'])) {
                        setcookie("PHPSESSID", '', time() - 1800, '/');
                    }
                    $pdo = null;
                    $message = "メール送信"."\n"."成功";
                }else{
                    $message = "メール送信"."\n"."失敗";
                }
            }
        }
    }
?>