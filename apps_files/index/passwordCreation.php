<?php
	require_once('connectvars.php');
	session_start();

	$error_msg = "";
	$page_title='Create Password';
	
	require_once('header.php');
	echo '<hr />';	
	echo '<div class="nav"><button id="btn" style="visibility:hidden" onclick="window.location.href = \'index.php\';">Home Page</button></div>';
    echo '<hr />';

    if (isset($_POST['submit'])) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "INSERT INTO user VALUES (".$_SESSION['username'].",'".$_POST['password']."',".$_POST['permission'].",'".$_SESSION['fname']."','".$_SESSION['lname']."')";
        $data = mysqli_query($dbc, $query);
        $_SESSION = array();
		session_destroy();
		header('Location: ' . "index.php");
    }
?>

<br><b>YOUR USERNAME IS: <?php echo $_SESSION['username']; ?></b>

<form method="post" action="passwordCreation.php">
    <label for="password">New Password:</label>
    <input type="password" name="password" value="" /><br />
    <label for="passwordConfirm">Confirm Password:</label>
    <input type="password" name="passwordConfirm" /><br/>
    <input type="hidden" name="fname" value="<?php echo $_SESSION['fname'] ?>" />
    <input type="hidden" name="lname" value="<?php echo $_SESSION['lname'] ?>" />
    <input type="hidden" name="permission" value="1" />
    <input type="submit" id="btn" value="Create Password" name="submit" />
</form>