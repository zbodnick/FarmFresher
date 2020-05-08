<?php
  session_start();
	$page_title = 'GWU Advising System';

	//Load php tag into file once
  require_once('php/connectvars.php');
  require_once('appvars.php');
  require_once('navmenu.php');
 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $dbc->query('SET foreign_key_checks = 0');
  $id = $_SESSION['id'];
  $queryA = "SELECT SUM(CASE grade WHEN 'A' THEN 1 ELSE 0 END) totalA FROM courses_taken WHERE u_id = $id;";
  $numberOfAs = mysqli_query($dbc, $queryA);
  $numberOfAs = $numberOfAs->fetch_assoc();
  $resultA= $numberOfAs['totalA'];

  $queryB = "SELECT SUM(CASE grade WHEN 'B' THEN 1 ELSE 0 END) totalB FROM courses_taken WHERE u_id = $id;";
  $numberOfBs = mysqli_query($dbc, $queryB);
  $numberOfBs = $numberOfBs->fetch_assoc();
  $resultB= $numberOfBs['totalB'];

  $queryC = "SELECT SUM(CASE grade WHEN 'C' THEN 1 ELSE 0 END) totalC FROM courses_taken WHERE u_id = $id;";
  $numberOfCs = mysqli_query($dbc, $queryC);
  $numberOfCs = $numberOfCs->fetch_assoc();
  $resultC= $numberOfCs['totalC'];

  $queryD = "SELECT SUM(CASE grade WHEN 'D' THEN 1 ELSE 0 END) totalD FROM courses_taken WHERE u_id = $id;";
  $numberOfDs = mysqli_query($dbc, $queryD);
  $numberOfDs = $numberOfDs->fetch_assoc();
  $resultD= $numberOfDs['totalD'];

  $queryF = "SELECT SUM(CASE grade WHEN 'F' THEN 1 ELSE 0 END) totalF FROM courses_taken WHERE u_id = $id;";
  $numberOfFs = mysqli_query($dbc, $queryF);
  $numberOfFs = $numberOfFs->fetch_assoc();
  $resultF= $numberOfFs['totalF'];

  $query2 = "select sum(A.credits) credits from (select DISTINCT u_id, semester, year, grade, title, credits from courses_taken join schedule join catalog WHERE u_id = " . $id . " and catalog.c_id = courses_taken.crn) as A;";
  $chours = mysqli_query($dbc, $query2);
  $chours = $chours->fetch_assoc();
  $totalhours= $chours['credits'] + 0.00;

  $approvedreturn = "SELECT COUNT(cid) approvedreturn FROM formone WHERE universityid = $id AND cid = 'APPROVED';";
  $formone = mysqli_query($dbc, $approvedreturn);
  $formone = $formone->fetch_assoc();
  $aprv= $formone['approvedreturn'];

         function avgGPAfunction($resultA, $resultB, $resultC, $resultD, $resultF, $totalhours)
         {
            $attemptedhours = ($resultA * 4.0 * 3) + ($resultB * 3.0 * 3) + ($resultC * 2.0 * 3) + ($resultD * 1.0 * 3) + ($resultF * 0.0 * 3);
            $avggpa = $attemptedhours / $totalhours;
            return $avggpa;
         }
  $avggpa = avgGPAfunction($resultA, $resultB, $resultC, $resultD, $resultF, $totalhours);

         function numBadGrades($resultC, $resultD, $resultF)
         {
            $numBadGrades = $resultC + $resultD + $resultF;
            return $numBadGrades;
         }
   $numBadGrades = numBadGrades($resultC, $resultD, $resultF);


  //$query3 = "SELECT SUM(chours) choursCSCI FROM transcript WHERE univerid = $id AND crseid LIKE 'CSCI%';";
  $query3 = "select sum(A.credits) credits from (select DISTINCT u_id, semester, year, grade, title, credits from courses_taken join schedule join catalog WHERE u_id = " . $id . " and catalog.c_id = courses_taken.crn) as A;";
  $choursCSCI = mysqli_query($dbc, $query3);
  $choursCSCI = $choursCSCI->fetch_assoc();
  $choursCSCItotal = $choursCSCI['credits'];


  $query4 = "SELECT program FROM student WHERE u_id = $id;" ;
  $studenttype = mysqli_query($dbc, $query4);
  $studenttype = $studenttype->fetch_assoc();
  $program = $studenttype['program'];






  echo $avggpa;

  if($program == 'MS' && $avggpa >= 3.0 && $chours >= 30 && $numBadGrades <= 2 && $aprv == 1)
  {
    $queryMS = "UPDATE student SET applied_to_grad = 1 WHERE u_id = $id;";
    if(mysqli_query($dbc, $queryMS) == TRUE)
    {
      echo "<br>";
      echo "Request to the Graduate Secretary is sent to clear you for graduation. Stay tuned.";
      echo "<br>";
    }
  }
  else if($program == 'PHD' && $avggpa > 3.5 && $chours >= 36 && $numBadGrades <= 1 && $aprv == 1 && $choursCSCI >= 30 )
  {
    $queryPHD = "UPDATE student SET applied_to_grad = 2 WHERE u_id = $id;";
    if(mysqli_query($dbc, $queryPHD) == TRUE)
    {
      echo "<br>";
      echo "Request to your Faculty Advisor is sent to approve your thesis. Stay tuned.";
      echo "<br>";
    }
  }
  else
  {
    echo "<br>";
    echo "You do not meet the requirements to graduate.";
    echo "<br>";
  }

    $queryGPA = "UPDATE student SET gpa = $avggpa WHERE unid = $id;";
    mysqli_query($dbc, $queryGPA);

  require_once('footer.php');

?>
