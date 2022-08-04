<?php
    session_start();
    //クロスサイトリクエストフォージェリ対策
    $_SESSION["token"] = base64_encode(openssl_random_pseudo_bytes(32));
    $token = $_SESSION["token"];

    //クリックジャッキング対策 フレーム内のページ表示を全ドメインで禁止したい場合
    header('X-FRAME-OPTIONS: SAMEORIGIN');
    
    $errors = array();

    //DB接続
    require_once("../commons/post_boad-db.php");
    post_dbconnection();

    //var_dump($_POST['e-mail']);
    //mail送信
    //送れたかどうかif文 mail失敗した場合
    //成功　DB値入れる
    //失敗　エラー表示 

    //var_dump($_POST['send']);
    if(isset($_POST['send'])){
        echo '実行';
        if(empty($_POST['e-mail'])){
            $errors['errors'] = "メールアドレスが未入力です。";

        }else{//e-mailの条件が合っているか
            $check = isset($_POST['e-mail']) ? $_POST['e-mail'] : NULL;
            if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-])+$/", $check)){
                $errors['errors'] = "メールアドレスの形式が正しくありません。";
            }
            
            //$decrypted = openssl_decrypt($e_str, $method, $e_str_password, $options, $iv);
            //DB確認
            $sql = "SELECT id FROM st2109005_kawamura.user WHERE E_MAIL = :E_MAIL";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':E_MAIL', $check, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            //var_dump($result);
            //DBのメールアドレスに相違がある場合
            if(isset($result["id"])){
                $errors['user_check'] = "このメールアドレスは利用されています。";
            }
        }
    }

    if(count($errors) === 0){
        
        $token = hash('sha256', uniqid(rand(), 1));
        $urltoken = "http://localhost/ST2109005_kawamura/view/new_member.php?token=".$token;
        var_dump("実行");
        try{
            $sql = "INSERT INTO st2109005_kawamura.pre_user(TOKEN, DATE, E_MAIL) 
            VALUE ( :TOKEN, now(), :E_MAIL) ";
            
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':TOKEN', $token, PDO::PARAM_STR);
            $stm->bindValue(':E_MAIL', $_POST['e-mail'], PDO::PARAM_STR);
            $stm->execute();
            
            mb_language("Japanese"); 
            mb_internal_encoding("UTF-8");
            
            $email = "xxxxxx@example.com";//送信元
            $subject = "仮登録"; // 題名 
            $body = '以下のURLから本登録ができます。'."\n".$urltoken."\n"; // 本文
            $to = $_POST['e-mail']; // 宛先
            $header = "From: $email\nReply-To: $email\n";
            
            mb_send_mail($to, $subject, $body, $header);
            //header("Location: ../controller/mail.php");
            //exit;
        }catch(PDOExseption $e){
            print('メール送信失敗:' . $e->getMessage());
            exit;
        }
        
    }
?>

    <!--if文の分岐をかく-->
<?php if (isset($_POST['submit']) && count($errors) === 0): ?>
    <!-- 登録完了画面 -->
    <p><?=$message?></p>
    <p>メール送信</p>
    <p>成功</p>
    
<?php else: ?>
<!-- エラー画面 -->
    <?php if(count($errors) > 0): ?>
        <?php
            foreach($errors as $value){
                echo "<p class='error'>".$value."</p>";
            }
        ?>
    <?php endif; ?>
        
        <input type="hidden" name="token" value="<?=$token?>">
        
<?php endif; ?>