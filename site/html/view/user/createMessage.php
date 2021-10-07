<?php
session_start();
if (!(isset($_SESSION['email']))) {
    header("Location:/view/loginView.php");
}

if (isset($_GET['sender'])) {
    $sender = $_GET['sender'];
} else {
    $sender = "";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Options</title>
</head>
<body>
<h3>New Message</h3>
<form method="post" action="actionsMessage.php" class="options-form-box">
    <div class="classes">
        <?php
        echo '<label>
            TO
            <input type="text" name="target" value="' . $sender . '" required>
        </label>'
        ?>
        <label>
            Sujet
            <input type="text" name="subject" required>
        </label>
        <label>
            Message
            <input type="text" name="body" required>
        </label>
    </div>
    <button type="submit" name="writeMessage">Continue</button>
</form>
</body>
</html>
