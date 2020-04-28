<?php
  require_once('connectvars.php');

  session_start(); 

  // Clear the error message
  $error_msg = "";

  // Insert the page header
  $page_title = 'Applicant Portal';
  require_once('header.php');
  
  echo '<hr />';
  echo '<div class="nav"><button id="btn" onclick="window.location.href = \'logout.php\';">Logout</button>
                <button id="btn" onclick="window.location.href = \'index.php\';">Profile</button></div>';
  echo '<hr />';
?>

    <fieldset class="appList">
      <legend>Current Applications</legend>
      <table>
        <tr><td class="bld">School</td><td class="bld">Status</td>
        <?php
          $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
          $query = "SELECT * FROM application JOIN reviewer_application ON application.username=reviewer_application.applicantID WHERE application.username='".$_SESSION['username']."'"; 
          $data = mysqli_query($dbc, $query);

          // If The log-in is OK 
          if (mysqli_num_rows($data) == 1) {
            while ($row = mysqli_fetch_array($data))
            {
              echo '<tr><td>'.$row['applicationID'].'</td><td>'.$row['status'].'</td><td id="btnSq"><form method="post" action="application_view.php" target="_blank"><button type="submit" name="view" value="'.$row['applicationID'].'" id="view">View</button></form></td>';
            }
          }

          //displaying the schools and status
          $query = "select degree_type, final_decision from application where username = '".$_SESSION['username']."'";
          $data = mysqli_query($dbc, $query);

          //checking to see if there are any rows returned
            while ($row = mysqli_fetch_array($data))
            {
              echo '<tr><td>'.$row['degree_type'].'</td>';
              if(strcmp($row['final_decision'], "")==0)
              {
                echo'<td>decision pending</td>';
              }
              else
              {
                echo '<td>'.$row['final_decision'].'</td>';
              }
              
            }


        ?>
      </table>
    </fieldset>
  </body>    
</html>
