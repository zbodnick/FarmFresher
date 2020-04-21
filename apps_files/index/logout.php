<?php
	session_start();

	$home_url = "index.php";

	if (isset($_SESSION['username'])) {
		$_SESSION = array();
		session_destroy();
		header('Location: ' . $home_url);
	}	 

	header('Location: ' . $home_url);
?>
