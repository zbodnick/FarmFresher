<?php
  session_start();
  // TODO: If the user is logged in, delete the session vars to log them out
 if(!empty($uType) || !empty($fname)){
 	$SESSION = array();
 }

  // TODO: Redirect to the index page

  $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/advising.php';
  header('Location: ' . $home_url);
	session_destroy();
?>