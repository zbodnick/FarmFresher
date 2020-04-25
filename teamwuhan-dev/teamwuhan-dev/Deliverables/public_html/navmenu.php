<?php
  // Generate the navigation menu
  echo '<hr />';
  if (isset($_SESSION['uType'])) {
    //Set different buttons up for pages depending on
    echo '<a href="advising.php">Home</a> ';
    if(strcmp($_SESSION['uType'], 'Student') == 0){
      echo '<a href="enrollment.php">View Enrollment</a> ';
      echo '<a href="form1.php">Form 1</a> ';
      echo '<a href="applygraduate.php">Apply to Graduate</a> ';
    }
    else if(strcmp($_SESSION['uType'], 'alumni') == 0){
      echo '<a href="enrollment.php">View Final Transcript</a> ';
    }
    else if(strcmp($_SESSION['uType'], 'gs') == 0){
      echo '<a href="studentsel.php">Student Data</a> ';
    }
    else if(strcmp($_SESSION['uType'], 'advisor') == 0){
      echo '<a href="studentsel.php">Student Data</a> ';
    }
    else if(strcmp($_SESSION['uType'], 'admin') == 0){
      echo '<a href="newuser.php">Create a New User</a> ';
      echo '<a href="studentsel.php">Student Data</a> ';
      echo '<a href="reset.php">Reset</a> ';
    }
    echo '<a href="changeinfo.php">Change Pers. Info</a> ';
    echo '<a href="logout.php">Log Out (' . $_SESSION['uType'] . ')</a>';

  }
  else {
    echo '<a href="advising.php">Home</a> ';
    echo '<a href="login.php">Log In</a> ';
  }
  echo '<hr />';
?>
