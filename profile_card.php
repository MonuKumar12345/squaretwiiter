<?php
session_start();
if(!isset($_SESSION['aUserData']['user_id'])){
    header("Location: login.php");
}
?>
<div class="col-4">
    <div class="card-body shadow-lg profileCard">
        <div class="profilecardhead">
            <div class="profile-user-icon"><i class="fa fa-user"> <?php echo $_SESSION['aUserData']['user_name'] ?></i></div>
            <div class="profile-email-icon"><i class="fa fa-envelope"> <?php echo $_SESSION['aUserData']['user_email'] ?></i></div>
        </div>
        <div class="profilecardbottom">
            <!-- <div class="row">
            <div class="col-4">
                <div class="profileStatsHead">Post</div>
                <div class="profileStatsBottom">5</div>
                </div>
            <div class="col-4">
                <div class="profileStatsHead">Following</div>
                <div class="profileStatsBottom">5</div>
            </div>
            <div class="col-4">
                <div class="profileStatsHead">Follow</div>
                <div class="profileStatsBottom">5</div>
            </div>
            </div> -->
            <a href="post_status.php"><i class="fa fa-sticky-note-o"></i>&nbsp;&nbsp;See All post</a>
        </br>
           <a href="all_user.php"><i class="fa fa-user"></i>&nbsp;&nbsp;See All Users</a>  
        </br>
          <a href="userPost.php"><i class="fa fa-sticky-note-o"></i>&nbsp;&nbsp;See All following user`post</a>
        </br>
            <a href="following_user.php"><i class="fa fa-user"></i>&nbsp;&nbsp;See All following user</a>
        </div>
    </div>
</div>