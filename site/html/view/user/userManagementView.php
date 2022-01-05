<?php
session_start();

if (!(isset($_SESSION['email']))) {
    header("Location: /view/loginView.php");

} else if ($_SESSION['role'] == 0) {
    header("Location: /view/webmail/webmailView.php");
}

require_once '../../../databases/config.php';
global $connectionDb;

$query = "SELECT email FROM user";

// Query the DB to get all emails
$userList = array();
if ($stmt = $connectionDb->prepare($query)) {
    if ($stmt->execute()) {
        foreach ($stmt->fetchAll() as $row) {
            $userList[$row[0]] = $row[0]; // $array[$key] = $value
        }
    }
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Penguin Management</title>
</head>
<body>
<?php
include "../navigation.php";
?>
<h2>User management</h2>
<p>Here you can manage the users, dear <?= htmlspecialchars($_SESSION['email'], ENT_QUOTES) ?></p>

<section>
    <h3>Add a user</h3>
    <form method="POST" action="../../controller/userManagement.php">
        <label>
            Email
            <input type="text" name="email" required="required"/>
        </label>
        <label>
            Password
            <input type="password" name="password" required="required"/>
        </label>
        <label>
            Role
            <select name="role">
                <option value="0">collaborator</option>
                <option value="1">administrator</option>
            </select>
        </label>
        <label>
            Active
            <select name="active">
                <option value="1">yes</option>
                <option value="0">no</option>
            </select>
        </label>
        <button name="user-add-btn">
            Add
        </button>
    </form>
</section>

<section>
    <h3>Edit a user</h3>
    <form method="POST" action="../../controller/userManagement.php">
        <?php
        require_once '../../util/dynamicSelect.php';
        echo dynamic_select($userList, 'email', 'Email', ''); ?>
        <button name="user-del-btn">
            Delete
        </button>
        <button name="user-edit-btn-1">
            Edit
        </button>
    </form>
</section>

<br/>

<a href="../webmail/webmailView.php">Return</a>

</body>
</html>
