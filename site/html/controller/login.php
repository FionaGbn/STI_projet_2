<?php
session_start();

//including the database connection
require_once '../../databases/config.php';
global $connectionDb;

if (isset($_POST['login'])) { // check the button login was clicked

    // Get user email and password
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email and password is not empty or null
    if (!($email == null || $password == null || empty($email) || empty($password))) {
        $sql = "SELECT * FROM user WHERE email= :email AND active;";
        // Query the DB
        if ($stmt = $connectionDb->prepare($sql)) {
            $stmt->bindParam(':email', $email);
            if ($stmt->execute()) {
                if ($row = $stmt->fetch()) {
                    $hashed_password = $row["password"];
                    if (password_verify($password, $hashed_password)) {
                        $role = $row[0]['admin'];
                        $_SESSION["role"] = $role;
                        $_SESSION["email"] = $email;
                        header("Location: ../view/user/userView.php");
                        return;
                    }
                }
            }
        }
        session_destroy();
        header("Location: ../view/loginView.php");
        return;
    }
} else {
    echo "error";
}