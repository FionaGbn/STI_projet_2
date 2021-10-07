<?php

session_start();
if (!(isset($_SESSION['email']))) {
    header("Location:/view/loginView.php");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Change password</title>
</head>
<body>
<h3>Change password</h3>
<form method="post" action="passwordChange.php" class="options-form-box">
    <div class="classes">
        <label>
            New Password
            <input type="text" name="password" required>
        </label>
    </div>
    <button type="submit" name="changePassword">Continue</button>
</form>
</body>
</html>
