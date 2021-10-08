<?php
session_start();

if (!(isset($_SESSION['email']))) {
    header("Location:/view/loginView.php");
}

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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Webmail</title>
</head>
<body class="hello">
<a href="createMessage.php">New message</a>
<a href="modifyPassword.php">Change password</a>
<a href="logout.php">Logout</a>
<?php
if ($_SESSION['role'] == 1) {
    echo '<a href="/view/userManagementView.php">Administration</a>';
}
?>
<h2>Inbox</h2>
<?php
if ($data = $stmt->fetchAll()) {
    foreach ($data as $row) {
        echo "<div class=\"message\">";
        echo "<h3> " . $row['sender'] . "</h3>";
        echo "<h4> " . $row['subject'] . "</h4>";
        echo "date_received: " . $row['date_received'] . "<br/>";
        echo '<form name="deleteMessage" action="actionsMessage.php" method="POST">
            <a href="createMessage.php?sender=' . $row['sender'] . '">Respond</a>
            <input type="hidden" name="id"  value="' . $row['id'] . '">
            <input type="submit" name="deleteItem" value="delete">
            <input type="submit" name="displayItem" value="display">
        </form>';
        echo "</div>";
    }
}
?>

</body>
</html>
