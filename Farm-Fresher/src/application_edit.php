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

include ('php/connectvars.php');

if (empty($_SESSION['id'])) {
    header("Location: login.php");
}

if (strcmp($_SESSION['p_level'],'Applicant')) {
    header("Location: login.php");
}

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

$row = '';

if (isset($_POST['submit'])) {
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$query = "UPDATE application SET GRE_ScoreVerbal='".$_POST['GRE_ScoreVerbal']."',GRE_ScoreQuantitative='".$_POST['GRE_ScoreQuantitative']."',GRE_Date='".$_POST['GRE_Date']."',AdvGRE_Score='".$_POST['AdvGRE_Score']."',AdvGRE_Subject='".$_POST['AdvGRE_Subject']."',
				AdvGRE_Date='".$_POST['AdvGRE_Date']."',TOEFL_Score='".$_POST['TOEFL_Score']."',TOEFL_Date='".$_POST['TOEFL_Date']."',MS_GPA='".$_POST['MS_GPA']."',MS_Major='".$_POST['MS_Major']."',MS_Year='".$_POST['MS_Year']."',MS_University='".$_POST['MS_University']."', 
				B_GPA='".$_POST['B_GPA']."',B_Major='".$_POST['B_Major']."',B_Year='".$_POST['B_Year']."',B_University='".$_POST['B_University']."',experience='".$_POST['experience']."',interests='".$_POST['interests']."' WHERE username=".$_SESSION['id'];
	$data = mysqli_query($dbc, $query);

}

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$query = "SELECT * FROM application WHERE username=".$_SESSION['id'];
$applicantdata = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($applicantdata);

?>
	<body>
    	<br><br>
    	<div class="container pt-3">
		<?php if(isset($_POST['submit'])) { echo "<div class='alert alert-success' role='alert'>Successfully Submitted Changes</div>"; } ?>
    	<h1 class="text-primary">Application</h1><div class='card p-5 mt-4'>
		<form method="post" name="app" onsubmit="return validate();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div class="row pt-4  text-center">
				<div class="col-lg form-group">
					<h4 class="text-primary">TESTS<h4>
				</div>
			</div>

			<div class="row">
				<div class="col-lg form-group">
					<label for="verbalgre">GRE Verbal:</label>
					<input class="form-control form-control-lg text-muted" type="number" maxlength="10" name="GRE_ScoreVerbal" value="<?php echo $row['GRE_ScoreVerbal']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 form-group">
					<label for="quantgre">GRE Quantitative:</label>
					<input class="form-control form-control-lg text-muted" type="number" maxlength="10" name="GRE_ScoreQuantitative" value="<?php echo $row['GRE_ScoreQuantitative']; ?>">
				</div>
				<div class="col-md-6 form-group">
					<label for="gre_date">GRE Year Taken:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="<?php echo date("Y"); ?>" name="GRE_Date" value="<?php echo $row['GRE_Date']; ?>">
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 form-group">
					<label for="advgre">Adv. GRE Score:</label>
					<input class="form-control form-control-lg text-muted" type="number" maxlength="10" name="AdvGRE_Score" value="<?php echo $row['AdvGRE_Score']; ?>">
				</div>
				<div class="col-md-6 form-group">
					<label for="advgre_sub">Adv. GRE Subject:</label>
					<input class="form-control form-control-lg text-muted" type="text" maxlength="254" name="AdvGRE_Subject" value="<?php echo $row['AdvGRE_Subject']; ?>">
				</div>
			</div>

			<div class="row">
				<div class="col-lg form-group">
					<label for="advgre_date">Adv. GRE Year Taken:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="<?php echo date("Y"); ?>" name="AdvGRE_Date" value="<?php echo $row['AdvGRE_Date']; ?>"/>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 form-group">
					<label for="toefl">TOEFL Score:</label>
					<input class="form-control form-control-lg text-muted" type="number" maxlength="10" name="TOEFL_Score" value="<?php echo $row['TOEFL_Score']; ?>">
				</div>
				<div class="col-md-6 form-group">
					<label for="toefl_date">TOEFL Year Taken:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="<?php echo date("Y"); ?>" name="TOEFL_Date" value="<?php echo $row['TOEFL_Date']; ?>">
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
					<input class="form-control form-control-lg text-muted" type="number" min="0" max="4" step="0.01" name="MS_GPA" value="<?php echo $row['MS_GPA']; ?>" />
				</div>
				<div class="col form-group">
					<label for="ms_major">Major:</label>
					<input class="form-control form-control-lg text-muted" type="text" maxlength="254" name="MS_Major" value="<?php echo $row['MS_Major']; ?>" />
				</div>
				<div class="col form-group">
					<label for="ms_year">Year:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="<?php echo date("Y"); ?>" name="MS_Year" value="<?php echo $row['MS_Year']; ?>" />
				</div>
				<div class="col form-group">
					<label for="ms_uni">University:</label>
					<input class="form-control form-control-lg text-muted" type="text" maxlength="254" name="MS_University" value="<?php echo $row['MS_University']; ?>" />
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
					<input class="form-control form-control-lg text-muted" type="number" min="0" max="4" step="0.01" name="B_GPA" value="<?php echo $row['B_GPA']; ?>" />
				</div>

				<div class="col form-group">
					<label for="b_major">Major:</label>
					<input class="form-control form-control-lg text-muted" type="text" maxlength="254" name="B_Major" value="<?php echo $row['B_Major']; ?>" />
				</div>

				<div class="col form-group">
					<label for="b_year">Year:</label>
					<input class="form-control form-control-lg text-muted" type="number" min="1900" max="<?php echo date("Y"); ?>" name="B_Year" value="<?php echo $row['B_Year']; ?>" />
				</div>

				<div class="col form-group">
					<label for="b_uni">University:</label>
					<input class="form-control form-control-lg text-muted" type="text" maxlength="254" name="B_University" value="<?php echo $row['B_University']; ?>" />
				</div>

			</div>

			<div class="row">
				<div class="col-md">
					<label for="experience">Experience</label>
					<textarea class="form-control form-control-lg text-muted" maxlength="1000" name="experience" rows="4" cols="50"><?php echo $row['experience']; ?></textarea>
				</div>
			</div>

			<div class="row">
				<div class="col-md">
					<label for="interests">Interests</label>
					<textarea class="form-control form-control-lg text-muted" maxlength="1000" name="interests" rows="4" cols="50"><?php echo $row['interests']; ?></textarea>
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
