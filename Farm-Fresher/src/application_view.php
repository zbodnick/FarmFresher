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

if (isset($_POST['accept'])) {
  echo 'accept';
}
else if (isset($_POST['reject'])) {
  echo 'reject';
}

include ('php/connectvars.php');		

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

?>

  <body>
    <br><br>
    <div class="container pt-3">
    <h1 class="text-primary">Application Review</h1>
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
          if ($row[28] == 3) {
            echo '<div class="row"><div class="col-md-6 form-group"><h2 class="text-primary">CONGRATULATIONS! You have been accepted with aid!</h2>';
            echo '<form action="application_view.php" method="post">
                    <input type="submit" id="btn" value="Accept Offer" name="accept" value="accept" class="btn btn-primary btn-lg px-5"/>
                    <input type="submit" id="btn" value="Reject Offer" name="reject" value="reject" class="btn btn-primary btn-lg px-5"/>
                  </form></div></div>';
          }
          else if ($row[28] == 2) {
            echo '<div class="row"><div class="col-md-6 form-group"><h2 class="text-primary">CONGRATULATIONS! You have been accepted!</h2>';
            echo '<form action="application_view.php" method="post">
                    <input type="submit" id="btn" value="Accept Offer" name="accept" value="accept" class="btn btn-primary btn-lg px-5"/>
                    <input type="submit" id="btn" value="Reject Offer" name="reject" value="reject" class="btn btn-primary btn-lg px-5"/>
                  </form>/div></div>';
          }
          else if ($row[25] == 1) {
            echo '<div class="row"><div class="col-md-6 form-group"><h2 class="text-primary">We regret to inform you that your application has been rejected.</h2></div></div>';
          }
          else {
            echo '<div class="row"><div class="col-md-6 form-group"><h2 class="text-primary">Application Is In Review.</h2></div></div>';
          }
          $cats = array("Application ID","Username","Transcript","Recommender Email","GRE Verbal",
                  "GRE Quantitative","GRE Date","Adv. GRE Score","Adv. GRE Subject","Adv. GRE Date",
                  "TOEFL Score","TOEFL Date","MS Prior","MS GPA","MS Major","MS Year","MS University",
                  "BS/A Prior","BS/A GPA","BS/A Major","BS/a Year","BS/A University","Experience","Interests",
                  "Completion","Recommendation","Reviewer Comment","Degree Type","Final Decision");
          $accepted = array("Review In Progress","Rejected","Deferred","Accepted, No Aid","Accepted, Aid");
          for ($i; $i < (sizeof($row)/2); $i++) {
            if (!strcmp($cats[$i],"Transcript")) {
              if ($row[$i] == 0) {
              echo '
                <div class="row">
                  <div class="col-md-6 form-group">
                    '.$cats[$i].': Not Received
                  </div>
                </div>
              ';
              }
              else {
                echo '
                  <div class="row">
                    <div class="col-md-6 form-group">
                      '.$cats[$i].': Received
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
                    Status: Not Complete
                  </div>
                </div>
              ';
              }
              else {
                echo '
                  <div class="row">
                    <div class="col-md-6 form-group">
                      Status: Complete
                    </div>
                  </div>
                ';
                }
            }
            else if (strcmp($cats[$i],"Reviewer Comment") && strcmp($cats[$i],"Recommendation") && strcmp($cats[$i],"Final Decision")) {
              echo '
                <div class="row">
                  <div class="col-md-6 form-group">
                  '. $cats[$i] .': '. $row[$i] .'
                  </div>
                </div>
              ';
            }
          }
        }
      ?>
    </form>
    <div>
  </body>
</html>
