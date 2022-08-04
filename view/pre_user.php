<?php
    session_start();
    
    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
    $token = $_SESSION['token'];
    
    header('X-FRAME-OPTIONS: SAMEORIGIN');
    
    require_once('../controller/pre_user_controller.php');
        
?>
<h1>仮会員登録画面</h1>
<?php if (isset($_POST['submit']) && count($errors) === 0): ?>
    <!-- 登録完了画面 -->
    <p><?=$message?></p>
    
<?php else: ?>
<!-- 登録画面 -->
    <?php if(count($errors) > 0): ?>
        <?php
            foreach($errors as $value){
                echo "<p class='error'>".$value."</p>";
            }
        ?>
    <?php endif; ?>
    <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
        <p>メールアドレス：<input type="text" name="mail" id="mail" size="50" value="<?php if( !empty($_POST['mail']) ){ echo $_POST['mail']; } ?>"></p> 
        <input type="hidden" name="token" value="<?=$token;?>">
        <input type="submit" name="submit" value="送信">
    </form>
<?php endif; ?>