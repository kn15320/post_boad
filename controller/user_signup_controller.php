<?php
    $errors = array();
    
    if(empty($_GET)) {
		header("Location: ./pre_user.php");
		exit();
	}else{
		$_SESSION['urltoken'] = isset($_GET["urltoken"]) ? $_GET["urltoken"] : NULL;
		
		if ($_SESSION['urltoken'] == ''){
			$errors['urltoken'] = "トークンがありません。";
		}else{
			try{
				require_once('../model/user_signup_sql.php');
				token();
				
				if($_SESSION['row_count'] >= 1){
					$decrypted = hex2bin($_SESSION['d_E_MAIL']);
					$_SESSION['E_MAIL'] = $decrypted;
				}else{
					$errors['urltoken_timeover'] = "このURLはご利用できません。有効期限が過ぎたかURLが間違えている可能性がございます。もう一度登録をやりなおして下さい。";
					$pdo = null;
				}
				
			}catch (PDOException $e){
				print('Error:'.$e->getMessage());
				die();
			}
		}
	}

	if(isset($_POST['btn_confirm'])){
		if(empty($_POST)) {
			header("Location: ./pre_user.php");
			exit();
		}else{
			$password = isset($_POST['password']) ? $_POST['password'] : NULL;
			
			$_SESSION['password'] = $password;
			
			if ($password == ''):
				$errors['password'] = "パスワードが入力されていません。";
			else:
				$password_hide = str_repeat('*', strlen($password));
			endif;
			
		}
	}

	if(isset($_POST['btn_submit'])){
		try{
			require_once('../model/user_signup_sql.php');
			user_add();
			
			$pdo = null;

			$_SESSION = array();
			
			if (isset($_COOKIE["PHPSESSID"])) {
				setcookie("PHPSESSID", '', time() - 1800, '/');
			}
			
		}catch (PDOException $e){
			$errors['error'] = "もう一度やりなおして下さい。";
			print('Error:'.$e->getMessage());
		}
	}

?>