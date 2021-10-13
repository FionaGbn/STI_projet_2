<?php
session_start();

require_once '../../databases/config.php';
global $connectionDb;

if (!(isset($_SESSION['email']))) {
    header("Location:/view/loginView.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['changePassword']) && isset($_POST['password'])) {
        $sql = "UPDATE user SET password = :password WHERE email = :receiver";
        // Query the DB
        if ($stmt = $connectionDb->prepare($sql)) {
            $stmt->bindParam(':receiver', $email);
            $stmt->bindParam(':password', $password);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $email = $_SESSION['email'];
            if (!$stmt->execute()) {
                echo "ERROR";
            } else {
                echo "WHY";
                header("Location: /view/webmail/webmailView.php");
            }
        }
    }
}

