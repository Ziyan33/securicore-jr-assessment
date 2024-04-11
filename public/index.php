<?php
$pageTitle = "Login"; 
include '../templates/header.php';
include_once '../src/config.php'; 

include_once '../src/session_manager.php'; 

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: ../templates/main.php");
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

<div class="container">
<h2>Login</h2>
<?php if ($error): ?>
    <p class="error text-danger"><?= $error ?></p>
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

<?php include '../templates/footer.php'; // Include the footer template ?>