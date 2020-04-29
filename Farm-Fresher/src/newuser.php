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

  echo '<h4>Create New User </h4>';

  if (isset($_SESSION['id']))
  {

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $dbc->query('SET foreign_key_checks = 0');
  $id = $_SESSION['id'];

       if (empty($_SESSION['id']))
       {
         echo '<p class="error">' . $error_msg . '</p>';
       }

       //FORM TO CREATE USER
       echo "<form action= createuser.php method = post> <br>";
       echo "Type of User: "."<input type = text  name = typeofuser value = ''> <br>";
       echo "ID: "."<input type = text  name = email value = ''> <br>";
       echo "Password: "."<input type = text  name = password value = ''> <br>";
       echo "<input type = submit>";
       echo "</form>";
       echo '<br>';



 $dbc->close();
 }

  require_once('footer.php');
?>
