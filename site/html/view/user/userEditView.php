<?php
session_start();

if (!(isset($_SESSION['email']))) {
    header("Location: /view/loginView.php");

} else if ($_SESSION['role'] == 0 || !isset($_COOKIE['email'])) {
    header("Location: /view/webmail/webmailView.php");
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Penguin Editor</title>
</head>
<body>
<?php
include "../navigation.php";
?>
<h1>User editor</h1>

<section>

    <h2><?= $_COOKIE['email'] ?></h2>
    <form method="POST" action="../../controller/userManagement.php">

        <input type="hidden" name="email" value="<?= $_COOKIE['email'] ?>"/>

        <label>
            New password
            <input type="password" name="password"/>
        </label>
        <label>
            Role
            <select name="role">
                <option value="0">collaborator</option>
                <option value="1" <?php echo $_COOKIE['role'] == 1 ? "selected" : null; ?> >administrator</option>
            </select>
        </label>
        <label>
            Active
            <select name="active">
                <option value="1">yes</option>
                <option value="0" <?php echo $_COOKIE['active'] == 0 ? "selected" : null; ?> >no</option>
            </select>
        </label>
        <button name="user-edit-btn-2">
            Edit
        </button>
    </form>
</section>

</body>
</html>
