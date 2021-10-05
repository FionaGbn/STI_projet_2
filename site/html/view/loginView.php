<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>PenguLogin</title>
</head>
<body>
<form method="POST" action="../controller/login.php">
    <label>
        Email
        <input type="text" name="email" required="required"/>
    </label>
    <label>
        Password
        <input type="password" name="password" required="required"/>
    </label>
    <button name="login">
        Login
    </button>
</form>
</body>
</html>