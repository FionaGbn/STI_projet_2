<?php
session_start();

require_once '../../databases/config.php';
global $connectionDb;

if (!(isset($_SESSION['email']))) {
    header("Location:/view/loginView.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check for anti-CSRF token
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    if (!$token || $token !== $_SESSION['token']) {
        // return 403 http status code
        header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
        exit;
    }

    if (isset($_POST['changePassword']) && isset($_POST['password'])) {

        // Validate password strength
        $passwdIsValid = preg_match('@^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d)(?=.*[!#$%&? ";,_-]).*$@', $_POST['password']);

        if(!$passwdIsValid) {
            echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
            echo '<br/><a href="/view/webmail/passwordChangeView.php">Return</a>';
        } else {
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
}

