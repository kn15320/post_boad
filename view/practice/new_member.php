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

    if(empty($_GET)){
        
        //仮登録の画面に戻す
        header("Location: ./temporary registration.php");
        exit();
        
    }else{
        //GETデータを変数にいれる
        $urltoken = isset($_GET["token"]) ? $_GET["token"] : NULL;
        var_dump($_GET["token"]);
        //メール入力判定
        if($urltoken === '' ){
            //トークンエラーページに遷移する
            header("Location: ./token_error.php");
            exit();
            
        }else{
            //仮登録日から60分以内
            try{
                //echo 'jiko';
                $sql = "SELECT E_MAIL FROM st2109005_kawamura.pre_user WHERE TOKEN=(:TOKEN) AND flag =0 AND DATE > now() - interval 60 minute";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':TOKEN', $urltoken, PDO::PARAM_STR);
                var_dump($urltoken);
                $stmt->execute();

                //レコード件数獲得
                $row_count = $stmt->rowCount();
                //var_dump($row_count);
                //10分以内に仮登録され、本登録されていないトークンの場合
                if($row_count == 1){
                    echo '実行';
                    $mail_array = $stmt->fetch();
                    $mail = $mail_array["E_MAIL"];
                    $_SESSION["E_MAIL"] = $mail;
                    var_dump($_SESSION["E_MAIL"]);
                }else{
                    $errors['errors'] = "このURLは利用できません。有効期限が過ぎたかURLが間違えている可能性がございます。もう一度やり直してください。";
                }
                $stmt = null;
            }catch(PDOExeception $e){
                print('Error:' . $e->getMessage());
                die();
            }
        }
    }

    if(isset($_POST['submit'])){
        $password = isset($_POST['password']) ? $_POST['password'] : NULL;

        $_SESSION['password'] = $password;

        if($password === ""){
            $errors["password-comment"] = "パスワードが入力されていません";
        }

        
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>新規会員登録</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>会員登録</h1>
        <form action="./register.php" method="POST">
            <table>
                <tr>
                    <td>メールアドレス</td><td colspan="3"></td>
                </tr>
                <tr>
                    <td><?=htmlspecialchars($_SESSION["E_MAIL"], ENT_QUOTES)?></td><td colspan="3"></td>
                </tr>
                <tr>
                    <td colspan="4" id="userid-comment"></td>

                </tr>
                <tr>
                    <td>パスワード</td><td colspan="3"></td>
                </tr>
                <tr>
                    <td><input type="password" size="30px" name="password" id="password"></td><td colspan="3"></td>
                </tr>
                <tr>
                    <td colspan="4" name="password-comment" id="password-comment"></td>
                </tr>
                <tr>
                    <td colspan="2"></td><td><input type="submit" name="submit" value="登録"></td>
                </tr>
                <tr>
                <?php
                    foreach($errors as $value){
                        echo "<td name='errors'>" . $value . "</td>";
                    };
                ?>
                </tr>
            </table>
        </form>
    </body>
</html>