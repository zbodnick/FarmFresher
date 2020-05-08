<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Info Dashboard</title>
    <?php
		require_once ('header.php');
		session_start ();

		if (empty ($_SESSION['id'])) {
			header ('Location: home.php');
    }

    include ('php/connectvars.php');
	  ?>
</head>


<body  data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
  <div class="site-section">
    <div class="container text-center align-center">
    <div class="row">
		<h1 class="text-primary mx-auto">Student Information Dashboard</h1>
	</div>
<?php

  require_once('appvars.php');

  //Load DBC
 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $dbc->query('SET foreign_key_checks = 0');

  //These are the checks we run at the start of the page. Depending on user status,
  //we can accept their form 1 data, accept their thesis, or graduate them and move them into alumni.
  if(isset($_POST["acceptform1"])){
    //Accept user's form 1 data
    $query = "insert into formone (universityid, cid) VALUES ('$_POST[acceptform1]', 'APPROVED')";
    mysqli_query($dbc, $query);
    echo '<center><h3>Student Form Accepted</h3></center><hr />';
  }
  else if(isset($_POST["acceptthesis"])){
    //Update user's status to "waiting for acceptance of graduation"
    $query = "UPDATE student SET applied_to_grad=2 WHERE unid = '$_POST[acceptthesis]'";
    mysqli_query($dbc, $query);
    echo '<center><h3>Student Thesis Accepted</h3></center><hr />';
  }
  else if(isset($_POST["cleargrad"])){
    //Graduate User
    $query = "UPDATE student SET applied_to_grad=3 WHERE unid = '$_POST[cleargrad]'";
    mysqli_query($dbc, $query);
    $query = "UPDATE users SET p_level='alumni' WHERE id = '$_POST[cleargrad]'";
    mysqli_query($dbc, $query);

    //Move user into alumni
    $theuID = $_POST["univID"];
    $fname = $dbc->query(("select fname from student where u_id = $theuID"))->fetch_assoc()['fname'];
    $lname = $dbc->query(("select lname from student where u_id = $theuID"))->fetch_assoc()['lname'];
    $email = $dbc->query(("select email from student where u_id = $theuID"))->fetch_assoc()['email'];
    $query = "INSERT INTO alumni (univid, yeargrad, fname, lname, email) VALUES ($theuID, 2020, $fname, $lname, $email)";
    mysqli_query($dbc, $query);

    echo '<center><h3>Student Graduated</h3></center><hr />';
  }
  else if(isset($_POST["Assign"])){
    //Update User's advisor ID
    $query = "UPDATE student SET advisorid = '$_POST[assignAdvi]' WHERE unid = '$_POST[assignstuID]'";
    mysqli_query($dbc, $query);

    echo "<center><h3>Student Advisor updated to '$_POST[assignAdvi]'</h3></center><hr />";
  }
  ?>
  <div class="row">
<?php

  //SEARCH BAR
  echo '<form action="" class="mx-auto mb-4" method="post">';
  echo '<label for=:univID">University ID</label>';
  ?><div class="col"><?php
  echo  '<input type="text" class="form-control form-control-lg text-muted" id="univID" name="univID">';
  ?></div>
  <div class="col"><?php
  echo  '<input type="submit" class="btn btn-primary mt-2 btn-block btn-md" name="Search" value="Search">';
  ?></div><?php
  echo	'</form>';
  ?>
