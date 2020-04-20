<?php

    session_start();
    $page_title = 'GWU Advising System';
    $error_msg = "";

     require_once('connectvars.php');
     require_once('appvars.php');
     require_once('header.php');
     require_once('navmenu.php');

     echo '<h4>Personal Information: </h4>';

     if (isset($_SESSION['uID']))
     {

    echo '<body>Change info below<br/></body>';

     $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
     $uid = $_SESSION['uID'];

          if (empty($_SESSION['uID']))
          {
          	echo '<p class="error">' . $error_msg . '</p>';
          }

          $query = "select * from personalinfo where universid = $uid";
          $result = mysqli_query($dbc, $query);

          if(mysqli_num_rows($result) == 0){
            echo '<body>No personal info found<br/></body>';
            $ftname = " ";
            $ltname = " ";
            $dob = " ";
            $address = " ";
            $cell = " ";

            $dbc->query('SET foreign_key_checks = 0');
            $val = "INSERT INTO personalinfo VALUES ($uid, 'X', 'X', '1900-01-01', 'X', 0);";
            if($dbc->query($val) == FALSE){
              echo "$dbc->error";
            }

            header("refresh:1; url=changeinfo.php");

          }else{
            while($row = mysqli_fetch_array($result))
              {
              $ftname = $row["ftname"];
              $ltname = $row["ltname"];
              $dob = $row["dob"];
              $address = $row["address"];
              $cell = $row["cell"];

              //DISPLAYING USER'S PERSONAL INFO
              echo "<form action= updateinfo.php method = post> <br>";
              echo "First Name: "."<input type = text  name = fname value = '".$ftname."'> <br>";
              echo "Last Name: "."<input type = text  name = lname value = '".$ltname."'> <br>";
              echo "Date of Birth: "."<input type = text  name = dob value = '".$dob."'> <br>";
              echo "Address: "."<input type = text  name = address value = '".$address."'> <br>";
              echo "Cellphone: "."<input type = text  name = cell value = '".$cell."'> <br>";
              echo "<input type = hidden name = id value ='".$row['universid']."'>";
              echo "<input type = submit>";
              echo "</form>";
              echo '<br>';
              }
          }
    $dbc->query('SET foreign_key_checks = 1');
    $dbc->close();
  }else{
    echo 'Error No UID';
  }

  require_once('footer.php');
?>
