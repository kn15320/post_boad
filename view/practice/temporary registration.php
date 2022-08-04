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

    //SQL実行 
    //DBに入力されたメールアドレスを登録する
    //入力されたメールアドレスに本登録のURLを添付し送信する
    //送信ボタンをクリックしたときの処理
    //受け取ったらDBに保存する

    //未入力の際のエラーが表示されない
    //メールアドレスの形式でない場合のエラーが表示されない
    //登録されたメールアドレスがある場合のエラーが表示されない
    // var_dump($_POST['send']);
    // if(isset($_POST['send'])){
    //     echo '実行';
    //     if(empty($_POST['e-mail'])){
    //         $errors['errors'] = "メールアドレスが未入力です。";

    //     }else{//e-mailの条件が合っているか
    //         $check = isset($_POST['e-mail']) ? $_POST['e-mail'] : NULL;
    //         if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-])+$/", $check)){
    //             $errors['errors'] = "メールアドレスの形式が正しくありません。";
    //         }
            
    //         $decrypted = openssl_decrypt($e_str, $method, $e_str_password, $options, $iv);
    //         //DB確認
    //         $sql = "SELECT id FROM st2109005_kawamura.user WHERE E_MAIL = :E_MAIL";
    //         $stmt = $pdo->prepare($sql);
    //         $stmt->bindValue(':E_MAIL', $check, PDO::PARAM_STR);
    //         $stmt->execute();
    //         $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //         //var_dump($result);
    //         //DBのメールアドレスに相違がある場合
    //         if(isset($result["id"])){
    //             $errors['user_check'] = "このメールアドレスは利用されています。";
    //         }
    //     }
        //エラーがない場合、pre_userテーブルに追加
        // if(count($errors) === 0){
        //     $token = hash('sha256', uniqid(rand(), 1));
        //     $urltoken = "http://localhost/ST2109005_kawamura/view/new_member.php?token=".$token;
        //     var_dump("実行");
        //     try{
        //         $sql = "INSERT INTO st2109005_kawamura.pre_user(TOKEN, DATE, E_MAIL) 
        //         VALUE ( :TOKEN, now(), :E_MAIL) ";
        //         $stm = $pdo->prepare($sql);
        //         $stm->bindValue(':TOKEN', $token, PDO::PARAM_STR);
        //         $stm->bindValue(':E_MAIL', $check, PDO::PARAM_STR);
        //         $stm->execute();
        //         $pdo = null;
                
        //         //header("Location: ../controller/mail.php");
        //         //exit;
        //     }catch(PDOExseption $e){
        //         print('Error:' . $e->getMessage());
        //         die();
        //     }
        // }
    //}
    

    

?>

<!DOCTYPE html>
<html>
    <head>
        <title>新規会員仮登録</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h2>仮登録画面</h2>
        <form action="../controller/mail.php" method="POST">
            <p>メールアドレスを入力してください</p>
            <input type="text" size="30px" name="e-mail">
            <input type="hidden" name="token" value="<?=$token?>">
            <input type="submit" name="send" value="送信">
            <?php
                foreach($errors as $value){
                    echo "<p name='errors'>" . $value . "</p>";
                };
            ?>
        </form>
    </body>
</html>

