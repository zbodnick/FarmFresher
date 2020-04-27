<!DOCTYPE html>
<html lang="en">

<head>
    <title>Application Review</title>
    <?php 
    require_once ('header.php'); 
	?>
</head>

<?php

  if (empty($_SESSION['id'])) {
      header("Location: login.php");
  }

  include ('php/connectvars.php');		

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $appQ = "SELECT applicantid from reviewer_application where username=".$_SESSION['id'];
  $data = mysqli_query($dbc, $appQ);
  if (mysqli_num_rows($data)) {
    while ($row = mysqli_fetch_array($data)) {
      echo "<p>".$row['applicantid']."</p><br/>";
    }
  }

?>
</body>