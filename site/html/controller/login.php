<?php
session_start();

//including the database connection
require_once '../../databases/config.php';
global $connectionDb;

if (isset($_POST['login'])) { // check the button login was clicked

    // Set login attempt if not set
    if (!isset($_SESSION['attempt'])) {
        $_SESSION['attempt'] = 0;
    }

    // Get user email and password
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email and password is not empty or null
    if (!($email == null || $password == null || empty($email) || empty($password))) {
        $sql = "SELECT * FROM user WHERE email = :email AND active;";
        // Query the DB
        if ($stmt = $connectionDb->prepare($sql)) {
            $stmt->bindParam(':email', $email);
            if ($stmt->execute()) {
                if ($row = $stmt->fetch()) {
                    $hashed_password = $row["password"];
                    if (password_verify($password, $hashed_password)) {
                        $_SESSION["role"] = $row["admin"];
                        $_SESSION["email"] = $email;
                        header("Location: /view/webmail/webmailView.php");
                        return;
                    } else {
                        $_SESSION['attempt'] += 1;
                        // After 3 attempts, user's account becomes inactive
                        if ($_SESSION['attempt'] == 3) {
                            $query = "UPDATE user SET active = 0 WHERE email = :email;";
                            if ($stmt = $connectionDb->prepare($query)) {
                                $stmt->bindParam(':email', $email);
                                $stmt->execute();
                            }
                            echo "This account has been blocked due to many failed attempts. Please contact an admin.";
                            echo '<a href="/view/loginView.php">Return</a>';
                            exit;
                        }
                    }
                }
            }
        }
        header("Location: /view/loginView.php");
        return;
    }
} else {
    echo "error";
}