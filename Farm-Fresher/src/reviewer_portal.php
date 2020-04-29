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
  <div class="container pt-3 card p-5 mt-4">
<?php

  if (empty($_SESSION['id'])) {
      header("Location: login.php");
  }

  $permLevel = $_SESSION['p_level'];

  include ('php/connectvars.php');

  if (isset($_POST['delete'])) {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $query = "DELETE FROM reviewer_application WHERE applicantid=".$_POST['id'];
    $data = mysqli_query($dbc, $query);

    $query = "DELETE FROM recommender WHERE applicationID=".$_POST['id'];
    $data = mysqli_query($dbc, $query);

    $query = "DELETE FROM application WHERE username=".$_POST['id'];
    $data = mysqli_query($dbc, $query);

    $query = "DELETE FROM applicant WHERE username=".$_POST['id'];
    $data = mysqli_query($dbc, $query);
  }

if (strcmp($permLevel, "Faculty") == 0) {
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $dbc->query('SET foreign_key_checks = 0');
  $appQ = "SELECT reviewer_application.username,reviewer_application.applicantid from reviewer_application JOIN application on
           reviewer_application.applicantid=application.username where recommendation=0 and
           reviewer_application.username=".$_SESSION['id'];
  $data = mysqli_query($dbc, $appQ);
  echo "<div class='col-md-6 form-group'><h1 class='text-primary'>Admissions Portal</h1></div>";
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
              </div>
            </div>";
    }
  }
  else {
    echo "
    <div class='row'>
      <div class='col-md-6 form-group'>
        <h3 class='text-primary'>No Current Application Needing Review</h3>
      </div>
    </div>
    ";
  }
} else if (strcmp($permLevel, "GS") == 0) {
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $appQ = "SELECT applicantid from reviewer_application";
  $data = mysqli_query($dbc, $appQ);
  echo "<div class='col-md-6 form-group'><h1 class='text-primary'>Admissions Portal</h1></div>";
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
              </div>
            </div>";
    }
  }
} else if (strcmp($permLevel, "CAC") == 0) {
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $appQ = "SELECT applicantid from reviewer_application";
  $data = mysqli_query($dbc, $appQ);
  echo "<div class='col-md-6 form-group'><h1 class='text-primary'>Admissions Portal</h1></div>";
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
              </div>
            </div>";
    }
  }
} else if (strcmp($permLevel, "Admin") == 0) {
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $appQ = "SELECT username from applicant";
  $data = mysqli_query($dbc, $appQ);
  echo "<div class='col-md-6 form-group'><h1 class='text-primary'>Admissions Portal</h1></div>";
  if (mysqli_num_rows($data)) {
    while ($row = mysqli_fetch_array($data)) {
      echo "<div class='row'>
              <div class='col-md-6 form-group'>
                  <h3 class='text-primary'>Applicant ID: ".$row['username']."</h3>
                  <form action='application_view.php' style='display:inline-block' method='POST'>
                    <input type='hidden' name='id' value='".$row['username']."' />
                    <input type='submit' id='btn' value='View Application' name='view' class='btn btn-primary btn-lg px-5' />
                  </form>
                  <form action='review_form.php' style='display:inline-block' method='POST'>
                    <input type='hidden' name='id' value='".$row['username']."' />
                    <input type='submit' id='btn' value='Delete' name='delete' class='btn btn-primary btn-lg px-5' />
                  </form>
              </div>
            </div>";
    }
  }
}
?>
  </div>
</body>
</html>
