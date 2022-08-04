<?php
    session_start();
    
    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
    $token = $_SESSION['token'];
    
    header('X-FRAME-OPTIONS: SAMEORIGIN');

	require_once('../controller/user_signup_controller.php');
	
?>

<h1>会員登録画面</h1>

<!-- page_3 完了画面-->
<?php if(isset($_POST['btn_submit']) && count($errors) === 0): ?>
本登録されました。
<p><a href="login.php">ログインページ</a></p>
<!-- page_2 確認画面-->
<?php elseif (isset($_POST['btn_confirm']) && count($errors) === 0): ?>
	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $_SESSION['urltoken']; ?>" method="post">
		<p>メールアドレス：<?=htmlspecialchars($_SESSION['E_MAIL'], ENT_QUOTES)?></p>
		<p>パスワード：<?=$password_hide?></p>
		<input type="submit" name="btn_back" value="戻る">
		<input type="hidden" name="token" value="<?=$_POST['token']?>">
		<input type="submit" name="btn_submit" value="登録する">
	</form>

<?php else: ?>
<!-- page_1 登録画面 -->
	<?php if(count($errors) > 0): ?>
        <?php
			foreach($errors as $value){
				echo "<p class='error'>".$value."</p>";
			}
        ?>
    <?php endif; ?>
		<?php if(!isset($errors['urltoken_timeover'])): ?>
			<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $_SESSION['urltoken']; ?>" method="post">
				<p>メールアドレス：<?=htmlspecialchars($_SESSION['E_MAIL'], ENT_QUOTES, 'UTF-8')?></p>
				<p>パスワード：<input type="password" name="password"></p>
                <input type="hidden" name="token" value="<?=$token?>">
				<input type="submit" name="btn_confirm" value="確認する">
			</form>
		<?php endif ?>
<?php endif; ?>