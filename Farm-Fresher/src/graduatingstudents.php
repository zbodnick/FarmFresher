<?php
require_once ('header.php');
session_start();

if (!isset ($_SESSION["id"]) || strcmp ($_SESSION["p_level"], "Admin") != 0) {
    header("Location: login.php");
}

include ('php/connectvars.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$dbc->query('SET foreign_key_checks = 0');
// Check if a student needs to be deleted

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Students - Farm Fresh Regs</title>
</head>

<body>

	<div class="container mt-5 pt-3">
        <h1 class="text-primary"> Graduation Cleared Students</h1> <br>
		<input class="form-control" id="search_filter" type="text" placeholder="Search...">


		<div class="row mt-3">
			<table class="table table-bordered">

				<thead>
					<tr class="text-center table-primary">
						<th scope="col">  U_ID </th>
						<th scope="col"> First Name </th>
						<th scope="col"> Last Name </th>
						<th scope="col"> Email </th>
						<th scope="col"> Address </th>
						<th scope="col"> Major </th>
						<th scope="col"> Program Type </th>
						<th> </th>
					</tr>
				</thead>

				<tbody id="student_table">

			<?php
				$query = 'SELECT u_id, fname, lname, email, addr, major, program
						  FROM student WHERE applied_to_grad = 1 ';
        $students = mysqli_query ($dbc, $query);
        if (isset($_POST['submit'])) {
          if(!empty($_POST['degree'])){
              $query = $query . "and program = $_POST[degree]";
              $students = mysqli_query ($dbc, $query);
          }else{

          }
        }



				while ($students && $s = mysqli_fetch_assoc ($students)) {
					echo '<tr class="text-center">';

					// Print each field of each student
					foreach ($s as $data) {
						echo '<td class="align-middle">' . $data . '</td>';
					}

				}
			?>
				</tbody>

			</table>

      <br></br><br></br><br></br>

      <h1 class="text-primary"> Alumni</h1> <br>
      <div class="row mt-3">
  			<table class="table table-bordered">

  				<thead>
  					<tr class="text-center table-primary">
  						<th scope="col"> U_ID </th>
  						<th scope="col"> First Name </th>
  						<th scope="col"> Last Name </th>
  						<th scope="col"> Email </th>
  						<th> </th>
  					</tr>
  				</thead>

  				<tbody id="student_table">

  			<?php
        //alumni list
  				$query = 'SELECT univid as U_ID, email, fname, lname
  						  FROM alumni';
          $students = mysqli_query ($dbc, $query);

  				while ($students && $s = mysqli_fetch_assoc ($students)) {
  					echo '<tr class="text-center">';

  					// Print each field of each student
  					foreach ($s as $data) {
  						echo '<td class="align-middle">' . $data . '</td>';
  					}

  				}
  			?>
  				</tbody>

  			</table>

		</div>

	</div>

</body>

<script>
    $(document).ready(function(){
    $("#search_filter").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#student_table tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    });
</script>

</html>
