<?php
session_start();
if (!(isset($_SESSION['email']))) {
    header("Location:/view/loginView.php");
}

// Generate anti-CSRF token
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(35));

// Get the sender
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
<section>
    <h2>New Message</h2>
    <form method="post" action="../../controller/actionsMessage.php">

        <label>
            To:
            <input type="text" name="target" value="<?= $sender ?>" required>
        </label>
        <br/>

        <label>
            Subject:
            <input type="text" name="subject" required>
        </label>

        <br/>

        <label>
            Body:
            <br/>
            <textarea name="body" rows="10" cols="50" required></textarea>
        </label>
        <br/>
        <input type="hidden" name="token" value="<?= isset($_SESSION['token']) ? $_SESSION['token'] : '' ?>">
        <button type="submit" name="writeMessage">Send</button>

    </form>
</section>

<br/>
<a href="../webmail/webmailView.php">Return</a>

</body>
</html>
