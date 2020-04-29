<?php
  require_once('connectvars.php');

  session_start(); 

  // Clear the error message
  $error_msg = "";

  // Insert the page header
  $page_title = 'Student Application';
  require_once('header.php');

  $degree = $greMath = $greEnglish = $first = $last = $appid = $transcript = $recommID = $back = "";
  if (isset($_GET['degree_type'])) {
    $degree = $_GET['degree_type'];
  }
  if (isset($_GET['GRE_ScoreVerbal'])) {
    $greMath = $_GET['GRE_ScoreVerbal'];
  }
  if (isset($_GET['GRE_ScoreQuantitative'])) {
    $greEnglish = $_GET['GRE_ScoreQuantitative'];
  }
  if (isset($_GET['applicationID'])) {
    $appid = $_GET['applicationID'];
  }
  if (isset($_GET['fname'])) {
    $first = $_GET['fname'];
  }
  if (isset($_GET['lname'])) {
    $last = $_GET['lname'];
  }
  if (isset($_GET['transID'])) {
    $transcript = $_GET['transID'];
  }
  if (isset($_GET['recommendation'])) {
    $recommID = $_GET['recommendation'];
  }
  if (isset($_GET['backPage'])) {
    $back = $_GET['backPage'];
  }

  echo '<hr />';
  if($back == "reviewer_portal.php"){
    echo '<div class="nav"><button id="btn" onclick="window.location.href = \'reviewer_portal.php\';">Back</button></div>';
  }
  if($back == "gscac_portal.php"){
    echo '<div class="nav"><button id="btn" onclick="window.location.href = \'gscac_portal.php\';">Back</button></div>';
  }
  echo '<hr />';

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

?>
 <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <fieldset>
      <legend>Review Form</legend><br/>
      <td>Name: <?php echo $first?> <?php echo $last?></td><br/><br/>
      <td>Apllication ID: <?php echo $appid?></td><br/><br/>
      <td>GRE Score - Verbal: <?php echo $greMath?></td><br/><br/>
      <td>GRE Score - Quantitative: <?php echo $greEnglish?></td><br/><br/>
      <td>Recommendation: <?php echo $recommID?></td><br/><br/>
      <td>Transcript ID: <?php echo $transcript?></td><br/><br/>
      <td>Degree Type: <?php echo $degree?></td><br/><br/>
    </fieldset>
  </form>
</body>
</html>
