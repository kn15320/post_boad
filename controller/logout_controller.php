<?php
    session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit();
    }

    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
?>