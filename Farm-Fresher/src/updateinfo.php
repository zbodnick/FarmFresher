<?php

    session_start();
    $page_title = 'GWU Advising System';
    $error_msg = "";

     require_once('php/connectvars.php');
     require_once('appvars.php');
     require_once('header.php');
     require_once('navmenu.php');

     echo '<h4>Personal Information: </h4>';

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $dbc->query('SET foreign_key_checks = 0');
  //$sql = "UPDATE personalinfo SET ftname = '$_POST[fname]', ltname = '$_POST[lname]', dob = '$_POST[dob]', address = '$_POST[address]', cell = '$_POST[cell]' WHERE universid = $_POST[id]";
  $sql = "INSERT INTO personalinfo (universid, ftname, ltname, dob, address, cell) VALUES ('$_POST[id]','$_POST[fname]', '$_POST[lname]', '$_POST[dob]', '$_POST[address]', '$_POST[cell]')".
  "ON DUPLICATE KEY UPDATE ftname = '$_POST[fname]', ltname = '$_POST[lname]', dob = '$_POST[dob]', address = '$_POST[address]', cell = '$_POST[cell]'";
       if($dbc->query($sql) == TRUE)
       {
         header("refresh:1; url=changeinfo.php");
       }
       else
       {
         echo "No Update";
         echo $dbc->error;
       }

    $dbc->close();


  require_once('footer.php');
?>
