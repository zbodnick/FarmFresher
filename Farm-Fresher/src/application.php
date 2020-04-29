<!DOCTYPE html>
<html lang="en">

<head>
    <title>Application</title>
    <?php
    require_once ('header.php');
    session_start();
	?>

	<script type = "text/javascript">
	function validate() {
		var retVal = true;
		var fname = document.app.fname.value;
		var mname = document.app.mname.value;
		var lname = document.app.lname.value;
		var address = document.app.address.value;
		var quantgre = document.app.quantgre.value;
		var mathgre = document.app.verbalgre.value;
		var gre = document.app.gre.value;

		var special = new RegExp(/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/);
		var ssnSpecial = new RegExp(/[#$%^&*()+=\[\]\';,.\/{}|":<>?~\\\\]/);
		if (special.test(fname) || special.test(mname) || special.test(lname) || special.test(address) || ssnSpecial.test(ssn) || special.test(gre) || special.test(quantgre) || special.test(verbalgre)) {
			alert('No special characters in names, address, or ssn');
			retVal= false;
		}

		document.app.ssn.value = document.app.ssn.value.replace('-','');
		if (isNaN(document.app.ssn.value)) {
			alert('No characters in ssn');
			retVal= false;
		}

		if (document.app.password.value != document.app.password2.value) {
			retVal= false;
		}

		return retVal;
		}
		</script>
</head>

<?php

/*if (isset($_SESSION['id']))
	$id = $_SESSION['id'];

if (!empty($id)) {
    header("Location: home.php");
}*/

include ('php/connectvars.php');


function randNum () {
	$new = rand(10000001,99999999);
	check($new);
	return $new;
}

function check($new) {
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$query = "SELECT * FROM users where id=".$new;
	$data = mysqli_query($dbc, $query);
	if(mysqli_num_rows($data)) {
		randNum();
	}
}

if (isset($_POST['submit'])) {
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  	$dbc->query('SET foreign_key_checks = 0');
	$username = randNum();

	$user = "INSERT INTO users VALUES (".$username.",'Applicant','".$_POST['password']."')";
	$userdata = mysqli_query($dbc, $user);

	$applicant = "INSERT INTO applicant VALUES (".$username.",'".$_POST['fname']."','".$_POST['lname']."','".$_POST['email']."',".$_POST['ssn'].",'".$_POST['address']."')";
	$applicantdata = mysqli_query($dbc, $applicant);

	$maxID = "SELECT max(applicationID) as ID FROM application";
	$data = mysqli_query($dbc, $maxID);
	$row = mysqli_fetch_array($data);
	$appID = $row['ID']+1;
	$application = "INSERT INTO application VALUES (
		".$appID.",
		".$username.",
		0,
		'".$_POST['recommender']."',
		'".$_POST['verbalgre']."',
		'".$_POST['quantgre']."',
		'".$_POST['gre_date']."',
		'".$_POST['advgre']."',
		'".$_POST['advgre_sub']."',
		'".$_POST['advgre_date']."',
		'".$_POST['toefl']."',
		'".$_POST['toefl_date']."',
		'".$_POST['ms_prior']."',
		'".$_POST['ms_gpa']."',
		'".$_POST['ms_major']."',
		'".$_POST['ms_year']."',
		'".$_POST['ms_uni']."',
		'".$_POST['b_prior']."',
		'".$_POST['b_gpa']."',
		'".$_POST['b_major']."',
		'".$_POST['b_year']."',
		'".$_POST['b_uni']."',
		'".$_POST['experience']."',
		'".$_POST['interests']."',
		0,
		0,
		'n/a',
		'".$_POST['dgr']."',
		0)";
	$applicationdata = mysqli_query($dbc, $application);

	$reviewerIDS = "SELECT id FROM users WHERE NOT EXISTS (SELECT * FROM reviewer_application WHERE users.id = reviewer_application.username) AND users.p_level='Faculty' ORDER BY id ASC";
	$reviewerQ = mysqli_query($dbc, $reviewerIDS);

	if(mysqli_num_rows($reviewerQ) != 0) {
		$row = mysqli_fetch_array($reviewerQ);

		$insertReviewer = "INSERT INTO reviewer_application VALUES(". $row['id'] .",". $username .",0)";
		$reviewerInsert = mysqli_query($dbc, $insertReviewer);
	}
	else {
		$reviewerIDS = "SELECT count(username) as count,username from reviewer_application  group by username order by count asc, username asc";
		$reviewerQ = mysqli_query($dbc, $reviewerIDS);

		$row = mysqli_fetch_array($reviewerQ);
		$insertReviewer = "INSERT INTO reviewer_application VALUES(". $row['username'] .",". $username .",0)";
		$reviewerInsert = mysqli_query($dbc, $insertReviewer);
	}

	$msg = "Hello new applicant! Your new username to login is:\n".$username;
	$header = "From: farmfresh@gmail.edu";
	$retval = mail($_POST['email'],"New Login Information",$msg, $header);

	$msg = "Hello you have been selected to be a recommender by ".$_POST['fname']." ".$_POST['lname']."! You will recieve a second email shortly with a verification code to verify your recommendation. Once you have the verification code, you may follow the link below to complete the recommendation. In the recommendation form, fill out the APPLICANT's first and last name (NOT YOUR OWN), the verification code recieved in the subsequent email, and YOUR email that you recieved these emails in. These steps are for security purposes only. We appreciate your cooperation. Here is the link to fill out the recommendation form: http://gwupyterhub.seas.gwu.edu/~sp20DBp2-FarmFresher/Farm-Fresher/src/recommendation.php\nThank you!";
	$header = "From: farmfresh@gmail.edu";
	$retval = mail($_POST['recommender'],"Recommendation for ".$_POST['fname']." ".$_POST['lname'],$msg, $header);

	$verification = rand(10001,99999);
	$msg = "YOUR VERICATION CODE IS: ".$verification." for the Farm Fresher University system. Please see previous email for instructions.";
	$header = "From: farmfresh@gmail.edu";
	$retval = mail($_POST['recommender'],"Verification Code",$msg, $header);

	$verCode = "INSERT INTO verification_codes VALUES (".$username.",".$verification.")";
	$verQ = mysqli_query($dbc, $verCode);

  	$dbc->query('SET foreign_key_checks = 1');
}
?>
	<body>
    	<br><br>
    	<div class="container pt-3">
		<?php if(isset($_POST['submit'])) { echo "<div class='alert alert-success' role='alert'>Successfully Submitted Application</div>"; } ?>
    	<h1 class="text-primary">Application</h1><div class='card p-5 mt-4'>
		<form method="post" name="app" onsubmit="return validate();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div class="row">
				<div class="col-md-4 form-group">
					<label for="fname">First Name</label>
					<input type="text" id="fname" name="fname" maxlength="254" class="form-control form-control-lg text-muted" value="" required>
				</div>
				<div class="col-md-4 form-group">
					<label for="mname">Middle Name</label>
					<input type="text" id="mname" name="mname" maxlength="254" class="form-control form-control-lg text-muted" value="">
				</div>
				<div class="col-md-4 form-group">
					<label for="lname">Last Name</label>
					<input type="text" id="lname" name="lname" maxlength="254" class="form-control form-control-lg text-muted" value="" required>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 form-group">
					<label for="email">Email Address</label>
					<input type="text" id="email" name="email" maxlength="254" class="form-control form-control-lg text-muted" value="">
				</div>
				<div class="col-md-4 form-group">
					<label for="address">Address</label>
					<input type="text" id="address" name="address" maxlength="254" class="form-control form-control-lg text-muted" value="">
				</div>
				<div class="col-md-4 form-group">
					<label for="ssn">SSN</label>
					<input type="text" id="ssn" name="ssn" maxlength="9" class="form-control form-control-lg text-muted" value="" required>
				</div>
			</div>

			<div class="row pt-4 border-top">
				<div class="text-primary col-lg form-group">
					<h4 class="font-italic">Remember your password, you will recieve an email upon submission of your application with login instructions<h4>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 form-group">
					<label for="password">New Password</label>
					<input type="password" id="password" name="password" maxlength="20" class="form-control form-control-lg text-muted" value="" required>
				</div>
				<div class="col-md-6 form-group">
					<label for="password2">Confirm Password</label>
					<input type="password" id="password2" name="password2" maxlength="20" class="form-control form-control-lg text-muted" value="" required>
				</div>
			</div>
			<div class="row pt-4 border-top text-center">
				<div class="col-lg form-group">
					<h4 class="text-primary">TESTS<h4>
				</div>
			</div>

			<div class="row">
				<div class="col-lg form-group">
					<label for="verbalgre">GRE Verbal:</label>
					<input class="form-control form-control-lg text-muted" type="number" maxlength="10" name="verbalgre" value="">
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 form-group">
					<label for="quantgre">GRE Quantitative:</label>
					<input class="form-control form-control-lg text-muted" type="number" maxlength="10" name="quantgre" value="">
				</div>
				<div class="col-md-6 form-group">
					<label for="gre_date">GRE Year Taken:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="2020" name="gre_date" value="">
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 form-group">
					<label for="advgre">Adv. GRE Score:</label>
					<input class="form-control form-control-lg text-muted" type="number" maxlength="10" name="advgre" value="">
				</div>
				<div class="col-md-6 form-group">
					<label for="advgre_sub">Adv. GRE Subject:</label>
					<input class="form-control form-control-lg text-muted" type="text" maxlength="254" name="advgre_sub" value="">
				</div>
			</div>

			<div class="row">
				<div class="col-lg form-group">
					<label for="advgre_date">Adv. GRE Year Taken:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="2020" name="advgre_date" value=""/>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 form-group">
					<label for="toefl">TOEFL Score:</label>
					<input class="form-control form-control-lg text-muted" type="number" maxlength="10" name="toefl" value="">
				</div>
				<div class="col-md-6 form-group">
					<label for="toefl_date">TOEFL Year Taken:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="2020" name="toefl_date" value="">
				</div>
			</div>

			<div class="row pt-4 border-top text-center">
				<div class="text-primary col-lg form-group">
					<h4>PRIOR DEGREES<h4>
				</div>
			</div>

			<div class="row">

				<div class="col form-group">
					<label for="ms_prior">MS:</label>
					<input name="ms_prior" type="hidden" value="N/A" />
					<input class="form-control form-control-lg text-muted" type="checkbox" name="ms_prior" value="Yes" />
				</div>

				<div class="col form-group">
					<label for="ms_gpa">GPA:</label>
					<input class="form-control form-control-lg text-muted" type="text" maxlength="4" name="ms_gpa" value="" />
				</div>
				<div class="col form-group">
					<label for="ms_major">Major:</label>
					<input class="form-control form-control-lg text-muted" type="text" maxlength="254" name="ms_major" value="" />
				</div>
				<div class="col form-group">
					<label for="ms_year">Year:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="2020" name="ms_year" value="" />
				</div>
				<div class="col form-group">
					<label for="ms_uni">University:</label>
					<input class="form-control form-control-lg text-muted" type="text" maxlength="254" name="ms_uni" value="" />
				</div>
			</div>

			<div class="row">

				<div class="col form-group">
					<label for="b_prior">BS/BA:</label>
					<input name="b_prior" type="hidden" value="N/A" />
					<input class="form-control form-control-lg text-muted" type="checkbox" name="b_prior" value="Yes" />
				</div>

				<div class="col form-group">
					<label for="b_gpa">GPA:</label>
					<input class="form-control form-control-lg text-muted" type="text" maxlength="4" name="b_gpa" value="" />
				</div>

				<div class="col form-group">
					<label for="b_major">Major:</label>
					<input class="form-control form-control-lg text-muted" type="text" maxlength="254" name="b_major" value="" />
				</div>

				<div class="col form-group">
					<label for="b_year">Year:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="2020" name="b_year" value="" />
				</div>

				<div class="col form-group">
					<label for="b_uni">University:</label>
					<input class="form-control form-control-lg text-muted" type="text" maxlength="254" name="b_uni" value="" />
				</div>

			</div>

			<div class="row pt-4 border-top">
				<div class="col-md text-right">
					<h4 class="text-primary mr-0">Applying for: <h4>
				</div>
				<div class="col-md text-left ml-0">
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" id="ms" name="dgr" value="ms" required>
						<label class="form-check-label" for="ms">MS</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" id="phd" name="dgr" value="phd" required>
						<label class="form-check-label" for="phd">PhD</label>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md">
					<label for="experience">Experience</label>
					<textarea class="form-control form-control-lg text-muted" maxlength="1000" name="experience" rows="4" cols="50"></textarea>
				</div>
			</div>

			<div class="row">
				<div class="col-md">
					<label for="interests">Interests</label>
					<textarea class="form-control form-control-lg text-muted" maxlength="1000" name="interests" rows="4" cols="50"></textarea>
				</div>
			</div>

			<div class="row pt-3 mb-2">
				<div class="col-lg">
					<label for="recommender">Recommender's Email</label>
					<input class="form-control form-control-lg text-muted" maxlength="254" name="recommender" value="" required></textarea>
				</div>
			</div>

			<div class="row mb-3 mt-2">
                <div class="col text-center">
                    <input type="submit" id="btn" value="Submit Application" name="submit" class="btn btn-primary btn-lg px-5">
                </div>
            </div>
		</form>
	</div></div>
	</body>
</html>
