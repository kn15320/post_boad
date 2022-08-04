<?php

    //データベース呼び出し
    require_once "functions/db.php";
    //URLパラメータ取得
    $editId = $_GET["edit"];

    //URLパラメータからidを受け取り、該当のユーザーを検索
    $userdataEdit = "select * from userdata where id = '".$editId."' order by id DESC"; 
    $userdataEdit = mysqli_query($mysqli,$userdataEdit);
    
    while ($userdataEditArray = mysqli_fetch_assoc($userdataEdit)) {
        $name = $userdataEditArray["name"];
        $age = $userdataEditArray["age"];
        $skill = $userdataEditArray["skill"];
        //新しく会員登録やログインに必要なメールとパスワードが追加。
        $mail = $userdataEditArray["mail"];
        //$hashpassは暗号化されたパスワードという意味。
        $hashpass = $userdataEditArray["password"];
    };
    
    //存在したユーザー数カウント。
    $userCount = $userdataEdit->num_rows;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        //ポストされたデータをキャッチします。
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
        $age = htmlspecialchars($_POST['age'], ENT_QUOTES);
        $skill = htmlspecialchars($_POST['skill'], ENT_QUOTES);
    
        //メールアドレスとパスワードをキャッチします。
        $mail = htmlspecialchars($_POST['mail'], ENT_QUOTES);
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES);
    
        //メールアドレスが正しいメールアドレスかどうかを確認する関数です。
        function mailcheck($mail){
            //こちらの記号は正規表現と言います。
            //今回は、メールアドレスの形を表しています。
            //正規表現で$mail内に入っているデータがメールアドレスの形じゃなければfalseを返します。
            if(preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD', $mail)){
                return 'true';
            }else{
                return 'false';
            }
        };
        
        //$mailが空じゃなければバリデーションチェック呼び出します。
        //空の場合は$mailresultにfalseを返します。
        if(!empty($mail)){
            $mailresult = mailcheck($mail);
        }else{
            $mailresult = "false";
        };
    
        //パスワード暗号化と空欄チェックを行います。
        if(!empty($password)){
            //パスワードは、管理者にも知られてはいけません。
            //必ず、受けとったパスワードのデータを暗号化します。
            //$passwordに文字列が入っていれば、それが暗暗号化され$hashpassに入ります。
            $hashpass = password_hash($password, PASSWORD_BCRYPT);
        };
        
        //もし暗号化されたパスワードが$hashpassになければ$passresultがfalseに。
        if(empty($hashpass)){
            $passresult = "false";
        };
        
        //すでにユーザーが存在していた場合はアップデート。
        //メールアドレスとパスワードが入力されていた場合に実行。
        if($userCount !== 0&&$mailresult!=="false"&&$passresult!=="false"){         
            $result = mysqli_query($mysqli,"update userdata set name = '".$name."',age = '".$age."',skill = '".$skill."',mail = '".$mail."',password = '".$hashpass."' where id = '".$editId."'");
            echo "アップデート完了";
        }
        
        if($userCount == 0&&$mailresult!=="false"&&$passresult!=="false"){
            //$userCountが0だった場合は新規で登録。
            //メールアドレスとハッシュパスがあれば登録可能。
            $result = mysqli_query($mysqli,"insert into userdata(name,age,skill,mail,password) VALUES('$name','$age','$skill','$mail','$hashpass')");
            echo "新規登録完了";
        };
        
    };
?>      
<div style="padding-bottom:15px;">
    <a href="https://base91.net/mission/php/9/">新規追加</a>
</div>

<h1>登録フォーム</h1>
<form method="post" action="">        
    <input type="text" name="mail" placeholder="メールアドレス" value="<?php echo $mail; ?>" /><br/>
    <!--もし$mailresultがfalseの場合はエラー表示。-->
    <?php if($mailresult == "false"){echo "メールアドレスにエラーがあります。<br/>";}; ?>
    <input type="password" name="password" placeholder="パスワード" value="" /><br/>
    <!--もし$passresultがfalseの場合はエラー表示。-->
    <?php if($passresult == "false"){echo "パスワードにエラーがあります。<br/>";}; ?>
    <input type="text" name="name" placeholder="お名前" value="<?php echo $name; ?>" /><br/>
    <input type="text" name="age" placeholder="年齢" value="<?php echo $age; ?>" /><br/>
    <input type="text" name="skill" placeholder="スキル" value="<?php echo $skill; ?>" /><br/>
    <?php if($userCount == 0): ?>
    <input type="submit" name="submitBtn" value="登録" />
    <?php else: ?>
    <input type="submit" name="submitBtn" value="更新" />
    <?php endif; ?>
</form>

<?php
    
    //投稿データ一覧
    $userdata = "select * from userdata order by id DESC"; 
    $userdata = mysqli_query($mysqli,$userdata);
    
    while ($userdataArray = mysqli_fetch_assoc($userdata)) {
        echo $id = $userdataArray["id"];
        echo ",";
        echo $name = $userdataArray["name"];
        echo ",";
        echo $age = $userdataArray["age"];
        echo ",";
        echo $skill = $userdataArray["skill"];
        echo "｜";
        echo "<button class='deleteBtn' data-id='".$id."'>削除する</button>";
        echo "｜";
        echo "<button class='editBtn' data-id='".$id."'>編集する</button>";
        echo "<br>";
    };
        
?>