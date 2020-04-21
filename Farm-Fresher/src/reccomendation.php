<!DOCTYPE html>
<html lang="en">

<head>
    <title>Recommendation</title>
    <?php 
    require_once ('header.php'); 
    session_start();
	?>

	<script type = "text/javascript">
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
	</script>
</head>

<?php

	$error_msg = "";
	
	// echo '<hr />';	
	// echo '<div class="nav"><button id="btn" onclick="window.location.href = \'index.php\';">Home Page</button></div>';
	// echo '<hr />';

	if (empty($_SESSION['id'])) {
		header("Location: login.php");
	}
	
	include ('php/connectvars.php');		
	
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    function randNum () 
    {
		$new = rand(10000001,99999999);
		check($new);
		return $new;
	}

    function check($new) 
    {	
		$query = "SELECT * FROM user where username='.$new.'";
		$data = mysqli_query($dbc, $query);
		if(mysqli_num_rows($data)) {
			randNum();
		}
	}

    if (isset($_POST['submit'])) 
    {
		$new = randNum();
        
		$user = "INSERT INTO user VALUES (".$new.",'".$_POST['password']."',1,'".$_POST['fname']."','".$_POST['lname']."')";
		$userdata = mysqli_query($dbc, $user);
        
        //Modify for reccomender
		$applicant = "INSERT INTO reccomender VALUES (".$_POST['applicationid'].",'".$_POST['email']."','".$_POST['reccomendation']."')";
		$applicantdata = mysqli_query($dbc, $applicant);

		header("Location: index.php");
	}
?>

	<body>
    	<br><br>
    	<div class="container pt-3">
    	<h1 class="text-primary">Recommendation</h1>
		<form method="post" name="app" onsubmit="return validate();" action="<?php echo $_SERVER['PHP_SELF']; ?>">

			<div class="row">
				<div class="col-md-6 form-group">
					<label for="fname">First Name</label>
					<input type="text" class="form-control form-control-lg text-muted" name="fname" value="" required/><?php echo $error_msg; ?>
				</div>
				<div class="col-md-6 form-group">
					<label for="lname">Last Name</label>
					<input type="text" class="form-control form-control-lg text-muted" name="lname" value="" required/>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 form-group">
					<label for="applicationid">Application ID (see email)</label>
            		<input type="text" class="form-control form-control-lg text-muted" name="applicationid" value="" required/><?php echo $error_msg; ?>
				</div>
				<div class="col-md-6 form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control form-control-lg text-muted" name="email" value="" required/>
				</div>
			</div>

			<div class="row pt-4 border-top text-center">
				<div class="text-primary col-lg form-group">
					<h4>You will recieve an email upon submission of your application with login information<h4>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 form-group">
					<label for="password">New Password</label>
					<input type="password" id="password" name="password" class="form-control form-control-lg text-muted" value="" required>
				</div>
				<div class="col-md-6 form-group">
					<label for="password2">Confirm Password</label>
					<input type="password" id="password2" name="password2" class="form-control form-control-lg text-muted" value="" required>
				</div>
			</div>

			<div class="row">
				<div class="col-md">
					<label for="experience">Recommendation</label>
					<textarea class="form-control form-control-lg text-muted" name="reccomendation" rows="12" cols="100"></textarea>
				</div>
			</div>

            <div class="row mb-3 mt-2">
                <div class="col text-center">
                    <input type="submit" id="btn" value="Submit Recommendation" name="submit" class="btn btn-primary btn-lg px-5">
                </div>
            </div>
		</form>
	</body>
</html>