<?php
    session_start();

    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
    $token = $_SESSION['token'];

    header('X-FRAME-OPTIONS: SAMEORIGIN');

    require_once('../controller/top_controller.php');
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>掲示板TOP画面</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/top.css">
    </head>
    <body>
        <div id="header">
            <div class="wrap">
                <div class="top" >掲示板TOP</div>
                <div class="top" data-target="post_comment">記事の投稿</div>
                <div class="top"><a href= "logout.php">ログアウト</a></div>
            </div>
            <div class="waku">
                <div class="totalling">
                    会員登録者数
                    <?php  require_once('../model/top_sql.php'); 
                        date_count();
                    ?> 
                    /月
                </div>
                <div class="totalling">
                    累計投稿数 
                    <?php require_once('../model/top_sql.php'); 
                        post_count();
                    ?>
                    /月
                </div>
            </div>
            <div id="article" name="article">
                <?php if(count($errors) > 0): ?>
                    <?php
                        foreach($errors as $value){
                            echo "<p class='error'>".$value."</p>";
                        }
                    ?>
                <?php endif; ?>
                                        
                <div>
                    <?php for($i = 0; $i < count($_SESSION['data']); $i++) :?>
                    <div value="<?php display_post();?>">
                        <?php print $_SESSION['display_p']; ?>
                    </div>
                    <div class="top" data-target="comment_modal" id='<?php echo $_SESSION['data'][$i]["ID"]; ?>'>                            
                        コメント
                    </div> 
                    <div>
                        <?php for($j = 0; $j < count($_SESSION['data_c']); $j++) :?>
                        <div value="<?php display_comment();?>">
                            <?php
                                if($_SESSION['data'][$i]["ID"] === $_SESSION['data_c'][$j]["POST_ID"]){
                                    print $_SESSION['display_c'];
                                }
                            ?>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <div class="modal_bg post_comment" >
            <div class="modal_content post_comment">
                <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
                    <p>タイトル：<input type="text" name="title" style="width: 255px"></p>
                    <p>投稿者：<?=htmlspecialchars($_SESSION['login'], ENT_QUOTES);?></p>
                    <p>投稿内容</p>
                    <p><textarea style="width: 255px; height: 180px" name="post_text"></textarea></p>
                    <input type="hidden" name="urltoken" value="<?php echo $urltoken;?>">
                    <p><input type="submit" name="submit" value="投稿"><button id="back">戻る</button></p>
                </form>
            </div>
        </div>
        
        <div class="modal_bg comment_modal" >
            <div class="modal_content comment_modal">
                <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
                    <input type="hidden" name="post_id" id="post_id" value="">
                    <p><textarea style="width: 255px; height: 180px" name="post_text_c"></textarea></p>
                    <input type="hidden" name="urltoken" value="<?php echo $urltoken;?>">
                    <p><input type="submit" name="submit_c" value="コメント"><button id="back">戻る</button></p>
                </form>
            </div>
        </div>

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../js/top.js"></script>
    </body>
</html>