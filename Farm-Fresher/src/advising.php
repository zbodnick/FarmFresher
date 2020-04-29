<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <img src="gwuadvising.png" style="width:300px;height:169px;">
  </head>
</html>

<?php
  session_start();
	$page_title = 'GWU Advising System';


	//Load php tag into file once
  require_once('php/connectvars.php');
  require_once('appvars.php');
	require_once('header.php');
  require_once('navmenu.php');





 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $dbc->query('SET foreign_key_checks = 0');
  require_once('footer.php');

?>
