<!DOCTYPE html>
<html lang="en">

<head>
    <title>Recommendation</title>
    <?php 
    require_once ('header.php'); 
    session_start();
	?>
</head>

<?php
	include ('php/connectvars.php');		
	
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if (isset($_POST['submit'])) {
		$query = "SELECT * FROM verification_codes where verification=".$_POST['verification'];
		$res = mysqli_query($dbc,$query);
		if (mysqli_num_rows($res) == 1) {
			$row = mysqli_fetch_array($res);
			$username = $row['username'];

			$query = "SELECT * FROM applicant where fname='".$_POST['fname']."' AND lname='".$_POST['lname']."' AND username=".$username;
			$res = mysqli_query($dbc,$query);
			if (mysqli_num_rows($res) == 1) {
				$query = "INSERT INTO recommender VALUES('".$_POST['fname_r']."','".$_POST['lname_r']."',".$username.",'".$_POST['recommendation']."')";
				$res = mysqli_query($dbc,$query);

				$query = "DELETE FROM verification_codes WHERE verification=".$_POST['verification'];
				$res = mysqli_query($dbc,$query);
			}
			else {
				//ERROR!
			}
		}
		else {
			//ERROR!
		}
	}
?>

	<body>
    	<br><br>
    	<div class="container pt-3">
    	<h1 class="text-primary">Recommendation</h1>
		<form method="post" name="app" onsubmit="return validate();" action="<?php echo $_SERVER['PHP_SELF']; ?>">

			<div class="row">
				<div class="col-md-6 form-group">
					<label for="fname">Verify First Name <b>OF APPLICANT</b></label>
					<input type="text" class="form-control form-control-lg text-muted" name="fname" value="" required/>
				</div>
				<div class="col-md-6 form-group">
					<label for="lname">Verify Last Name <b>OF APPLICANT</b></label>
					<input type="text" class="form-control form-control-lg text-muted" name="lname" value="" required/>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 form-group">
					<label for="fname_r">YOUR First Name <b>OF RECOMMENDER</b></label>
					<input type="text" class="form-control form-control-lg text-muted" name="fname_r" value="" required/>
				</div>
				<div class="col-md-6 form-group">
					<label for="lname_r">YOUR Last Name <b>OF RECOMMENDER</b></label>
					<input type="text" class="form-control form-control-lg text-muted" name="lname_r" value="" required/>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 form-group">
					<label for="verification">Verification Code (see email)</label>
            		<input type="text" class="form-control form-control-lg text-muted" name="verification" value="" required/>
				</div>
				<div class="col-md-6 form-group">
					<label for="email">Email <b>OF RECOMMENDER</b></label>
					<input type="email" class="form-control form-control-lg text-muted" name="email" value="" required/>
				</div>
			</div>
			<div class="row">
				<div class="col-md">
					<label for="experience">Recommendation</label>
					<textarea class="form-control form-control-lg text-muted" maxlength="10000" name="recommendation" rows="12" cols="100"></textarea>
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