<?php
include_once '../src/config.php'; 

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Enable this only if your site uses HTTPS
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: main.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
    if ($_POST['email'] === USER_EMAIL && password_verify($_POST['password'], USER_PASSWORD)) {
        $_SESSION['logged_in'] = true;
        header("Location: ../templates/main.php");
        exit;
    } else {
        $error = 'Invalid credentials!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { display: flex; height: 100vh; align-items: center; justify-content: center; }
        .container { width: 300px; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign In</button>
        </form>
    </div>
</body>
</html>
