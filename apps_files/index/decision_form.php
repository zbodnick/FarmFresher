<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
  .error {color: #FF0000;}
  </style>
</head>
<body>
<?php
  require_once('connectvars.php');

  session_start();
    // Insert the page header
  $page_title = 'Applicant Review Form';
  require_once('header.php');

  echo '<hr />';
  echo '<div class="nav"><button id="btn" onclick="window.location.href = \'gscac_portal.php\';">Back</button></div>';
  echo '<hr />';

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
  //
  // -------------------------------------------------------------------------------


  
?>

  <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <fieldset>
      <legend>Decision Form</legend><br/>
      <td>Name: <?php echo $first?> <?php echo $last?></td><br/>
      <td>Apllication ID: <?php echo $appid?></td><br/>
      <td>GRE Score - Quantitative: <?php echo $greMath?></td><br/>
      <td>GRE Score - Verbal: <?php echo $greEnglish?></td><br/><br/>
      <td>Reviewer Recommendation: <?php echo $recommendation?></td><br/>
      <td>Reviewer Comment: <?php echo $comment?></td><br/>
      <br/><label for="decision">Make Decision:     </label><br/>
        Accept with Aid <input id="decision" name="decision" type="radio" value="withaid" /><br/>
        Accept <input id="decision" name="decision" type="radio" value="accept" /><br/>
        Reject <input id="decision" name="decision" type="radio" value="reject" /><br/>
        <span class="error"> <?php echo $myDecisionErr;?></span><br/><br/>
      <input type="submit" id="btn" value="Submit" name="submit" />
    </fieldset>
  </form>

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
</body>
</html>
