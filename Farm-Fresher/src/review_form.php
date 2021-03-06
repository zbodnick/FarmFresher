<!DOCTYPE html>
<html lang="en">

<head>
    <title>Applicant Review Form</title>
    <?php
    require_once ('header.php');
    //session_start();
	?>

</head>
<body>
<?php
	if (empty($_SESSION['id'])) {
		header("Location: login.php");
  }

  $first = '';
  $last = '';
  $id = '';

  $error = 0;

  $permLevel = $_SESSION['p_level'];

	include ('php/connectvars.php');

  if (isset($_POST['review'])) {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $dbc->query('SET foreign_key_checks = 0');
    $id = $_POST['id'];

    $query = 'SELECT fname, lname FROM applicant WHERE username='.$_POST['id'];
    $res = mysqli_query($dbc,$query);

    if(mysqli_num_rows($res)) {
      $row = mysqli_fetch_array($res);

      $first = $row['fname'];
      $last = $row['lname'];
    }
  }

  if (isset($_POST['submit'])) {
    if (strcmp($permLevel, "Faculty") == 0) {
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $sql = "SELECT reviewer_comment FROM application WHERE username=".$_POST['id'];
      $res = mysqli_query($dbc,$sql);
      $row = mysqli_fetch_array($res);

      $concatComment = '';

      if (strcmp($row['reviewer_comment'],$concatComment)) {
        $concatComment = $row['reviewer_comment'];
        $concatComment = $concatComment . ' | ' . $_SESSION['id'] . ': ' . $_POST['comment'];
      }
      else {
        $concatComment = $_SESSION['id'] . ': ' . $_POST['comment'];
      }

      echo 'concat:'.$concatComment;

      $sql = "UPDATE application SET reviewer_comment ='". $concatComment ."' WHERE username=".$_POST['id'];
      $res = mysqli_query($dbc,$sql);

      $sql = "SELECT recommendation FROM application WHERE username=".$_POST['id'];
      $res = mysqli_query($dbc,$sql);
      $row = mysqli_fetch_array($res);

      $rec = 0;

      if ($row['recommendation'] != 0) {
        $rec = ($row['recommendation'] + $_POST['recommendation']) / 2;
      }
      else {
        $rec = $_POST['recommendation'];
      }

      $sql = "UPDATE application SET recommendation =". ceil($rec) ." WHERE username=".$_POST['id'];
      $res = mysqli_query($dbc,$sql);

      $sql = "UPDATE reviewer_application SET status=1 WHERE applicantid=".$_POST['id']." AND username=".$_SESSION['id'];
      $res = mysqli_query($dbc,$sql);

      header("Location: reviewer_portal.php?success=yes"); 
    }
    else if (strcmp($permLevel, "GS") == 0) {
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      if (!empty($_POST['decision'])) {
        $sql = "UPDATE application SET final_decision =".$_POST['decision']." WHERE username=".$_POST['id'];
        $res = mysqli_query($dbc,$sql);

        $sql = "SELECT email FROM applicant WHERE username=".$_POST['id'];
        $res = mysqli_query($dbc,$sql);
        $row = mysqli_fetch_array($res);

        $msg = "Hello! Your application status has been updated. Login to your applicant portal to view.";
        $header = "From: farmfresh@gmail.edu";
        $retval = mail($row['email'],"Application Updated",$msg, $header);
      }
      if (!empty($_POST['received'])) {
        $sql = "UPDATE application SET transID =".$_POST['received']." WHERE username=".$_POST['id'];
        $res = mysqli_query($dbc,$sql);
      }
      header("Location: reviewer_portal.php?success=yes");
    }
    else if (strcmp($permLevel, "CAC") == 0) {
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      if (!empty($_POST['decision'])) {
        $sql = "UPDATE application SET final_decision =".$_POST['decision']." WHERE username=".$_POST['id'];
        $res = mysqli_query($dbc,$sql);

        $sql = "SELECT email FROM applicant WHERE username=".$_POST['id'];
        $res = mysqli_query($dbc,$sql);
        $row = mysqli_fetch_array($res);

        $msg = "Hello! Your application status has been updated. Login to your applicant portal to view.";
        $header = "From: farmfresh@gmail.edu";
        $retval = mail($row['email'],"Application Updated",$msg, $header);
      }
      header("Location: reviewer_portal.php?success=yes");
    }
  }