</div>
<?php
  //IF A USER HAS BEEN SEARCHED
  if(isset($_POST["Search"])){

    //THIS ONLY ALLOWS FOR AN ADVISOR TO LOOK UP THEIR STUDENTS AND ONLY THEIR STUDENTS
    if((strcmp($_SESSION['p_level'], 'Advisor') == 0)){
      echo '<center><h4 class="text-success>Student Found</h4></center><div class="advbasicdata">';
      $input = $_POST['univID'];


      //LOADING SEARCHED STUDENT BASIC DATA INTO A TABLE
      $query = "select * from student WHERE u_id = '$input' and advisorid = '$_SESSION[id]' and (NOT applied_to_grad = 3)";
      $result = mysqli_query($dbc, $query);
      if(mysqli_num_rows($result) > 0){
        echo '<table style="width:100%">';
        echo '<tr><th>University ID</th><th>Advisor ID</th><th>GPA</th><th>Program</th><th>Applied to Grad?</th></tr>';
        while($row = $result->fetch_assoc()){
          echo "<td>" . $row["u_id"]. "</td><td>" . $row["advisorid"]. "</td><td>" . $row["gpa"]. "</td><td>" . $row["major"]. "</td>";
          $stuID = $row["unid"];
          if($row["applied_to_grad"] == 0){
            echo "<td>No</td></tr>";
          }
          else{
            echo "<td>Yes</td></tr>";
          }
        }
        echo '</table></div>';
        echo '<hr />';


        //SHOW STUDENT'S TRANSCRIPT (ONLY IF BASIC DATA APPEARS)
        $query = "select crseid, title, semester, yeartaken, grade, chours from transcript, course where courseid = crseid and univerid = '$_POST[univID]'";
        $result = mysqli_query($dbc, $query);
        echo '<center><h4>Transcript</h4></center><div class="transcript">';
        if ($result->num_rows > 0){
          echo '<table style="width:100%">';
          echo '<tr><th>Year</th><th>Semester</th><th>Course ID</th><th>Title</th><th>Grade</th><th>Credits</th></tr>';
          while($row = $result->fetch_assoc()){
              echo "<tr><td>" . $row["yeartaken"]. "</td><td>" . $row["semester"]. "</td><td>" . $row["crseid"]. "</td><td>" . $row["title"]. "</td><td>" . $row["grade"]. "</td><td>" . $row["chours"]. "</td></tr>";
          }
          echo '</table></div>';
          echo '<hr />';


          //SHOW STUDENT FORMONE DATA (ONLY IF TRANSCRIPT APPEARS)
          $query = "select * from formone where universityid = " . $_POST['univID'];
          $result = mysqli_query($dbc, $query);
          echo '<center><h4>Form One Data</h4></center><div class="formdata">';
          if ($result->num_rows > 0){
            echo '<table style="width:100%">';
            echo '<tr><th>Course ID</th></tr>';
            while($row = $result->fetch_assoc()){
                echo "<tr><td>" . $row["cid"] . "</td></tr>";
            }
            echo '</table></div>';


            //CHECK TO SEE IF STUDENT'S FORM 1 HAS BEEN APPROVED
            $query = "select * from formone where universityid = '$_POST[univID]' and cid = 'APPROVED'";
            $result = mysqli_query($dbc, $query);
            if ($result->num_rows <= 0){
              //IF IT HAS NOT BEEN APPROVED, GIVE A BUTTON TO APPROVE IT
              echo  '<form action="" method="post">';
              echo  '<button type="submit" name="acceptform1" value="'.$_POST["univID"].'">Accept Form 1</button>';
              echo	'</form>';
            }
            $query = "select program, applied_to_grad from student where unid = '$_POST[univID]'";
            $result = mysqli_query($dbc, $query);
            if($result->num_rows > 0){
              //IF IT HAS BEEN APPROVED, CHECK TO SEE IF USER IS A PHD STUDENT AND NEEDS THEIR THESIS APPROVED
              $row = $result->fetch_assoc();
              if(strcmp($row["program"], 'PHD') == 0 && $row["applied_to_grad"] == 1){
                echo  '<form action="" method="post">';
                echo  '<button type="submit" name="acceptthesis" value="'.$_POST["univID"].'">Accept Thesis</button>';
                echo	'</form>';

              }
            }
          }else{
            echo "<center>No Form Data Found</center>";
          }
        }else{
          echo "<center>No Results Found</center>";
        }
      }else{
        echo '<center>Student Not Found</center>';
      }

    // THIS IS FOR GS AND ADMIN : ALLOWS THEM TO VIEW EVERY USER AND THEIR ADVISOR ID'S. CANNOT CLEAR A USER'S THESIS.
    }else{
      //ALLOW GS/ADMIN TO ASSIGN THE STUDENT'S ADVISOR
      ?>
      <div class="row">
      <?php
      echo '<br><form action="" class="mx-auto mb-4" method="post">';
      echo  '<label for="assignAdvi">Assign Student to an Advisor</label>';
      ?><div class="col"><?php
      echo  '<input type="text" class="form-control form-control-lg text-muted" id="assignAdvi" name="assignAdvi">';
      ?></div>
      <div class="col"><?php
      echo  '<input type="hidden" id="assignstuID" name="assignstuID" value ="'.$_POST['univID'].'">';
      echo  '<input type="submit" class="btn btn-primary mt-2 btn-block btn-md" name="Assign" value="Assign">';
      ?></div><?php
      echo	'</form><br>';
      ?>
    </div>
    <?php
      echo '<center><h4 class="text-success">Student Found</h4></center><div class="basicdata">';
      $input = $_POST['univID'];


      //LOADING BASIC STUDENT DATA
      $query = "select * from student WHERE u_id = '$input'"; // and (NOT applied_to_grad = 3)";
      $result = mysqli_query($dbc, $query);
      if(mysqli_num_rows($result) > 0){
        echo '<table style="width:100%">';
        echo '<tr><th>University ID</th><th>Advisor ID</th><th>GPA</th><th>Program</th><th>Applied to Grad?</th></tr>';
        while($row = $result->fetch_assoc()){
          echo "<td>" . $row["u_id"]. "</td><td>" . $row["advisorid"]. "</td><td>" . $row["gpa"]. "</td><td>" . $row["major"]. "</td>";
          $stuID = $row["u_id"];
          if($row["applied_to_grad"] == 0){
            echo "<td>No</td></tr>";
          }
          else{
            echo "<td>Yes</td></tr>";
          }
        }
        echo '</table></div>';
        echo '<hr />';

        //SHOW STUDENT'S TRANSCRIPT (ONLY IF BASIC DATA APPEARS)
        $query = "select DISTINCT u_id, semester, year, grade, title, credits, courses_taken.crn from courses_taken join schedule join catalog WHERE u_id = ". $_POST['univID'] ." and catalog.c_id = courses_taken.crn;";
        $result = mysqli_query($dbc, $query);
        echo '<center><h4>Transcript</h4></center><div class="transcript">';
        if ($result->num_rows > 0){//
          echo '<table style="width:100%">';
          echo '<tr><th>Year</th><th>Semester</th><th>Course ID</th><th>Title</th><th>Grade</th><th>Credits</th></tr>';
          while($row = $result->fetch_assoc()){
              echo "<tr><td>" . $row["year"]. "</td><td>" . $row["semester"]. "</td><td>" . $row["crn"]. "</td><td>" . $row["title"]. "</td><td>" . $row["grade"]. "</td><td>" . $row["credits"]. "</td></tr>";
          }
          echo '</table></div>';
          echo '<hr />';


          //SHOW STUDENT FORMONE DATA (ONLY IF TRANSCRIPT APPEARS)
          $query = "select * from formone where universityid = " . $_POST['univID'];
          $result = mysqli_query($dbc, $query);
          echo '<center><h4>Form One Data</h4></center><div class="formdata">';
          if ($result->num_rows > 0){
            echo '<table style="width:100%">';
            echo '<tr><th>Course ID</th></tr>';
            while($row = $result->fetch_assoc()){
                echo "<tr><td>" . $row["cid"] . "</td></tr>";
            }
            echo '</table></div>';


            //CHECK TO SEE IF STUDENT'S FORM 1 HAS BEEN APPROVED
            $query = "select * from formone where universityid = '$_POST[univID]' and cid = 'APPROVED'";
            $result = mysqli_query($dbc, $query);
            if ($result->num_rows <= 0){
              //IF IT HAS NOT BEEN APPROVED, GIVE A BUTTON TO APPROVE IT
              echo  '<form action="" method="post">';
              echo  '<button type="submit" name="acceptform1" value="'.$_POST["univID"].'">Accept Form 1</button>';
              echo	'</form>';
            }
            $query = "select program, applied_to_grad from student where u_id = '$_POST[univID]'";
            $result = mysqli_query($dbc, $query);
            if($result->num_rows > 0){
              //IF IT HAS BEEN APPROVED, CHECK TO SEE IF USER IS A PHD STUDENT AND NEEDS THEIR THESIS APPROVED
              $row = $result->fetch_assoc();
              if((strcmp($row["program"], 'MS') == 0 && $row["applied_to_grad"] == 1)|| $row["applied_to_grad"] == 2){
                  //IF THEY ARE, GIVE A BUTTON FOR ADVISOR TO GRADUATE THEM
                echo  '<form action="" method="post">';
                echo  '<button type="submit" name="cleargrad" value="'.$_POST["univID"].'">Clear For Graduation</button>';
                echo  '<input type="hidden" name="univID" value="'.$_POST["univID"].'">';
                echo	'</form>';
              }
            }
          }else{
            echo "<center>No Form Data Found</center>";
          }
        }else{
          echo "<center>No Results Found</center>";
        }
      }else{
        echo '<center>Student Not Found</center>';
      }
    }
  }





  //SHOW ALL STUDENTS : THIS IS ONLY SHOWN IF A STUDENT HAS NOT YET BEEN SEARCHED
  else{
    //DISPLAY ALL USERS FOR GS AND ADMIN
    if((strcmp($_SESSION['p_level'], 'GS') == 0 || strcmp($_SESSION['p_level'], 'Admin') == 0)){
      echo '<center><h4>Student Selection</h4></center><div class="stuData">';
   	  $query = "select * from student";
      $result= mysqli_query($dbc, $query);

      //PRINT OUT ALL USERS TO A TABLE
      if ($result->num_rows > 0){
        echo '<table style="width:100%">';
        echo '<tr><th>First Name</th><th>Last Name</th><th>University ID</th><th>Advisor ID</th><th>Program</th></tr>';
        while($row = $result->fetch_assoc()){
          echo "<tr><td>" . $row["fname"]. "</td><td>" . $row["lname"]. "</td><td>" . $row["u_id"]. "</td><td>" . $row["advisorid"]. "</td><td>" . $row["program"]. "</td></tr>";
        }
        echo '</table></div><br>';
      }
      else{
        echo "0 results";
      }
    }


    //DISPLAY ONLY USERS FOR THE SELECTED ADVISOR
    else if((strcmp($_SESSION['p_level'], 'Advisor') == 0)){
      echo '<center><h4>Student Selection</h4></center><div class="advstuData">';
   	  $query = "select * from student where advisorid = '$_SESSION[uID]'";
      $result= mysqli_query($dbc, $query);

      //PRINT OUT USERS TO A TABLE
      if ($result->num_rows > 0){
        echo '<table style="width:100%">';
        echo '<tr><th>First Name</th><th>Last Name</th><th>University ID</th><th>Program</th></tr>';
        while($row = $result->fetch_assoc()){
          echo "<tr><td>" . $row["fname"]. "</td><td>" . $row["lname"]. "</td><td>" . $row["u_id"]. "</td><td>" . $row["program"]. "</td></tr>";
        }
        echo '</table></div><br>';
      }
      else{
        echo "0 results";
      }

    }
  }
  $dbc->close();
?>
        </div>
	    </div>
  </body>
</html>
