<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Application</title>
    <?php 
    require_once ('header.php'); 
    session_start();
	?>
</head>

<?php

if (empty($_SESSION['id'])) {
    header("Location: login.php");
}

include ('php/connectvars.php');		

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

?>


<?php


  $degree = $greMath = $greEnglish = $first = $last = $appid = $transcript = $recommID = $back = "";
  if (isset($_GET['degree_type'])) {
    $degree = $_GET['degree_type'];
  }
  if (isset($_GET['GRE_ScoreVerbal'])) {
    $greEnglish = $_GET['GRE_ScoreVerbal'];
  }
  if (isset($_GET['GRE_ScoreQuantitative'])) {
    $greMath = $_GET['GRE_ScoreQuantitative'];
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

  // echo '<hr />';
  // if($back == "reviewer_portal.php"){
  //   echo '<div class="nav"><button id="btn" onclick="window.location.href = \'reviewer_portal.php\';">Back</button></div>';
  // }
  // if($back == "gscac_portal.php"){
  //   echo '<div class="nav"><button id="btn" onclick="window.location.href = \'gscac_portal.php\';">Back</button></div>';
  // }
  // echo '<hr />';

?>
  <body>
    <br><br>
    <div class="container pt-3">
    <h1 class="text-primary">Review Form</h1>
    <form method="post" class="card p-5 mt-4" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <div class="row">
          <div class="col-md-6 form-group">
              <label for="fname">Name </label>                            
              <?php echo $first?> <?php echo $last?>
          </div>
          <div class="col-md-6 form-group">
              <label for="fname">Degree Type</label>                            
              <?php echo $degree?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-6 form-group">
              <label for="fname">Application ID </label>                            
              <?php echo $appid?>
          </div>
          <div class="col-md-6 form-group">
              <label for="fname">Transcript ID</label>                            
              <?php echo $transcript?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-6 form-group">
              <label for="fname">GRE Score - Verbal</label>                            
              <?php echo $greEnglish?>
          </div>
          <div class="col-md-6 form-group">
              <label for="fname">GRE Score - Quantitative</label>                            
              <?php echo $greMath?>
          </div>
          <div class="col-md-6 form-group">
              <label for="fname">Recommendation</label>                            
              <?php echo $recommID?>
          </div>
      </div>
    </form>
    <div>
  </body>
</html>
