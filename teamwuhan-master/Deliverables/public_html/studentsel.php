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
 	$query = "select * from student";


  $result= mysqli_query($dbc, $query);

  echo '<center><h4>Student Selection</h4></center><div>';

  if ($result->num_rows > 0)
    {
    // output data of each row
    echo '<table style="width:100%">';
    echo '<tr><th>University ID</th><th>Advisor ID</th><th>GPA</th><th>Program</th><th>Applied to Grad?</th></tr>';
    while($row = $result->fetch_assoc())
      {
        echo "<tr><td>" . $row["unid"]. "</td><td>" . $row["advisorid"]. "</td><td>" . $row["program"]. "</td><td>" . $row["gpa"]. "</td>";
        if($row["applied_to_grad"] == 0){
          echo "<td>No</td>";
        }else{
          echo "<td>Yes></td>";
        }

        echo '</tr>';
      }
      echo '</table></div><br>';
  }
  else
  {
    echo "0 results";
  }
  $dbc->close();

?>
  <html>
    <form action="javascript:return false();" method="post">
      <label for="univID">University ID:</label><br>
      <input type="text" id="univID" name="univID"><br>
      <input type="submit" value="Search">
  	</form>
  </html>
<?php
  require_once('footer.php');
?>