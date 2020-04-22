<!DOCTYPE html>
<html lang="en">

<head>
    <title>Applicant Review Form</title>
    <?php 
    require_once ('header.php'); 
    session_start();
	?>

</head>

<?php

	$error_msg = "";
	
	// echo '<hr />';	
	// echo '<div class="nav"><button id="btn" onclick="window.location.href = \'index.php\';">Home Page</button></div>';
	// echo '<hr />';

	if (empty($_SESSION['id'])) {
		header("Location: login.php");
	}
	
	include ('php/connectvars.php');		
	
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  echo '<hr />';
  echo '<div class="nav"><button id="btn" onclick="window.location.href = \'reviewer_portal.php\';">Back</button></div>';
  echo '<hr />';

  $degree = $greMath = $greEnglish = $first = $last = $appid = "";
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
  //define("appliID", $appid);

  $myReview = $myComment = "";
  $myReviewErr = $myCommentErr = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST['recommendation'])){
      $myReviewErr = "Please make a recommendation";
    }
    else{
      $myReview = $_POST['recommendation'];
    }

    if(strlen($_POST['comment']) > 50){
      $myCommentErr = "Exceeded character limit of 50";
    }
    elseif(empty($_POST['comment'])){
      $myCommentErr = "Comment can't be empty";
    }
    else{
      $myComment = $_POST['comment'];
    }
  }
  //
  // -------------------------------------------------------------------------------


  
?>

<body>
    <br><br>
    <div class="container pt-3">
    <h1 class="text-primary">Review Form</h1>
    <form method="post" class="card p-5 mt-4" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <div class="row">
          <div class="col-md-6 form-group">
              <label for="fname">Name</label>                            
              <?php echo $first?> <?php echo $last?>
          </div>
          <div class="col-md-6 form-group">
              <label for="fname">Application ID</label>                            
              <?php echo $appid?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-6 form-group">
              <label for="mathscore">GRE Score - Math</label>                            
              <?php echo $greMath?>
          </div>
          <div class="col-md-6 form-group">
              <label for="englishscore">GRE Score - English</label>                            
              <?php echo $greEnglish?>
          </div>
      </div>

      <div class="row border-top pt-4 text-center">
				<div class="text-primary col-lg form-group">
					<h4>RECOMMENDATION<h4>
				</div>
			</div>


      <div class="row">

          <div class="col form-group text-danger text-center">
            Reject <input id="recommendation" name="recommendation" type="radio" value="reject" />
          </div>

          <div class="col form-group text-info text-center">
            Borderline <input id="recommendation" name="recommendation" type="radio" value="borderline" />
          </div>

          <div class="col form-group text-warning text-center">
            Accept Without Aid <input id="recommendation" name="recommendation" type="radio" value="withoutaid" />
          </div>

          <div class="col form-group text-success text-center">
            Accept With Aid <input id="recommendation" name="recommendation" type="radio" value="withaid" />
          </div>
          
          <span class="error"> <?php echo $myReviewErr;?></span><br/><br/>

      </div>

        <div class="row">
          <div class="col-lg form-group">
            <label for="comment">Add Comment</label>
            <input type="text" class="form-control form-control-lg text-muted" id="comment" name="comment" size="32"/>
            <span class="error"> <?php echo $myCommentErr;?></span>
          </div>
      </div>

      <div class="row mb-3 mt-2">
        <div class="col text-center">
            <input type="submit" id="btn" value="Submit" name="submit" class="btn btn-primary btn-lg px-5">
        </div>
     </div>
  </form>
  </div>

<?php
  
  
  if(!empty($myReview) && !empty($myComment)){
    
    $sql = "UPDATE application SET reviewer_comment = '$myComment' WHERE applicationID = $appid";
    $x = 0;
    $sql1 = "";
    if($dbc->query($sql) == true){
      if($myReview == "reject"){
        $x = 1;
        $sql1 = "UPDATE application SET recommendation = 1 WHERE applicationID = $appid";
      }
      elseif($myReview == "borderline"){
        $x = 2;
        $sql1 = "UPDATE application SET recommendation = 2 WHERE applicationID = $appid";
      }
      elseif($myReview == "withoutaid"){
        $x = 3;
        $sql1 = "UPDATE application SET recommendation = 3 WHERE applicationID = $appid";
      }
      else{
        $x = 4;
        $sql1 = "UPDATE application SET recommendation = 4 WHERE applicationID = $appid";
      }
      
     
      if($dbc->query($sql1) == true){
      echo '<br/> Thank you, you recommendation has been recorded <br/>';
      }
    }
  }

?>  
</body>
</html>
