<?php
session_start();
if (!(isset($_SESSION['email']))) {
    header("Location:/view/loginView.php");
}

// Generate anti-CSRF token
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(35));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Penguin new password</title>
</head>
<body>
<?php
include "../navigation.php";
?>

<h2>Change password</h2>
<form method="post" action="../../controller/passwordChange.php">

    <label>
        New Password
        <input type="password" name="password" required>
    </label>
    <input type="hidden" name="token" value="<?= isset($_SESSION['token']) ? $_SESSION['token'] : '' ?>">

    <button type="submit" name="changePassword">Change</button>
</form>

<br/>
<a href="../webmail/webmailView.php">Return</a>
</body>
</html>
