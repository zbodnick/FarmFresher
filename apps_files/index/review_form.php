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


  $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  $error_msg = "";


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

  <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <fieldset>
      <legend>Review Form</legend><br/>
      <td>Name: <?php echo $first?> <?php echo $last?></td><br/>
      <td>Apllication ID: <?php echo $appid?></td><br/>
      <td>GRE Score - Math: <?php echo $greMath?></td><br/>
      <td>GRE Score - English: <?php echo $greEnglish?></td><br/>
      <br/><label for="recommendation">Your Recommedation:     </label><br/>
        Reject <input id="recommendation" name="recommendation" type="radio" value="reject" /><br/>
        Borderline <input id="recommendation" name="recommendation" type="radio" value="borderline" /><br/>
        Accept Without Aid <input id="recommendation" name="recommendation" type="radio" value="withoutaid" /><br/>
        Accepet With Aid <input id="recommendation" name="recommendation" type="radio" value="withaid" /><br/>
        <span class="error"> <?php echo $myReviewErr;?></span><br/><br/>
      <label for="comment">Add Comment:</label>
      <input type="text" id="comment" name="comment" size="32" />
      <span class="error"> <?php echo $myCommentErr;?></span><br/><br/>
      <input type="submit" id="btn" value="Submit" name="submit" />
    </fieldset>
  </form>

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
