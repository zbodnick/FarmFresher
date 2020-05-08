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
  if(isset($_GET['success'])) { echo "<div class='alert alert-success' role='alert'>Changes Submitted Successfully</div>"; }
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

  if (isset($_POST['insert'])) {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $query = 'INSERT INTO courses_taken (u_id, crn, grade) VALUES 
    ('.$_POST['uid'].', 21, "B+"),
    ('.$_POST['uid'].', 24, "A"),
    ('.$_POST['uid'].', 25, "A"),
    ('.$_POST['uid'].', 26, "A-"),
    ('.$_POST['uid'].', 27, "A"),
    ('.$_POST['uid'].', 33, "B"),
    ('.$_POST['uid'].', 34, "B-"),
    ('.$_POST['uid'].', 35, "C");';
    
    $data = mysqli_query($dbc, $query);
  }

  if (strcmp($permLevel, "Faculty") == 0) {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $dbc->query('SET foreign_key_checks = 0');
    $appQ = "SELECT reviewer_application.username,reviewer_application.applicantid from reviewer_application JOIN application on
            reviewer_application.applicantid=application.username where reviewer_application.status=0 AND reviewer_application.username=".$_SESSION['id'];
    $data = mysqli_query($dbc, $appQ);
    echo "<div class='col-md-10 form-group'><h1 class='text-primary'>Admissions Portal</h1></div><hr>";
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
              </div><hr>";
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
    $appQ = "select a.applicantid as applicantid, a.username as recommender1,b.username as recommender2 from reviewer_application a, reviewer_application b where a.applicantid=b.applicantid AND a.username!=b.username AND a.username<b.username";
    $data = mysqli_query($dbc, $appQ);
    echo "<div class='col-md-6 form-group'><h1 class='text-primary'>GS Admissions Portal</h1></div><hr>";
    if (mysqli_num_rows($data)) {
      while ($row = mysqli_fetch_array($data)) {
        echo "<div class='row'>
                <div class='col-md-10 form-group'>
                    <h3 class='text-primary'>Applicant ID: ".$row['applicantid']." | Reviewer ID: ".$row['recommender1']." and ".$row['recommender2']."</h3>
                    <form action='application_view.php' style='display:inline-block' method='POST'>
                      <input type='hidden' name='id' value='".$row['applicantid']."' />
                      <input type='submit' id='btn' value='View Application' name='view' class='btn btn-primary btn-lg px-5' />
                    </form>
                    <form action='review_form.php' style='display:inline-block' method='POST'>
                      <input type='hidden' name='id' value='".$row['applicantid']."' />
                      <input type='submit' id='btn' value='Submit Review' name='review' class='btn btn-primary btn-lg px-5' />
                    </form>
                </div>
              </div><hr>";
      }
    }?>
    <div class='row'>
      <input class='form-control' id='search_filter' type='text' placeholder='Search Accepted Students...'>
    </div>
    <h1 class="text-primary">Accepted Students</h1> <br>
    <br><br>
    <div class='row'>
      <table class="table table-bordered">
        <thead>
          <tr class="text-center table-primary">
            <th scope="col"> U_ID </th>
            <th scope="col"> Program </th>
            <th scope="col"> Year Applied </th>
            <th scope="col"> Semester </th>
          </tr>
        </thead>
        <tbody id="student_table">
          <?php
          //accepted list
            $query = 'SELECT username as U_ID, program, year, semester
                  FROM accepted';
            $students = mysqli_query ($dbc, $query);

            while ($students && $s = mysqli_fetch_assoc ($students)) {
              echo '<tr class="text-center">';

              // Print each field of each student
              foreach ($s as $data) {
                echo '<td class="align-middle">' . $data . '</td>';
              }

            }
          ?>
        </tbody>
      </table>
    </div>
    <br><br><hr>
    <div class='row'>
      <input class='form-control' id='search_filter2' type='text' placeholder='Search Acceptance Statistics...'>
    </div>
    <h1 class="text-primary">Acceptance Statistics</h1> <br>
    <br><br>
    <div class='row'>
      <table class="table table-bordered">
        <thead>
          <tr class="text-center table-primary">
            <th scope="col"> # Applicants </th>
            <th scope="col"> # Admitted </th>
            <th scope="col"> Avg. GRE </th>
            <th scope="col"> Avg. GPA </th>
          </tr>
        </thead>
        <tbody id="student_table2">
          <?php
          //accepted list
            $query = 'SELECT username as U_ID, program, year, semester
                  FROM accepted';
            $students = mysqli_query ($dbc, $query);

            while ($students && $s = mysqli_fetch_assoc ($students)) {
              echo '<tr class="text-center">';

              // Print each field of each student
              foreach ($s as $data) {
                echo '<td class="align-middle">' . $data . '</td>';
              }

            }
          ?>
        </tbody>
      </table>
    </div><hr>
    <div class='row'>
    <h1 class="text-primary">Pre Scripted Grades</h1> <br>
    </div>
    <br>
    <div class='row'>
      <form action="reviewer_portal.php" method="post">
        <input class='form-control' id='uid' name='uid' type='text' placeholder='U ID...'><br>
        <input type='submit' id='btn' value='Insert Grades' name='insert' class='btn btn-primary btn-lg px-5' />
      </form>
    </div>
<?php
  } else if (strcmp($permLevel, "CAC") == 0) {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $appQ = "select a.applicantid as applicantid, a.username as recommender1,b.username as recommender2 from reviewer_application a, reviewer_application b where a.applicantid=b.applicantid AND a.username!=b.username AND a.username<b.username";
    $data = mysqli_query($dbc, $appQ);
    echo "<div class='col-md-6 form-group'><h1 class='text-primary'>CAC Admissions Portal</h1></div><hr>";
    if (mysqli_num_rows($data)) {
      while ($row = mysqli_fetch_array($data)) {
        echo "<div class='row'>
                <div class='col-md-10 form-group'>
                    <h3 class='text-primary'>Applicant ID: ".$row['applicantid']." | Reviewer ID: ".$row['recommender1']." and ".$row['recommender2']."</h3>
                    <form action='application_view.php' style='display:inline-block' method='POST'>
                      <input type='hidden' name='id' value='".$row['applicantid']."' />
                      <input type='submit' id='btn' value='View Application' name='view' class='btn btn-primary btn-lg px-5' />
                    </form>
                    <form action='review_form.php' style='display:inline-block' method='POST'>
                      <input type='hidden' name='id' value='".$row['applicantid']."' />
                      <input type='submit' id='btn' value='Submit Review' name='review' class='btn btn-primary btn-lg px-5' />
                    </form>
                </div>
              </div><hr>";
      }
    }
  } else if (strcmp($permLevel, "Admin") == 0) {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $appQ = "SELECT username from applicant";
    $data = mysqli_query($dbc, $appQ);
    echo "<div class='col-md-6 form-group'><h1 class='text-primary'>Admin Admissions Portal</h1></div><hr>";
    if (mysqli_num_rows($data)) {
      while ($row = mysqli_fetch_array($data)) {
        echo "<div class='row'>
                <div class='col-md-10 form-group'>
                    <h3 class='text-primary'>Applicant ID: ".$row['username']."</h3>
                    <form action='application_view.php' style='display:inline-block' method='POST'>
                      <input type='hidden' name='id' value='".$row['username']."' />
                      <input type='submit' id='btn' value='View Application' name='view' class='btn btn-primary btn-lg px-5' />
                    </form>
                    <form action='reviewer_portal.php' style='display:inline-block' method='POST'>
                      <input type='hidden' name='id' value='".$row['username']."' />
                      <input type='submit' id='btn' value='Delete' name='delete' class='btn btn-primary btn-lg px-5' />
                    </form>
                </div>
              </div><hr>";
      }
    }
  }
?>
  </div>
</body>

<script>
    $(document).ready(function(){
    $("#search_filter").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#student_table tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    });

    $(document).ready(function(){
    $("#search_filter2").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#student_table2 tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    });
</script>

</html>
