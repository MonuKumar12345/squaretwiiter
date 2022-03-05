<?php 
session_start();
include("class/class_user.php");
$oUser = new \user\SquareUser();
if(isset($_POST['login'])){
    $aaResult = $oUser->login($_POST);
    $_SESSION['aUserData'] = $aaResult['data'];
    if(count($aaResult['data'])>0){
        header("refresh:2;url=index.php");
    }
}
?>
<?php include("common/header.php") ?>
<div class="container pt-5">
    <div class="card-body w-50 left-50 shadow-lg bgColor boxCenter">
        <div class="text-center">
            <h4>Login</h4>
        </div>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
            <span class="mt-2">If user not exist, please <a href="register.php">register</span>
        </form>
        <div class="mt-2">
            <?php if(isset($aaResult['sStatus']) && $aaResult['sStatus']=='success'){ ?>
            <div class="alert alert-success"><?php echo $aaResult['message'] ?></div>
            <?php } else if(isset($aaResult['sStatus']) && $aaResult['sStatus']=='failure') { ?>
                <div class="alert alert-danger"><?php echo $aaResult['message'] ?></div>
            <?php } ?>
        </div>
    </div>
</div>
<?php include("common/footer.php") ?>
