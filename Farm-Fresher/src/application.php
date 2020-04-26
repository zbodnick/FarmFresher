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

		if ((document.app.password.value).localeCompare(document.app.password2.value) != 0) {
			alert('Passwords do not match');
			retVal= false;
		}

		<?php $error_msg=""; ?>
		return retVal; 
		}
		</script>
</head>

<?php

if (isset($_SESSION['id'])) 
	$id = $_SESSION['id'];

if (!empty($id)) {
    header("Location: home.php");
}

include ('php/connectvars.php');		

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


function randNum () {
	$new = rand(10000001,99999999);
	check($new);
	return $new;
}

function check($new) {	
	$query = "SELECT * FROM user where username='".$new."'";
	$data = mysqli_query($dbc, $query);
	if(mysqli_num_rows($data)) {
		randNum();
	}
}

if (isset($_POST['submit'])) {

	$username = randNum();

	$user = "INSERT INTO users VALUES (".$username.",'Applicant','".$_POST['password']."')";
	$userdata = mysqli_query($dbc, $user);
	
	$applicant = "INSERT INTO applicant VALUES (".$username.",'".$_POST['fname']."','".$_POST['lname']."',".$_POST['ssn'].",'".$_POST['address']."')";
	$applicantdata = mysqli_query($dbc, $applicant);

	$maxID = "SELECT max(applicationID) as ID FROM application";
	$data = mysqli_query($dbc, $maxID);
	$row = mysqli_fetch_array($data);
	
	$application = "INSERT INTO application VALUES (
		".($row['ID']+1).",
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
		'n/a')";
	$applicationdata = mysqli_query($dbc, $application);

	//echo"email1: ".$_POST['email']."\n";
	$msg = "Hello new applicant! Your new username to login is:\n".$username;
	$msg = wordwrap($msg,70);
	$header = "From: wdaughtridge@gwu.edu";
	$retval = mail($_POST['email'],"New Login Information",$msg, $header);

	$msg = "Hello you have been selected to be a recommender by ".$_POST['fname']." ".$_POST['lname'].". The applicationID that you will need later is ".($row['ID']+1).". Here is the link to fill out the recommendation form: http://gwupyterhub.seas.gwu.edu/~sp20DBp2-FarmFresher/Farm-Fresher/src/reccomendation.php";
	$msg = wordwrap($msg,70);
	$retval = mail($_POST['recommender'],"Recommendation for ".$_POST['fname']." ".$_POST['lname'],$msg, $header);

	header("Location: index.php");
}

