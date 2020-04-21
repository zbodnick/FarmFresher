<?php
	require_once('connectvars.php');
	session_start();

	$error_msg = "";
	$page_title='Application';
	
	require_once('header.php');
	echo '<hr />';	
	echo '<div class="nav"><button id="btn" onclick="window.location.href = \'index.php\';">Home Page</button></div>';
	echo '<hr />';

	function randNum () {
		$new = rand(10000001,99999999);
		check($new);
		return $new;
	}

	function check($new) {	
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$query = "SELECT * FROM user where username='".$new."'";
		$data = mysqli_query($dbc, $query);
		if(mysqli_num_rows($data)) {
			randNum();
		}
	}

	if (isset($_POST['submit'])) {

		$username = randNum();

		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		$user = "INSERT INTO user VALUES (".$username.",'".$_POST['password']."',1,'".$_POST['fname']."','".$_POST['lname']."')";
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
		$header = "From: drooffco@gwu.edu";
		$retval = mail($_POST['email'],"New Login Information",$msg, $header);
         
         /*if( $retval == true ) {
            echo "Message1 sent successfully...";
         }else {
            echo "Message1 could not be sent...";
         }*/

		//echo"email2: ".$_POST['recommender']."\n";
		$msg = "Hello you have been selected to be a recommender by ".$_POST['fname']." ".$_POST['lname'].". The applicationID that you will need later is ".($row['ID']+1).". Here is the link to fill out the recommendation form: http://gwupyterhub.seas.gwu.edu/~sp20DBp1-no_sql/no_sql/index/reccomendation.php";
		//You may need to change the link in the email above depending on who's aws account you are using.
		$msg = wordwrap($msg,70);
		$retval = mail($_POST['recommender'],"Recommendation for ".$_POST['fname']." ".$_POST['lname'],$msg, $header);
         
         /*if( $retval == true ) {
            echo "Message2 sent successfully...";
         }else {
            echo "Message2 could not be sent...";
         }*/

		header("Location: index.php");
	}
?>

	<head>
		<script type = "text/javascript">
			<!--
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
			-->
		</script>
	</head>

	<body>
		<form method="post" name="app" onsubmit="return validate();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<label for="fname">First Name:</label>
			<input type="text" name="fname" value="" required/><?php echo $error_msg; ?><br />
			<br/>
			<label for="mname">Middle Name:</label>
			<input type="text" name="mname" value=""/><br />
			<br/>
			<label for="lname">Last Name:</label>
			<input type="text" name="lname" value="" required/><br />
			<br/>
			<label for="address">Address:</label>
			<input type="text" name="address" value="" required/><br />
			<br/>
			<label for="ssn">SSN:</label>
			<input type="text" name="ssn" value="" required/><br />
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
			<b><i>Tests:</i></b><br />
				<label for="verbalgre">GRE Verbal:</label>
				<input type="number" name="verbalgre" value="" /><br />
				<br/>
				<label for="quantgre">GRE Quantitative:</label>
				<input type="number" name="quantgre" value="" /><br />
				<br/>
				<label for="gre_date">GRE Year Taken:</label>
				<input type="number" min="1900" max="2020" name="gre_date" value="" /><br />
				<br/>
				<label for="advgre">Adv. GRE Score:</label>
				<input type="number" name="advgre" value="" /><br />
				<br/>
				<label for="advgre_sub">Adv. GRE Subject:</label>
				<input type="text" name="advgre_sub" value="" /><br />
				<br/>
				<label for="advgre_date">Adv. GRE Year Taken:</label>
				<input type="number" min="1900" max="2020" name="advgre_date" value="" /><br />
				<br/>
				<label for="toefl">TOEFL Score:</label>
				<input type="number" name="toefl" value="" /><br />
				<br/>
				<label for="toefl_date">TOEFL Year Taken:</label>
				<input type="number" min="1900" max="2020" name="toefl_date" value="" /><br />
				<br/>
			<b><i>Prior Degrees:</i></b><br />
				<label for="ms_prior">MS:</label>
				<input type="checkbox" name="ms_prior" value="1" />
				<label for="ms_gpa">GPA:</label>
				<input type="text" name="ms_gpa" value="" />
				<label for="ms_major">Major:</label>
				<input type="text" name="ms_major" value="" />
				<label for="ms_year">Year:</label>
				<input type="number" min="1900" max="2020" name="ms_year" value="" />
				<label for="ms_uni">University:</label>
				<input type="text" name="ms_uni" value="" />
				<br/>
				<label for="b_prior">BS/BA:</label>
				<input type="checkbox" name="b_prior" value="1" />
				<label for="b_gpa">GPA:</label>
				<input type="number" name="b_gpa" value="" />
				<label for="b_major">Major:</label>
				<input type="text" name="b_major" value="" />
				<label for="b_year">Year:</label>
				<input type="number" min="1900" max="2020" name="b_year" value="" />
				<label for="b_uni">University:</label>
				<input type="text" name="b_uni" value="" />
				<br/>
				<br/>
			<b><i>Degree Type for Application:</i></b><br />
				<input type="radio" id="ms" name="dgr" value="ms" required/>
				<label for="ms">MS</label>
				<input type="radio" id="pdh" name="dgr" value="phd" required/>
				<label for="phd">PhD</label><br>
				<br/>
			<b><i>Experience:</i></b><br/>
				<textarea name="experience" rows="4" cols="50"></textarea><br/>
				<br/>
			<b><i>Areas of Interest:</i></b><br/>
				<textarea name="interests" rows="4" cols="50"></textarea><br/>
				<br/>
			<label for="recommender">Recommender Email:</label>
			<input type="email" name="recommender" value="" required/><br />
			<br/>
			<input id="btn" type="submit" value="Submit Application" name="submit" />
		</form>
	</body>
</html>
