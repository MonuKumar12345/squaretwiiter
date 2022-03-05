<?php 
session_start();
include("class/class_post.php");
$oPost = new \post\post();
$aPost = $oPost->gellAllFollowingUserPost($_SESSION['aUserData']['user_id']);
?>

<?php include("common/header.php") ?>
    <div class="container pt-5">
        <div class="row">
            <?php include("profile_card.php") ?>
            <div class="col-8">
                <div class="card-body postStatusBodyContainer">
                    <?php if(isset($aPost['sStatus']) && $aPost['sStatus']=='success') {
                        foreach($aPost['data'] as $post){?>
                    <div class="allPostStatusBody mt-2">
                        <div class="posthead mb-2">
                            <i class="fa fa-user"> <?php echo $post['user_name']?></i>
                        </div>
                        <div class="postBody mb-3">
                            <?php echo $post['post_body']?>
                        </div>
                        <div class="postTime"><i class="fa fa-clock-o"></i> <?php echo $post['post_created_at']?></div>
                    </div>
                    <?php } } else{ ?>
                        <p>No other post found</p>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
<?php include("common/footer.php") ?>