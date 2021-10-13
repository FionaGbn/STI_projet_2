<nav>
    <a href="/view/webmail/webmailView.php">Home</a> |
    <a href="/view/webmail/createMessageView.php">New message</a> |
    <a href="/view/webmail/passwordChangeView.php">Change password</a> |
    <?php
    session_start();
    if ($_SESSION['role'] == 1) {
        echo '<a href="/view/user/userManagementView.php">Administration</a> | ';
    }
    ?>
    <a href="/controller/logout.php">Logout</a>
</nav>