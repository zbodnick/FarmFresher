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

if (empty($_SESSION['id'])) {
    header("Location: login.php");
}

include ('php/connectvars.php');		

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

//   echo '<hr />';
//   echo '<div class="nav"><button id="btn" onclick="window.location.href = \'gscac_portal.php\';">Back</button></div>';
//   echo '<hr />';

  $degree = $greMath = $greEnglish = $first = $last = $appid = $comment = $recommendation = "";
  if (isset($_GET['degree_type'])) {
    $degree = $_GET['degree_type'];
  }
  if (isset($_GET['GRE_ScoreQuantitative'])) {
    $greMath = $_GET['GRE_ScoreQuantitative'];
  }
  if (isset($_GET['GRE_ScoreVerbal'])) {
    $greEnglish = $_GET['GRE_ScoreVerbal'];
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
  if (isset($_GET['reviewer_comment'])) {
    $comment = $_GET['reviewer_comment'];
  }
  if (isset($_GET['recommendation'])) {
    $recommendation = $_GET['recommendation'];
  }


  $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  $error_msg = "";


  $myDecision = "";
  $myDecisionErr = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST['decision'])){
      $myDecisionErr = "Please make a Decision";
    }
    else{
      $myDecision = $_POST['decision'];
    }
  }
?>

    <body>
        <br><br>
        <div class="container pt-3">
        <h1 class="text-primary">Decision Form</h1>
            <form method="post" class="card p-5 mt-4" action="<?php echo $_SERVER['REQUEST_URI']; ?>">


            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="fname">Name</label>                            
                    <?php echo $first?> <?php echo $last?>
                     </div>
                <div class="col-md-6 form-group">
                    <label for="appid">Application ID</label>                            
                    <?php echo $appid?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="fname">GRE Score - Quantitative</label>                            
                    <?php echo $greMath?>
                     </div>
                <div class="col-md-6 form-group">
                    <label for="appid">GRE Score - Verbal</label>                            
                    <?php echo $greEnglish?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="fname">Reviewer Recommendation</label>                            
                    <?php echo $recommendation?>
                     </div>
                <div class="col-md-6 form-group">
                    <label for="appid">Reviewer Comment</label>                            
                    <?php echo $comment?>
                </div>
            </div>

			<div class="row border-top pt-4 text-center">
				<div class="text-primary col-lg form-group">
					<h4>ADMISSION DECISION<h4>
				</div>
			</div>


            <div class="row">

                <div class="col form-group text-success text-center">
                    Accept <input id="decision" name="decision" type="radio" value="accept" /><br/>
                </div>

                <div class="col form-group text-info text-center">
                    Accept with Aid <input id="decision" name="decision" type="radio" value="withaid" /><br/>
                </div>

                <div class="col form-group text-danger text-center">
                    Reject <input id="decision" class="" name="decision" type="radio" value="reject" /><br/>
                </div>
                
                <span class="error"> <?php echo $myDecisionErr;?></span>

            </div>
                                
            <div class="row mb-3 mt-2">
                <div class="col text-center">
                    <input type="submit" id="btn" value="Submit" name="submit" class="btn btn-primary btn-lg px-5">
                </div>
            </div>

            </form>
        </div>
    </body>

<?php
  
  
  if(!empty($myDecision)){
    
    $sql1 = "";
      if($myDecision == "withaid"){
        
        $sql1 = "UPDATE application SET final_decision = 'Accept with Aid' WHERE applicationID = $appid";
      }
      elseif($myDecision == "accept"){
        
        $sql1 = "UPDATE application SET final_decision = 'Accept' WHERE applicationID = $appid";
      }
      else{
       
        $sql1 = "UPDATE application SET final_decision = 'Reject' WHERE applicationID = $appid";
      }
  
      if($dbc->query($sql1) == true){
      echo '<br/> Thank you, you decision has been recorded <br/>';
      }
  }

?>  

</html>
