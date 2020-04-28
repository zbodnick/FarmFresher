<?php
  require_once('connectvars.php');

  session_start(); 

  $error_msg = "";
  // --------------------------------------------------------------------------
  // check if the user is already logged in
  //
  if (!isset($_SESSION['username'])){
    if (isset($_POST['submit'])) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($user_username) && !empty($user_password)) {
        $query = "SELECT username,permission FROM user WHERE username='".$user_username."' and password='".$user_password."'";; 
        $data = mysqli_query($dbc, $query);

        // If The log-in is OK 
        if (mysqli_num_rows($data) == 1) {
          
          $row = mysqli_fetch_array($data);

          $_SESSION['username'] = $row['username'];
          $_SESSION['permission'] = $row['permission'];

          // redirect user to respective page
          if ($_SESSION['permission'] == 2) {
            $home_url = "reviewer_portal.php";
          } else if ($_SESSION['permission'] == 3) {
            $home_url = "gscac_portal.php";
          } else if ($_SESSION['permission'] == 1) {
            $home_url = "applicant_portal.php";
          } else if ($_SESSION['permission'] == 4) {
            $home_url = "sysadmin.php";
          }

          header('Location: ' . $home_url);
        }
        else {
          // The username/password are incorrect so set an error message
          $error_msg = 'Sorry, you must enter a valid username and password to log in.';
        }
      }
      else {
        // The username/password weren't entered so set an error message
        $error_msg = 'Sorry, you must enter your username and password to log in.';
      }
    }
  }
  else {
    if ($_SESSION['permission'] == 2) {
      $home_url = "reviewer_portal.php";
    } else if ($_SESSION['permission'] == 3) {
      $home_url = "gscac_portal.php";
    } else if ($_SESSION['permission'] == 1) {
      $home_url = "applicant_portal.php";
    } else if ($_SESSION['permission'] == 4) {
      $home_url = "sysadmin.php";
    }

    header('Location: ' . $home_url);
  }
  //
  // -------------------------------------------------------------------------------

  // Insert the page header
  $page_title = 'Log In';
  require_once('header.php');

  echo '<hr />';
  echo '<div class="nav"><button id="btn" onclick="window.location.href = \'application.php\';">Apply Now!</button>
        <button id="btn" onclick="window.location.href = \'reset.php\';">RESET DATABASE</button></div>';
  echo '<hr />';
  
?>

  <form method="post" action="index.php">
    <fieldset>
      <legend>Log In</legend>
      <?php echo '<i style="color:red">'.$error_msg.'</i>'; ?>
      <label for="username">Username:</label>
      <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br />
      <label for="password">Password:</label>
      <input type="password" name="password" /><br/>
      <input type="submit" id="btn" value="Log In" name="submit" />
    </fieldset>
  </form>
</body>
</html>
