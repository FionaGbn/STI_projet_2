<?php
session_start();

if (!(isset($_SESSION['email']))) {
    header("Location: /view/loginView.php");

} else if ($_SESSION['role'] == 0 || !isset($_COOKIE['email'])) {
    header("Location: /view/webmail/webmailView.php");
}

// Generate anti-CSRF token
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(35));

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
<h2>User editor</h2>

<section>

    <h3><?= htmlspecialchars($_COOKIE['email'], ENT_QUOTES) ?></h3>
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
        <input type="hidden" name="token" value="<?= isset($_SESSION['token']) ? $_SESSION['token'] : '' ?>">
        <button name="user-edit-btn-2">
            Edit
        </button>
    </form>
</section>

<br/>
<a href="userManagementView.php">Return</a>

</body>
</html>
