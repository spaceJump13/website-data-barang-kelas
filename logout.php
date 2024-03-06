<?php
include 'config.php';
session_destroy();
session_unset();
unset($_SESSION['login']);
// redirect to login page
header("Location: index.php");
exit;
?>