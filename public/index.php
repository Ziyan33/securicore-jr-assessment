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
<link rel="stylesheet" href="/task1-weatherApp/public/css/custom-login.css">

<div class="page">
    
    <div class="container">
        <div class="left">
            <div class="login">Login</div>
            <div class="eula"><span style="color:blue">Email:test@example.com<br/>Password:password </span><br/>Task 1 requires login. Task 2 does not need login.</div>
        </div>
        <div class="right">
        <svg viewBox="0 0 320 300">
        <defs>
            <linearGradient id="linearGradient" x1="13" y1="193.49992" x2="307" y2="193.49992" gradientUnits="userSpaceOnUse">
                <stop style="stop-color:#ff00ff;" offset="0"/>
                <stop style="stop-color:#ff0000;" offset="1"/>
            </linearGradient>
        </defs>
            <path d="m 40,120.00016 239.99984,-3.2e-4 c 0,0 24.99263,0.79932 25.00016,35.00016 0.008,34.20084 -25.00016,35 -25.00016,35 h -239.99984 c 0,-0.0205 -25,4.01348 -25,38.5 0,34.48652 25,38.5 25,38.5 h 215 c 0,0 20,-0.99604 20,-25 0,-24.00396 -20,-25 -20,-25 h -190 c 0,0 -20,1.71033 -20,25 0,24.00396 20,25 20,25 h 168.57143" fill="none" stroke="url(#linearGradient)" stroke-width="4"/>
        </svg>
            <div class="form">
                <form action="index.php" method="POST">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <input type="submit" id="submit" value="Submit">
                </form>
                <?php if ($error): ?>
                    <p class="error text-danger"><?= $error ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="/task1-weatherApp/public/js/custom-login.js"></script>


<?php include '../templates/footer.php'; // Include the footer template ?>