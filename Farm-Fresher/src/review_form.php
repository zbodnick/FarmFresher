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
  
  $first = '';
  $last = '';
  $id = '';
	
	include ('php/connectvars.php');
  
  if (isset($_POST['review'])) {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
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
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $sql = "UPDATE application SET reviewer_comment ='".$_POST['comment']."' WHERE username=".$_POST['id'];
    $res = mysqli_query($dbc,$sql);

    $sql = "UPDATE application SET recommendation =".$_POST['recommendation']." WHERE username=".$_POST['id'];
    $res = mysqli_query($dbc,$sql);
  }
?>

<body>
    <br><br>
    <div class="container pt-3">
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
</body>
</html>
