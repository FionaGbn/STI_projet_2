<?php
session_start();

if (!(isset($_SESSION['email']))) {
    header("Location:/view/loginView.php");
}

// Generate anti-CSRF token
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(35));

require_once '../../../databases/config.php';
global $connectionDb;

$sql = "SELECT sender, subject, date_received, id FROM message WHERE receiver = :receiver ORDER BY date_received DESC";
if ($stmt = $connectionDb->prepare($sql)) {
    $stmt->bindParam(':receiver', $email);
    $email = $_SESSION['email'];
    if (!$stmt->execute()) {
        echo "ERROR";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Penguin Webmail</title>
</head>
<body>
<?php
include "../navigation.php";
?>

<h2>Inbox</h2>
<?php
if ($data = $stmt->fetchAll()) {
    foreach ($data as $row) {
        echo "<div class=\"message\">";
        echo "<h3>From: " . htmlspecialchars($row['sender'], ENT_QUOTES) . "</h3>";
        echo "<h4>Subject: " . htmlspecialchars($row['subject'], ENT_QUOTES) . "</h4>";
        echo "Date: " . htmlspecialchars($row['date_received'], ENT_QUOTES) . "<br/>";
        echo '<form name="deleteMessage" action="../../controller/actionsMessage.php" method="POST">
            <a href="createMessageView.php?sender=' . htmlspecialchars($row['sender'], ENT_QUOTES) . '">Respond</a>
            <input type="hidden" name="id"  value="' . htmlspecialchars($row['id'], ENT_QUOTES) . '">
            <input type="hidden" name="token" value="' . (isset($_SESSION['token']) ? $_SESSION['token'] : null) . '">
            <input type="submit" name="deleteItem" value="delete">
            <input type="submit" name="displayItem" value="display">
        </form>';
        echo "</div><br/>";
    }
}
?>

</body>
</html>
