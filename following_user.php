<?php 
session_start();
include("class/class_user.php");
$oUser = new \user\SquareUser();
if(isset($_POST['following'])){
    $_REQUEST['userId'] = $_SESSION['aUserData']['user_id'];
    $aaResult = $oUser->followUser($_REQUEST);
    header("refresh:2;url=all_user.php");
}
$aUsers = $oUser->gellAllUserFollowing($_SESSION['aUserData']['user_id']);
?>

<?php include("common/header.php") ?>
    <div class="container pt-5">
        <div class="row">
            <?php include("profile_card.php") ?>
            <div class="col-8">
                <div class="card-body postStatusBodyContainer">
                <div class="mt-2">
                    <?php if(isset($aaResult['sStatus']) && $aaResult['sStatus']=='success'){?>
                    <div class="alert alert-success"><?php echo $aaResult['message'] ?></div>
                    <?php } else if(isset($aaResult['sStatus']) && $aaResult['sStatus']=='failure') { ?>
                        <div class="alert alert-danger"><?php echo $aaResult['message'] ?></div>
                    <?php } ?>
                </div>
                <div class="row">
                    <?php if(isset($aUsers['sStatus']) && $aUsers['sStatus']=='success') {
                        foreach($aUsers['data'] as $user){?>
                    <div class="col-4 mb-2">
                        <div class="card">
                            <div class="followingUserImg">
                                <img src="images/avatar.svg" />
                            </div>
                            <hr>
                            <div class="userDetails">
                                <div class="profile-user-icon"><i class="fa fa-user"> <?php echo $user['user_name'] ?></i></div>
                                <div class="profile-email-icon"><i class="fa fa-envelope"> <?php echo $user['user_email'] ?></i></div>
                            </div>
                            <div class="text-center">
                                <div type="button" class="text-white followingBtn">Following  <i class="fa fa-check text-white"></i></div>                          
                            </div>
                        </div>
                    </div>
                    <?php } } else{ ?>
                        <p>No other user found</p>
                    <?php }?>
                </div>
                </div>
            </div>
        </div>
    </div>
<?php include("common/footer.php") ?>