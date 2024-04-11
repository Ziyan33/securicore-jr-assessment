<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<form action="/task1-weatherApp/src/session.php" method="post">
    
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <button type="submit">Login</button>
</form>
</body>
</html>
