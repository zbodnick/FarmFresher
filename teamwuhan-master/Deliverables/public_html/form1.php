<!DOCTYPE html>
<html>

	<body>

	<?php
    session_start();

		$page_title = 'GWU Advising System';

		//Load php tag into file once
	  require_once('connectvars.php');
	  require_once('appvars.php');
		require_once('header.php');
	  require_once('navmenu.php');

	 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


	?>

	<h1>Form One</h1>
	<form action="javascript:return false();" method="post">
		<input type="checkbox" id="6221" name="6221" value="6221">
		<label for="6221">CSCI 6221 SW Paradigms</label><br>

		<input type="checkbox" id="6461" name="6461" value="6461">
		<label for="6461">CSCI 6461 Computer Architecture</label><br>

		<input type="checkbox" id="6212" name="6212" value="6212">
		<label for="6212">CSCI 6212 Algorithms </label><br>

		<input type="checkbox" id="6220" name="6220" value="6220">
		<label for="6220">CSCI 6220 Machine Learning </label><br>

		<input type="checkbox" id="6232" name="6232" value="6232">
		<label for="6232">CSCI 6232 Networks 1 </label><br>

		<input type="checkbox" id="6233" name="6233" value="6233">
		<label for="6233">CSCI 6233 Networks 2 </label><br>

		<input type="checkbox" id="6241" name="6241" value="6241">
		<label for="6241">CSCI 6241 Database 1 </label><br>

		<input type="checkbox" id="6242" name="6242" value="6242">
		<label for="6242">CSCI 6242 Database 2</label><br>

		<input type="checkbox" id="6246" name="6246" value="6246">
		<label for="6246">CSCI 6246 Compilers </label><br>

		<input type="checkbox" id="6260" name="6260" value="6260">
		<label for="6260">CSCI 6260 Multimedia </label><br>

		<input type="checkbox" id="6251" name="6251" value="6251">
		<label for="6251">CSCI 6251 Cloud Computing</label><br>

		<input type="checkbox" id="6254" name="6254" value="6254">
		<label for="6254">CSCI 6254 SW Engineering </label><br>

		<input type="checkbox" id="6262" name="6262" value="6262">
		<label for="6262">CSCI 6262 Graphics 1 </label><br>

		<input type="checkbox" id="6283" name="6283" value="6283">
		<label for="6283">CSCI 6283 Security 1 </label><br>

		<input type="checkbox" id="6284" name="6284" value="6284">
		<label for="6284">CSCI 6284 Cryptography</label><br>

		<input type="checkbox" id="6286" name="6286" value="6286">
		<label for="6286">CSCI 6286 Network Security</label><br>

		<input type="checkbox" id="6325" name="6325" value="6325">
		<label for="6325">CSCI 6325 Algorithms 2 </label><br>

		<input type="checkbox" id="6339" name="6339" value="6339">
		<label for="6339">CSCI 6339 Embedded Systems</label><br>

		<input type="checkbox" id="6384" name="6384" value="6384">
		<label for="6384">CSCI 6384 Cryptography 2 </label><br>

		<input type="checkbox" id="6241" name="6241" value="6241">
		<label for="6241">ECE 6241 Communication Theory </label><br>

		<input type="checkbox" id="6242" name="6242" value="6242">
		<label for="6242">ECE 6242 Information Theory</label><br>

		<input type="checkbox" id="6210" name="6210" value="6210">
		<label for="6210">MATH 6210 Logic </label><br>

		<input type="submit" value="Submit">
	</form>


  <?php
    require_once('footer.php');
  ?>
	</body>

</html>
