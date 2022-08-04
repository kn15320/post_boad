<?php
    $errors = array();

    function display_post(){
        global $i;

        $display_p = "<hr>";
        $display_p = $display_p . '<p>タイトル：' . $_SESSION['data'][$i]["TITLE"] . '</p>';
        $display_p = $display_p . '<p>投稿者：' . $_SESSION['data'][$i]["USER_ID_E_MAIL"] . '</p>';
        $display_p = $display_p . '<p>投稿内容：' . $_SESSION['data'][$i]["POSTED_CONTENT"] . '</p>';
        $display_p = $display_p . '<p>日時：' . $_SESSION['data'][$i]["DATE"] . '</p>';
        $_SESSION['display_p'] = $display_p;
    }

    function display_comment(){
        global $j;
        
        $br = "<br>";
        $display_c = $br . $_SESSION['data_c'][$j]["COMMENT_USER_ID"];
        $display_c = $display_c . $br . $_SESSION['data_c'][$j]["COMMENT_CONTENT"];
        $display_c = $display_c . $br . $_SESSION['data_c'][$j]["DATE"];
        $_SESSION['display_c'] = $display_c;
        
    }
    
    if(isset($_POST["submit"])){
        if(empty($_POST["title"]) || empty($_POST["post_text"])){
            $errors['errors'] = "タイトルと投稿内容を入力してください";
        }else{
            if($_REQUEST["urltoken"] == $_SESSION["urltoken"]) {
                $title = isset($_POST['title']) ? $_POST['title'] : NULL;
                $post_text = isset($_POST['post_text']) ? $_POST['post_text'] : NULL;
            
                require_once("../model/top_sql.php");
                add_function();

            }else{
                header("Location: top.php");
                exit;
            }
            
        }

    }
    
    if(isset($_POST["submit_c"])){
        if(empty($_POST["post_text_c"])){
            $errors['errors'] = "コメントを入力してください";
        }else{
            if($_REQUEST["urltoken"] == $_SESSION["urltoken"]) {
                require_once("../model/top_sql.php");
                com_function();
            }else{
                header("Location: top.php");
                exit;
            }
        }
    }

    $_SESSION["urltoken"] = $urltoken = mt_rand();

    require_once('../model/top_sql.php');
    display_p();
    
    require_once('../model/top_sql.php');
    display_C();

?>