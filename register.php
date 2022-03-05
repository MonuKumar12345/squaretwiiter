<?php 
session_start();
include("class/class_user.php");
$oUser = new \user\SquareUser();
if(isset($_POST['register'])){
    $aaResult = $oUser->register($_POST);
    $_SESSION['aUserData'] = $aaResult['data'];
    if(count($aaResult['data'])>0){
        header("refresh:5;url=index.php");
    }
}
?>
<?php include("common/header.php") ?>
    <div class="container pt-5">
        <div class="card-body w-50 left-50 shadow-lg bgColor boxCenter">
            <div class="text-center">
                <h4>Register</h4>
            </div>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="name" class="form-control" id="name" aria-describedby="nameHelp" name="name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary" name="register">Register</button>
                <span class="mt-2">If user already exist, please <a href="login.php">login</span>
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