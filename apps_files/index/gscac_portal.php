<?php
  require_once('connectvars.php');

  session_start(); 

  // Clear the error message
  $error_msg = "";
  $Recommendation = "";

  // Insert the page header
  $page_title = 'GS/CAC Portal';
  require_once('header.php');
  
  echo '<hr />';
  echo '<div class="nav"><button id="btn" onclick="window.location.href = \'logout.php\';">Logout</button>
                <button id="btn" onclick="window.location.href = \'index.php\';">Profile</button></div>';
  echo '<hr />';

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $query = "SELECT * FROM applicant, application WHERE applicant.username = application.username AND recommendation != 0 AND final_decision = '' ORDER BY lname ASC";
  $data = mysqli_query($dbc, $query);
  
  while ($row = mysqli_fetch_array($data)) {
    if($row["recommendation"] == 1){
      $Recommendation = 'Reject';
    }
    else if($row["recommendation"] == 2){
      $Recommendation = 'Borderline';
    }
    else if($row["recommendation"] == 3){
      $Recommendation = 'Accept without Aid';
    }           
    else if($row["recommendation"] == 4){
      $Recommendation = 'Accept with Aid';
    }
?>

    <fieldset class="appList">
      <legend>Current Applications</legend>
      <table>
        <tr><td class="bld">Name</td><td class="bld">ApplicationID</td><td class="bld">Reviewer Recommendation</td>
        <tr><td><?php echo $row["fname"]?> <?php echo $row["lname"]?></td>
          <td><?php echo $row["applicationID"]?></td>
          <td><?php echo $Recommendation?></td>
          
          <td><a href="application_view.php?degree_type=<?php echo $row["degree_type"]?>&GRE_ScoreVerbal=<?php echo $row["GRE_ScoreVerbal"]?>&GRE_ScoreQuantitative=<?php echo $row["GRE_ScoreQuantitative"]?>&applicationID=<?php echo $row["applicationID"]?>&fname=<?php echo $row["fname"]?>&lname=<?php echo $row["lname"]?>&transID=<?php echo $row["transID"]?>&recommendation=<?php echo $row["recommendation"]?>&backPage=<?php echo 'gscac_portal.php'?>">View</a></td>
          <td><a href="decision_form.php?degree_type=<?php echo $row["degree_type"]?>&GRE_ScoreQuantitative=<?php echo $row["GRE_ScoreQuantitative"]?>&GRE_ScoreVerbal=<?php echo $row["GRE_ScoreVerbal"]?>&applicationID=<?php echo $row["applicationID"]?>&fname=<?php echo $row["fname"]?>&lname=<?php echo $row["lname"]?>&reviewer_comment=<?php echo $row["reviewer_comment"]?>&recommendation=<?php echo $Recommendation?>">Make Decision</a></td>
      </table>
    </fieldset>

<?php
  }
?>
