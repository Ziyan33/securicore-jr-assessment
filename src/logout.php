<?php
session_start();
$_SESSION = array();

session_destroy();
header('Location: /task1-weatherApp/public/index.php');
exit;