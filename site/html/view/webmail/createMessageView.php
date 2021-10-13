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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Penguin New Message</title>
</head>
<body>
<?php
include "../navigation.php";
?>
<h1>Webmail</h1>

<section>
    <h2>New Message</h2>
    <form method="post" action="../../controller/actionsMessage.php">
        <label>
            To
            <input type="text" name="target" value="<?= $sender ?>" required>
        </label>

        <label>
            Subject
            <input type="text" name="subject" required>
        </label>

        <label>
            Body
            <input type="text" name="body" width="90px" height="90px" required>
        </label>

        <button type="submit" name="writeMessage">Send</button>
    </form>
</section>

<section>
    <a href="../webmail/webmailView.php">Return</a>
</section>

</body>
</html>
