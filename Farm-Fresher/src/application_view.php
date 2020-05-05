<!DOCTYPE html>
<html lang="en">

<head>
    <title>Application</title>
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

if (isset($_POST['accept'])) {
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $dbc->query('SET foreign_key_checks = 0');
  $query = "SELECT * FROM applicant WHERE username=".$_SESSION['id'];
  $data = mysqli_query($dbc, $query);
  $applicantData = mysqli_fetch_array($data);

  $query2 = "SELECT * FROM application WHERE username=".$_SESSION['id'];
  $data2 = mysqli_query($dbc, $query);
  $applicantData2 = mysqli_fetch_array($data);

  $query = "INSERT INTO student VALUES (".$applicantData['username'].",'".$applicantData['fname']."','".$applicantData['lname']."','".$applicantData['addr']."','".$applicantData['email']."','Computer Science', '".$applicantData2['degree_type']."', NULL, NULL, NULL, 0, 1, ". date("Y") .")";

  $data = mysqli_query($dbc, $query);

  $query = "UPDATE users SET p_level='Student' WHERE id=".$_SESSION['id'];
  $data = mysqli_query($dbc, $query);

  $query = "DELETE FROM reviewer_application WHERE applicantid=".$_SESSION['id'];
  $data = mysqli_query($dbc, $query);

  $query = "DELETE FROM recommender WHERE applicationID=".$_SESSION['id'];
  $data = mysqli_query($dbc, $query);

  $query = "DELETE FROM application WHERE username=".$_SESSION['id'];
  $data = mysqli_query($dbc, $query);

  $query = "DELETE FROM applicant WHERE username=".$_SESSION['id'];
  $data = mysqli_query($dbc, $query);

  header("Location: logout.php");
}
else if (isset($_POST['reject'])) {
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  $query = "DELETE FROM reviewer_application WHERE applicantid=".$_SESSION['id'];
  $data = mysqli_query($dbc, $query);

  $query = "DELETE FROM recommender WHERE applicationID=".$_SESSION['id'];
  $data = mysqli_query($dbc, $query);

  $query = "DELETE FROM application WHERE username=".$_SESSION['id'];
  $data = mysqli_query($dbc, $query);

  $query = "DELETE FROM applicant WHERE username=".$_SESSION['id'];
  $data = mysqli_query($dbc, $query);

  header("Location: logout.php");
}

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

?>

  <body>
    <br><br>
    <div class="container pt-3">
    <h1 class="text-primary">View Application</h1>
    <form method="post" class="card p-5 mt-4" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <?php
        if (isset($_POST['id']))
          $id = $_POST['id'];
        else
          $id = $_SESSION['id'];

        $query = "SELECT * FROM application WHERE username = ".$id;
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) == 1) {
          $row = mysqli_fetch_array($data);
          $i = 0;
          if ($row[28] == 3 && !strcmp($_SESSION['p_level'],"Applicant")) {
            echo '<div class="row"><div class="col-md-6 form-group"><h2 class="text-primary">CONGRATULATIONS! You have been accepted with aid!</h2>';
            echo '<form action="application_view.php" method="post">
                    <input type="submit" id="btn" value="Accept Offer" name="accept" value="accept" class="btn btn-primary btn-lg px-5"/>
                    <input type="submit" id="btn" value="Reject Offer" name="reject" value="reject" class="btn btn-primary btn-lg px-5"/>
                  </form></div></div><div class="card p-5 mt-4">';
          }
          else if ($row[28] == 2 && !strcmp($_SESSION['p_level'],"Applicant")) {
            echo '<div class="row"><div class="col-md-6 form-group"><h2 class="text-primary">CONGRATULATIONS! You have been accepted!</h2>';
            echo '<form action="application_view.php" method="post">
                    <input type="submit" id="btn" value="Accept Offer" name="accept" value="accept" class="btn btn-primary btn-lg px-5"/>
                    <input type="submit" id="btn" value="Reject Offer" name="reject" value="reject" class="btn btn-primary btn-lg px-5"/>
                  </form></div></div><div class="card p-5 mt-4">';
          }
          else if ($row[25] == 1 && !strcmp($_SESSION['p_level'],"Applicant")) {
            echo '<div class="row"><div class="col-md-6 form-group">
                  <h2 class="text-primary">We regret to inform you that your application has been rejected.</h2>
                  </div></div><div class="card p-5 mt-4">';
          }
          else if (!strcmp($_SESSION['p_level'],"Applicant")) {
            echo '<div class="row"><div class="col-md-6 form-group">
                  <h2 class="text-primary">Application Is In Review.</h2></div></div>';
          }
          $cats = array("Application ID","Username","Transcript","Recommender Email","GRE Verbal",
                  "GRE Quantitative","GRE Date","Adv. GRE Score","Adv. GRE Subject","Adv. GRE Date",
                  "TOEFL Score","TOEFL Date","MS Prior","MS GPA","MS Major","MS Year","MS University",
                  "BS/A Prior","BS/A GPA","BS/A Major","BS/a Year","BS/A University","Experience","Interests",
                  "Completion","Average Review","Reviewer Comment","Degree Type","Final Decision");
          $accepted = array("Review In Progress","Rejected","Deferred","Accepted, No Aid","Accepted, Aid");
          for ($i; $i < (sizeof($row)/2); $i++) {
            if (!strcmp($cats[$i],"Transcript")) {
              if ($row[$i] == 0) {
              echo '
                <div class="row">
                  <div class="col-md-6 form-group">
                    <b>'.$cats[$i].'</b>: Not Received
                  </div>
                </div>
              ';
              }
              else {
                echo '
                  <div class="row">
                    <div class="col-md-6 form-group">
                    <b>'.$cats[$i].'</b>: Received
                    </div>
                  </div>
                ';
                }
            }
            else if (!strcmp($cats[$i],"Completion")) {
              if ($row[$i] == 0) {
              echo '
                <div class="row">
                  <div class="col-md-6 form-group">
                    <b>Status</b>: Not Complete
                  </div>
                </div>
              ';
              }
              else {
                echo '
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <b>Status</b>: Complete
                    </div>
                  </div>
                ';
                }
            }
            else if ((!strcmp($cats[$i],"Reviewer Comment") || !strcmp($cats[$i],"Average Review") || !strcmp($cats[$i],"Final Decision")) && !strcmp($_SESSION['p_level'],"Applicant")) {
              // do nothing
            }
            else {
              echo '
                <div class="row">
                  <div class="col-md-6 form-group">
                  <b>'.$cats[$i].'</b>: '. $row[$i] .'
                  </div>
                </div>
              ';
            }
          }

          if (strcmp($_SESSION['p_level'],"Applicant")) {
            $query = "SELECT * FROM recommender WHERE applicationID=".$id;
            $data = mysqli_query($dbc, $query);
            if (mysqli_num_rows($data)) {
              while ($row = mysqli_fetch_array($data)) {
                echo '
                <div class="row">
                  <div class="col-md-6 form-group">
                    <b>Recommendation from '.$row['fname'].' '.$row['lname'].'</b>: '.$row['recommendation'].'
                  </div>
                </div>';
              }
            }

          }
        }
      ?>
    </form>
    </div>
  </body>
</html>
