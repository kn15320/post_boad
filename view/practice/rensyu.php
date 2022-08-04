



    <?php 
        session_start();
        $_SESSION['dainyu']= "文字列"; 
        $_SESSION['ID'] = '66';
    ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../model/top.css">
    </head>
    <body>    
    <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
        <div class="top" data-target="comment_modal">                            
            <input type="hidden" name="post_id" id="<?php echo $_SESSION['ID']; ?>" value="<?php echo $_SESSION['ID']; ?>">
            <input type="hidden" name="post_id_i" value="<?php echo $_SESSION['dainyu']; ?>">
            <!-- <input type="submit" name="iii" value="コメント"> -->
        </div>
    </form>
        
    
            
        

        <div class="modal_bg comment_modal" >
            <div class="modal_content comment_modal">
                <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
                    <p>投稿内容:
                    
                        <?php
                            //コメントボタンをクリックしたら
                            
                            if(isset($_POST['iii'])){
                                //var_dump($_POST["iii"]);
                                var_dump($_REQUEST["post_id"]);
                                var_dump($_REQUEST['post_id_i']);
                                // foreach($_SESSION['data'] as $key => $value){
                                //var_dump($_REQUEST['post_id'] . "<br>");
                                //var_dump($value["ID"]);
                            
                                    // if($_REQUEST['post_id'] == $value["ID"]){
                                    //     echo $value["POSTED_CONTENT"];
                                    // }
                                // }
                            }
                    
                    ?>
                        
                    </p>    
                        
                    
                    <p><textarea style="width: 255px; height: 180px" name="post_text_c"></textarea></p>
                    <input type="hidden" name="urltoken" value="<?php echo $urltoken;?>">
                    <p><input type="submit" name="submit_c" value="コメント"><button id="back">戻る</button></p>
                </form>
            </div>
        </div>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../controller/top.js"></script>
    </body>
</html>