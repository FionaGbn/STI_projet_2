<?php
session_start();

if (!(isset($_SESSION['email']))) {
    header("Location: ../view/loginView.php");

} else if ($_SESSION['role'] == 0) {
    // not admin
    #TODO redirect to home page
}

require_once '../../databases/config.php';
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
    <title>PenguinManagement</title>
</head>
<body>
<h1>User management</h1>
<p>Here you can manage the penguins, dear <?= $_SESSION['email'] ?></p>

<section>
    <h2>Add a user</h2>
    <form method="POST" action="../controller/userManagement.php">
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
    <h2>Edit a user</h2>
    <form method="POST" action="../controller/userManagement.php">
        <?php
        require_once '../util/dynamicSelect.php';
        echo dynamic_select($userList, 'email', 'Email', ''); ?>
        <button name="user-del-btn">
            Delete
        </button>
        <button name="user-edit-btn-1">
            Edit
        </button>
    </form>
</section>

</body>
</html>