?>

		<!-- <form method="post" class="card p-5 mt-4" action="<?php echo $_SERVER['PHP_SELF']; ?>"> -->
	<body>
    	<br><br>
    	<div class="container pt-3">
    	<h1 class="text-primary">Application</h1>
		<form method="post" name="app" onsubmit="return validate();" action="<?php echo $_SERVER['PHP_SELF']; ?>">

			<div class="row">
				<div class="col-md-4 form-group">
					<label for="fname">First Name</label>
					<input type="text" id="fname" name="fname" class="form-control form-control-lg text-muted" value="" required>
				</div>
				<div class="col-md-4 form-group">
					<label for="mname">Middle Name</label>
					<input type="text" id="mname" name="mname" class="form-control form-control-lg text-muted" value="" required>
				</div>
				<div class="col-md-4 form-group">
					<label for="lname">Last Name</label>
					<input type="text" id="lname" name="lname" class="form-control form-control-lg text-muted" value="" required>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 form-group">
					<label for="email">Email Address</label>
					<input type="text" id="email" name="email" class="form-control form-control-lg text-muted" value="">
				</div>
				<div class="col-md-4 form-group">
					<label for="address">Address</label>
					<input type="text" id="address" name="address" class="form-control form-control-lg text-muted" value="">
				</div>
				<div class="col-md-4 form-group">
					<label for="ssn">SSN</label>
					<input type="text" id="ssn" name="ssn" class="form-control form-control-lg text-muted" value="">
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
					<input type="password" id="password" name="password" class="form-control form-control-lg text-muted" value="" required>
				</div>
				<div class="col-md-6 form-group">
					<label for="password2">Confirm Password</label>
					<input type="password" id="password2" name="password2" class="form-control form-control-lg text-muted" value="" required>
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
					<input class="form-control form-control-lg text-muted" type="number" name="verbalgre" value="">
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 form-group">
					<label for="quantgre">GRE Quantitative:</label>
					<input class="form-control form-control-lg text-muted" type="number" name="quantgre" value="">
				</div>
				<div class="col-md-6 form-group">
					<label for="gre_date">GRE Year Taken:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="2020" name="gre_date" value="">
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 form-group">
					<label for="advgre">Adv. GRE Score:</label>
					<input class="form-control form-control-lg text-muted" type="number" name="advgre" value="">
				</div>
				<div class="col-md-6 form-group">
					<label for="advgre_sub">Adv. GRE Subject:</label>
					<input class="form-control form-control-lg text-muted" type="text" name="advgre_sub" value="">
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
					<label for="toefl_date">TOEFL Year Taken:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="2020" name="toefl_date" value="">
				</div>
				<div class="col-md-6 form-group">
					<label for="toefl">TOEFL Score:</label>
					<input class="form-control form-control-lg text-muted" type="number" name="toefl" value="">
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
					<input class="form-control form-control-lg text-muted" type="checkbox" name="ms_prior" value="1" />
				</div>

				<div class="col form-group">
					<label for="ms_gpa">GPA:</label>
					<input class="form-control form-control-lg text-muted" type="text" name="ms_gpa" value="" />
				</div>
				<div class="col form-group">
					<label for="ms_major">Major:</label>
					<input class="form-control form-control-lg text-muted" type="text" name="ms_major" value="" />
				</div>
				<div class="col form-group">
					<label for="ms_year">Year:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="2020" name="ms_year" value="" />
				</div>
				<div class="col form-group">
					<label for="ms_uni">University:</label>
					<input class="form-control form-control-lg text-muted" type="text" name="ms_uni" value="" />
				</div>
			</div>

			<div class="row">

				<div class="col form-group">
					<label for="b_prior">BS/BA:</label>
					<input class="form-control form-control-lg text-muted" type="checkbox" name="b_prior" value="1" />
				</div>

				<div class="col form-group">
					<label for="b_gpa">GPA:</label>
					<input class="form-control form-control-lg text-muted" type="number" name="b_gpa" value="" />
				</div>

				<div class="col form-group">
					<label for="b_major">Major:</label>
					<input class="form-control form-control-lg text-muted" type="text" name="b_major" value="" />
				</div>

				<div class="col form-group">
					<label for="b_year">Year:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="2020" name="b_year" value="" />
				</div>

				<div class="col form-group">
					<label for="b_uni">University:</label>
					<input class="form-control form-control-lg text-muted" type="text" name="b_uni" value="" />
				</div>

			</div>

			<div class="row pt-4 border-top">
				<div class="col-md text-right">
					<h4 class="text-primary mr-0">Applying for: <h4>
				</div>
				<div class="col-md text-left ml-0">
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" id="ms" name="dgr" value="ms">
						<label class="form-check-label" for="ms">MS</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" id="phd" name="dgr" value="phd">
						<label class="form-check-label" for="phd">PhD</label>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md">
					<label for="experience">Experience</label>
					<textarea class="form-control form-control-lg text-muted" name="experience" rows="4" cols="50"></textarea>
				</div>
			</div>

			<div class="row pt-3 mb-2">
				<div class="col-lg">
					<label for="recommender">Recommender's Email</label>
					<input class="form-control form-control-lg text-muted" name="recommender" value="" required></textarea>
				</div>
			</div>
					
			<div class="row mb-3 mt-2">
                <div class="col text-center">
                    <input type="submit" id="btn" value="Submit Application" name="submit" class="btn btn-primary btn-lg px-5">
                </div>
            </div>
		</form>
	</div>
	</body>
</html>