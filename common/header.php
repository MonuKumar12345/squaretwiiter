<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg">
            <i class="fa fa-twitter logocenter"></i>
            <?php if(isset($_SESSION['aUserData']['user_id'])){ ?>
            <a href="logout.php" class="logout"><i class="fa fa-sign-out"></i> Logout</a>
            <?php } ?>
        </nav>