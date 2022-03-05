<?php 
session_start();
include("class/class_post.php");
$oPost = new \post\post();
if(isset($_POST['post'])){
    $_REQUEST['userId'] = $_SESSION['aUserData']['user_id'];
    $aaResult = $oPost->postStatus($_REQUEST);
    header("refresh:2;url=index.php");
}
$aPost = $oPost->gellAllUserPost($_SESSION['aUserData']['user_id']);
?>

<?php include("common/header.php") ?>
    <div class="container pt-5">
        <div class="row">
            <?php include("profile_card.php") ?>
            <div class="col-8">
                <div class="card-body postStatusBodyContainer">
                <div class="mt-2">
                    <?php if(isset($aaResult['sStatus']) && $aaResult['sStatus']=='success'){ set_time_limit(2);?>
                    <div class="alert alert-success"><?php echo $aaResult['message'] ?></div>
                    <?php } else if(isset($aaResult['sStatus']) && $aaResult['sStatus']=='failure') { set_time_limit(2); ?>
                        <div class="alert alert-danger"><?php echo $aaResult['message'] ?></div>
                    <?php } ?>
                </div>
                    <div class="postStatusBody">
                        <form action="" method="POST">
                            <div class="form-group">
                                <textarea name="sPostBody" class="form-control" placeholder="Post your status" rows="4"></textarea>
                            </div>
                            <div class="form-group mt-2 post_submit_button">
                                <button type="submit" class="btn text-white" name="post">POST</button>
                            </div>
                        </form>
                    </div>
                    <?php if(isset($aPost['sStatus']) && $aPost['sStatus']=='success') {
                        foreach($aPost['data'] as $post){?>
                    <div class="allPostStatusBody mt-2">
                        <div class="posthead mb-2">
                            <i class="fa fa-user"> <?php echo $_SESSION['aUserData']['user_name']?></i>
                        </div>
                        <div class="postBody mb-3">
                            <?php echo $post['post_body']?>
                        </div>
                        <div class="postTime"><i class="fa fa-clock-o"></i> <?php echo $post['post_created_at']?></div>
                    </div>
                    <?php } } else{ ?>
                        <p class="mt-3">No other post found</p>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
<?php include("common/footer.php") ?>