<?php


  session_start();
	$page_title = 'GWU Advising System Catalog';

	//Load php tag into file once
  require_once('connectvars.php');
  require_once('appvars.php');
	require_once('header.php');
  require_once('navmenu.php');

  
 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  
  // Grab the user-entered log-in data   
  $query = "select crseid, title, semester, yeartaken, grade, chours from transcript, course where courseid = crseid and univerid = " . $_SESSION['uID'];       
       
  $result= mysqli_query($dbc, $query);

  echo '<center><h4>Transcript</h4></center><div>';
    

  if ($result->num_rows > 0)
    {
    // output data of each row
    echo '<table style="width:100%">';
    echo '<tr><th>Year</th><th>Semester</th><th>Course ID</th><th>Title</th><th>Grade</th><th>Credits</th></tr>';
    while($row = $result->fetch_assoc()) 
      {
        echo "<tr><td>" . $row["yeartaken"]. "</td><td>" . $row["semester"]. "</td><td>" . $row["crseid"]. "</td><td>" . $row["title"]. "</td><td>" . $row["grade"]. "</td><td>" . $row["chours"]. "</td></tr>";
      }
    echo '</table></div>';
  } 
  else 
  {
    echo "<center>No Results Found</center";
  }
  $dbc->close();
    
  require_once('footer.php');
?>