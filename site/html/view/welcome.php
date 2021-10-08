<?php
session_start();

if(!(isset($_SESSION['email']))) {
    header("Location:../view/loginView.php");
}

echo $_SESSION['email'];

#TODO provisoire
header("Location:../view/userManagementView.php");

