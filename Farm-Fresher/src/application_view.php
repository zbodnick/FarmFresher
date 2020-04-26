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

include ('php/connectvars.php');		

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

?>

  <body>
    <br><br>
    <div class="container pt-3">
    <h1 class="text-primary">Review Form</h1>
    <form method="post" class="card p-5 mt-4" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <?php 
        $query = "SELECT * FROM application WHERE username = ". $_SESSION["id"];
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) == 1) {
          $row = mysqli_fetch_array($data);
          $i = 0;
          $cats = array("Application ID","Username","Transcript ID","Recommender Email","GRE Verbal",
                  "GRE Quantitative","GRE Date","Adv. GRE Score","Adv. GRE Subject","Adv. GRE Date",
                  "TOEFL Score","TOEFL Date","MS Prior","MS GPA","MS Major","MS Year","MS University",
                  "BS/A Prior","BS/A GPA","BS/A Major","BS/a Year","BS/A University","Experience","Interests",
                  "Completion","Recommendation","Reviewer Comment","Degree Type","Final Decision");

          for ($i; $i < (sizeof($row)/2); $i++) {
            echo '
              <div class="row">
                <div class="col-md-6 form-group">
                '. $cats[$i] .': '. $row[$i] .'
                </div>
              </div>
            ';
          }
        }
      ?>
    </form>
    <div>
  </body>
</html>
