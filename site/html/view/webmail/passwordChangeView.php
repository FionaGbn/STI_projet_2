<?php
session_start();
if (!(isset($_SESSION['email']))) {
    header("Location:/view/loginView.php");
}
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

    <button type="submit" name="changePassword">Change</button>
</form>

<br/>
<a href="../webmail/webmailView.php">Return</a>
</body>
</html>
