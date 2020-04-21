<?php
  require_once('connectvars.php');

  session_start(); 

  // Clear the error message
  $error_msg = "";

  // Insert the page header
  $page_title = 'Reviewer Portal';
  require_once('header.php');
  
  echo '<hr />';
  echo '<div class="nav"><button id="btn" onclick="window.location.href = \'logout.php\';">Logout</button>
    <button id="btn" onclick="window.location.href = \'index.php\';">Profile</button></div>';
  echo '<hr />';
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $query = "SELECT * FROM applicant, application WHERE applicant.username = application.username AND completion = 1 AND recommendation = 0 ORDER BY lname ASC";
  $data = mysqli_query($dbc, $query);
  while($row = mysqli_fetch_array($data))
    {
?>

    <fieldset class="appList">
      <legend>Current Applications</legend>
      <table>
        <tr><td class="bld">Name</td><td class="bld">Degree Type</td><td class="bld">Application ID</td>
        <tr><td><?php echo $row["fname"]?> <?php echo $row["lname"]?></td>
        	<td><?php echo $row["degree_type"]?></td>
        	<td><?php echo $row["applicationID"]?></td>
        	<td><a href="application_view.php?degree_type=<?php echo $row["degree_type"]?>&GRE_ScoreVerbal=<?php echo $row["GRE_ScoreVerbal"]?>&GRE_ScoreQuantitative=<?php echo $row["GRE_ScoreQuantitative"]?>&applicationID=<?php echo $row["applicationID"]?>&fname=<?php echo $row["fname"]?>&lname=<?php echo $row["lname"]?>&transID=<?php echo $row["transID"]?>&recommendation=<?php echo $row["recommendation"]?>&backPage=<?php echo 'reviewer_portal.php'?>">View</a></td>
        	<td><a href="review_form.php?degree_type=<?php echo $row["degree_type"]?>&GRE_ScoreVerbal=<?php echo $row["GRE_ScoreVerbal"]?>&GRE_ScoreQuantitative=<?php echo $row["GRE_ScoreQuantitative"]?>&applicationID=<?php echo $row["applicationID"]?>&fname=<?php echo $row["fname"]?>&lname=<?php echo $row["lname"]?>">Review</a></td>
      </table>
    </fieldset>

<?php
  }
?>