if (strcmp($permLevel, "Faculty") == 0) {
?>
    <br><br>
    <div class="container pt-3">
    <br><br>
    <h1 class="text-primary">Review Form</h1>
    <form method="post" class="card p-5 mt-4" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <div class="row">
          <div class="col-md-6 form-group">
              <label for="fname">Name: </label>
              <?php echo $first?> <?php echo $last?>
          </div>
          <div class="col-md-6 form-group">
              <label for="fname">Applicant ID: </label>
              <?php echo $id?>
          </div>
      </div>

      <div class="row border-top pt-4 text-center">
				<div class="text-primary col-lg form-group">
					<h4>RECOMMENDATION<h4>
				</div>
			</div>


      <div class="row">

          <div class="col form-group text-danger text-center">
            Reject <input id="recommendation" name="recommendation" type="radio" value="1" required/>
          </div>

          <div class="col form-group text-info text-center">
            Borderline <input id="recommendation" name="recommendation" type="radio" value="2" required/>
          </div>

          <div class="col form-group text-warning text-center">
            Accept Without Aid <input id="recommendation" name="recommendation" type="radio" value="3" required/>
          </div>

          <div class="col form-group text-success text-center">
            Accept With Aid <input id="recommendation" name="recommendation" type="radio" value="4" required/>
          </div>
          <input type='hidden' name='id' value='<?php echo $id;?>'>

      </div>

        <div class="row">
          <div class="col-lg form-group">
            <label for="comment">Add Comment</label>
            <input type="text" class="form-control form-control-lg text-muted" maxlength="254" id="comment" name="comment" size="32" required/>
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
} else if (strcmp($permLevel, "GS") == 0 || strcmp($permLevel, "CAC") == 0) {

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $sql = "SELECT final_decision FROM application WHERE username=".$_POST['id'];
  $res = mysqli_query($dbc,$sql);
  $row = mysqli_fetch_array($res);

  if ($row['final_decision'] != 0) {
    echo "
      <br><br><div class='alert alert-danger text-center' role='alert'>APPLICATION ALREADY HAS A FINAL DECISION. IF ANOTHER IS SUBMITTED, THE CURRENT DECISION WILL BE CHANGED</div>
    ";
  }

?>
<br><br>
    <div class="container pt-3">
    <?php if(isset($_POST['submit'])) { echo "<div class='alert alert-success' role='alert'>Changes Submitted Successfully</div>"; } ?>
    <br><br>
    <h1 class="text-primary">Update Application</h1>
    <form method="post" class="card p-5 mt-4" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <div class="row">
          <div class="col-md-6 form-group">
              <label for="fname">Name: </label>
              <?php echo $first?> <?php echo $last?>
          </div>
          <div class="col-md-6 form-group">
              <label for="fname">Applicant ID: </label>
              <?php echo $id?>
          </div>
      </div>
<?php
} 
if (strcmp($permLevel, "GS") == 0) {
?>
      <div class="row border-top pt-4 text-center">
				<div class="text-primary col-lg form-group">
					<h4>Application Info<h4>
				</div>
			</div>

      <div class="row">
        <div class="col form-group text-center">
          <label for="received">Transcript Received: </label>
          <input class="form-control form-control-lg text-muted" id="received" name="received" type="checkbox" value="1"/>
        </div>
      </div>
<?php
}
if (strcmp($permLevel, "GS") == 0 || strcmp($permLevel, "CAC") == 0) {
?>
      <div class="row border-top pt-4 text-center">
				<div class="text-primary col-lg form-group">
					<h4>FINAL DECISION<h4>
				</div>
			</div>
      <div class="row">

          <div class="col form-group text-danger text-center">
            Reject <input id="decision" name="decision" type="radio" value="1"/>
          </div>

          <div class="col form-group text-warning text-center">
            Accept Without Aid <input id="decision" name="decision" type="radio" value="2"/>
          </div>

          <div class="col form-group text-success text-center">
            Accept With Aid <input id="decision" name="decision" type="radio" value="3"/>
          </div>
          <input type='hidden' name='id' value='<?php echo $id;?>'>

      </div>
      <div class="row mb-3 mt-2">
        <div class="col text-center">
            <input type="submit" id="btn" value="Submit" name="submit" class="btn btn-primary btn-lg px-5">
        </div>
     </div>
  </form>
  </div>
<?php
}
?>
</body>
</html>
