<?php
session_start();

// Including the database connection
require_once '../../databases/config.php';
global $connectionDb;

if (!(isset($_SESSION['email']))) {
    header("Location: /view/loginView.php");

} else if ($_SESSION['role'] == 0) {
    header("Location: /view/webmail/webmailView.php");

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "../view/navigation.php";
    echo "<br/>";

    // Add user
    if (isset($_POST["user-add-btn"])) {

        // Check for anti-CSRF token
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
        if (!$token || $token !== $_SESSION['token']) {
            // return 403 http status code
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
            exit;
        }

        $query = "INSERT INTO user ('email', 'password', 'admin', 'active') VALUES (:email, :password, :role, :active);";

        // Prepare the query
        if ($stmt = $connectionDb->prepare($query)) {
            // Hash the password
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Bind the params in the query
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':password', $hash);
            $stmt->bindParam(':role', $_POST['role']);
            $stmt->bindParam(':active', $_POST['active']);
            if ($stmt->execute()) {
                echo $_POST['email'] . " has been added";
            } else {
                echo "An error occurred trying to add a new user";
            }
        }
    }

    // Delete user
    else if (isset($_POST["user-del-btn"])) {

        // Check for anti-CSRF token
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
        if (!$token || $token !== $_SESSION['token']) {
            // return 403 http status code
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
            exit;
        }

        $query = "DELETE FROM user WHERE email = :email;";

        // Prepare the query
        if ($stmt = $connectionDb->prepare($query)) {

            // Bind the param in the query
            $stmt->bindParam(':email', $_POST['email']);

            if ($stmt->execute()) {
                echo $_POST['email'] . " has been deleted";
            } else {
                echo "An error occurred trying to delete the user" . $_POST['email'];
            }
        }

    }

    // Display user edition
    else if (isset($_POST["user-edit-btn-1"])) {

        // Fetch user data
        $query = "SELECT * FROM user WHERE email = :email;";

        // Prepare the query
        if ($stmt = $connectionDb->prepare($query)) {

            // Bind the param in the query
            $stmt->bindParam(':email', $_POST['email']);

            if ($stmt->execute()) {
                $row = $stmt->fetch();
                $role = $row[2];
                $active = $row[3];

                // Having fun with cookies
                setcookie("email", $_POST['email'], 0, "/view/user/userEditView.php");
                setcookie("role", $role, 0, "/view/user/userEditView.php");
                setcookie("active", $active, 0, "/view/user/userEditView.php");

                header("Location: /view/user/userEditView.php");

            } else {
                echo "An error occurred trying to fetch the data of " . $_POST['email'];
            }
        }
    }

    // Edit user
    else if (isset($_POST["user-edit-btn-2"])) {

        // Check for anti-CSRF token
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
        if (!$token || $token !== $_SESSION['token']) {
            // return 403 http status code
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
            exit;
        }

        // No new password
        if (empty($_POST['password'])) {
            $query = "UPDATE user SET admin = :role, active = :active WHERE email = :email;";
        } else {

            // Validate password strength
            $passwdIsValid = preg_match('@^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d)(?=.*[!#$%&? ";,_-]).*$@', $_POST['password']);
            if(!$passwdIsValid) {
                echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                echo '<br/><a href="/view/user/userManagementView.php">Return</a>';
                exit;
            }

            $query = "UPDATE user SET  password = :hash, admin = :role, active = :active WHERE email = :email;";
            $updatePasswd = true;
        }

        // Prepare the query
        if ($stmt = $connectionDb->prepare($query)) {

            // Bind the params in the query
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':role', $_POST['role']);
            $stmt->bindParam(':active', $_POST['active']);

            // Check if we got a new password or the previous hash
            if ($updatePasswd == true) {

                // Hash the new password
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $stmt->bindParam(':hash', $hash);
            }

            if ($stmt->execute()) {

                echo "User " . $_POST['email'] . " has been updated";

            } else {
                echo "An error occurred trying to fetch the data of " . $_POST['email'];
            }
        }
    }

    echo "<br/><br/><a href=\"../view/user/userManagementView.php\">Return</a>";

} else {
    echo "error";
}
