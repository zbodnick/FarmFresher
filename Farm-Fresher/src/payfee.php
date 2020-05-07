<!DOCTYPE html>
<html lang="en">

<head>
    <title>Application</title>
    <?php
    require_once ('header.php');
    session_start();
	?>
</head>

<?php

include ('php/connectvars.php');

if (isset($_POST['submit'])) {
    header("Location: home.php");
}

?>

<body>
    	<br><br>
    	<div class="container pt-3">
		<?php if(isset($_POST['submit'])) { echo "<div class='alert alert-success' role='alert'>Successfully Submitted Information</div>"; } ?>
    	<h1 class="text-primary">Fee Payment</h1><div class='card p-5 mt-4'>
		<form method="post" name="app" onsubmit="return validate();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div class="row">
				<div class="col-md-4 form-group">
					<label for="fname">Card Holder's First Name</label>
					<input type="text" id="fname" name="fname" maxlength="254" class="form-control form-control-lg text-muted" value="" required>
				</div>
				<div class="col-md-4 form-group">
					<label for="mname">Last Name</label>
					<input type="text" id="mname" name="lname" maxlength="254" class="form-control form-control-lg text-muted" value="" required>
				</div>
                <div class="col-md-4 form-group">
					<label for="email">Postal Code</label>
					<input type="number" id="postal" name="postal" max="99999" class="form-control form-control-lg text-muted" value="" required>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 form-group">
					<label for="email">Card Number</label>
					<input type="number" id="num" name="num" min="0" max="9999999999999999" class="form-control form-control-lg text-muted" value="" required>
				</div>
				<div class="col-md-4 form-group">
					<label for="address">CVV</label>
					<input type="number" id="cvv" name="cvv" min="000" max="999" class="form-control form-control-lg text-muted" value="" required>
				</div>
				<div class="col-md-4 form-group">
					<label for="ssn">Expiration Date</label>
					<input type="month" id="exp" name="exp" class="form-control form-control-lg text-muted" value="" required >
				</div>
                <div class="row mb-3 mt-2">
                    <div class="col text-center">
                        <input type="submit" id="btn" value="Submit Payment" name="submit" class="btn btn-primary btn-lg px-5">
                    </div>
                </div>  
			</div>
        </form>
        </div>
        </div>
	</body>
</html>
