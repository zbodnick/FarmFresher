<!DOCTYPE html>
<html lang="en">

<head>
    <title>Application Review</title>
    <?php 
    require_once ('header.php'); 
	?>
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
  <br><br><br><br>
  <div class="container pt-3">
  <div class='col-md-6 form-group'><h1 class="text-primary">Reviewer Portal</h1></div>
<?php

  if (empty($_SESSION['id'])) {
      header("Location: login.php");
  }

  include ('php/connectvars.php');		

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $appQ = "SELECT applicantid from reviewer_application where username=".$_SESSION['id'];
  $data = mysqli_query($dbc, $appQ);
  if (mysqli_num_rows($data)) {
    while ($row = mysqli_fetch_array($data)) {
      echo "<div class='row'>
              <div class='col-md-6 form-group'>
                  <h3 class='text-primary'>Applicant ID: ".$row['applicantid']."</h3>
                  <form action='application_view.php' style='display:inline-block' method='POST'>
                    <input type='hidden' name='id' value='".$row['applicantid']."' />
                    <input type='submit' id='btn' value='View Application' name='view' class='btn btn-primary btn-lg px-5' />
                  </form>
                  <form action='review_form.php' style='display:inline-block' method='POST'>
                    <input type='hidden' name='id' value='".$row['applicantid']."' />
                    <input type='submit' id='btn' value='Submit Review' name='review' class='btn btn-primary btn-lg px-5' />
                  </form>
                </table>
              </div>
            </div>";
    }
  }

?>
  </div>
</body>
</html>