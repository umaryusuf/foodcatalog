<?php
// init session 
session_start();

// unset all session array to empty
$_SESSION = array();

// destroy session
session_destroy();

// redirect to login page
header("Location: login.php");
exit;
?>