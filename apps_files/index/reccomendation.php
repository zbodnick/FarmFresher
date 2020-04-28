<?php
	require_once('connectvars.php');

	$error_msg = "";
	$page_title='reccomendation';
	
	require_once('header.php');
	echo '<hr />';	
	echo '<div class="nav"><button id="btn" onclick="window.location.href = \'index.php\';">Home Page</button></div>';
	echo '<hr />';

    function randNum () 
    {
		$new = rand(10000001,99999999);
		check($new);
		return $new;
	}

    function check($new) 
    {	
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$query = "SELECT * FROM user where username='.$new.'";
		$data = mysqli_query($dbc, $query);
		if(mysqli_num_rows($data)) {
			randNum();
		}
	}

    if (isset($_POST['submit'])) 
    {
		$new = randNum();
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        
		$user = "INSERT INTO user VALUES (".$new.",'".$_POST['password']."',1,'".$_POST['fname']."','".$_POST['lname']."')";
		$userdata = mysqli_query($dbc, $user);
        
        //Modify for reccomender
		$applicant = "INSERT INTO reccomender VALUES (".$_POST['applicationid'].",'".$_POST['email']."','".$_POST['reccomendation']."')";
		$applicantdata = mysqli_query($dbc, $applicant);

		header("Location: index.php");
	}
?>

	<head>
		<script type = "text/javascript">
			<!--
				function validate() {
					var fname = document.app.fname.value;
					var lname = document.app.lname.value;

					var special = new RegExp(/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/);
					var ssnSpecial = new RegExp(/[#$%^&*()+=\[\]\';,.\/{}|":<>?~\\\\]/);

					if ((document.app.password.value).localeCompare(document.app.password2.value) != 0) {
						alert('Passwords do not match');
						return false;
					}

					<?php $error_msg=""; ?>
					return true; 
				}
			-->
		</script>
	</head>

	<body>
		<form method="post" name="app" onsubmit="return validate();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="applicationid">applicationid (provided in your email): </label>
            <input type="text" name="applicationid" value="" required/><?php echo $error_msg; ?><br />
            <label for="fname">First Name:</label>
            <input type="text" name="fname" value="" required/><?php echo $error_msg; ?><br />
            <label for="lname">Last Name:</label>
			<input type="text" name="lname" value="" required/><br />
			<br/>
            <label for="email">Email:</label>
			<input type="email" name="email" value="" required/><br />
			<br/><br/>
			<b>YOU WILL RECEIVE AN EMAIL AFTER SUBMITTING APPLICATION WITH LOGIN INFORMATION</b><br/>
			<label for="password">New password for login:</label>
			<input type="password" name="password" value="" required/><br />
			<label for="password2">Confirm password:</label>
			<input type="password" name="password" value="" required/><br />
			<br/>
			
			Reccomendation:<br/>
			<textarea name="reccomendation" rows="12" cols="100"></textarea><br/>
			<br/>
			<input id="btn" type="submit" value="Submit reccomendation" name="submit" />
		</form>
	</body>
</html>
