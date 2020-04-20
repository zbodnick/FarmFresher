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

     $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
     $uid = $_SESSION['uID'];
          
          if (empty($_SESSION['uID']))
          {
          	echo '<p class="error">' . $error_msg . '</p>';
          }
          
          $query = "select * from personalinfo where universid = $uid";
          $result= mysqli_query($dbc, $query);
          
          
          while($row = mysqli_fetch_array($result)) 
          {
          //DISPLAYING USER'S PERSONAL INFO
          echo "<form action= updateinfo.php method = post> <br>";
          echo "First Name: "."<input type = text  name = fname value = '".$row["ftname"]."'> <br>";
          echo "Last Name: "."<input type = text  name = lname value = '".$row["ltname"]."'> <br>";
          echo "Date of Birth: "."<input type = text  name = dob value = '".$row["dob"]."'> <br>";
          echo "Address: "."<input type = text  name = address value = '".$row["address"]."'> <br>";
          echo "Cellphone: "."<input type = text  name = cell value = '".$row["cell"]."'> <br>";
          echo "<input type = hidden name = id value ='".$row['universid']."'>";
          echo "<input type = submit>";
          echo "</form>";
          echo '<br>'; 
          }
        
        
    $dbc->close();
    }

  require_once('footer.php');
?>
