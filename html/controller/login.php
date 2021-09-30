<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//including the database connection
require_once '../../databases/config.php';
global $connectionDb;

if (isset($_POST['login'])) { // check the button login was clicked

    // Get user email and password
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email and password is not empty or null
    if (!($email == null || $password == null || empty($email) || empty($password))) {

        // Query the DB
        $query = $connectionDb->query("SELECT * FROM user WHERE email='{$email}' AND active;");

        foreach($query as $row) {
            echo "Id: " . $row['email'] . "<br/>";
            echo "<br/>";
        }

        /*
        if (sizeof($query) == 1) {
            $password_test = $query['password'];
            echo $password_test;
            if (password_verify($password, $password_test)) { // <-

                $role = $query[0]['admin'];

                $_SESSION["role"] = $role;
                $_SESSION["email"] = $email;
                header("Location: ../view/welcome.php");
                return;
            }
            echo "PASSWORD INVALID";
        }
        */

        echo "fuck";
    }
//    session_destroy();
//    header("Location: ../view/loginView.php");
//    return;
} else {
    echo "error";
}
