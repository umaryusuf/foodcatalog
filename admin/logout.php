<?php
// init session 
session_start();
if (!isset($_SESSION['admin'])) {
	header("location: index.php");
}

// unset all session array to empty
$_SESSION = array();

// destroy session
session_destroy();

// redirect to login page
header("Location: index.php");
exit;
?>