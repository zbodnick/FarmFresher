<!DOCTYPE html>
<html lang="en">

<head>
    <title>Applicant Portal</title>
    <?php
    require_once ('header.php');
    session_start();
	?>
</head>

<?php

if (empty($_SESSION['id'])) {
    header("Location: login.php");
}

include ('php/connectvars.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$dbc->query('SET foreign_key_checks = 0');
?>

	<body>
	<br><br>
	<div class="container mt-5 pt-3">
        <h1 class="text-primary"> Current Applications </h1> <br>
		<input class="form-control" id="search_filter" type="text" placeholder="Search...">

		<?php
		//   echo '<hr />';
		//   echo '<div class="nav"><button id="btn" onclick="window.location.href = \'logout.php\';">Logout</button>
		// 				<button id="btn" onclick="window.location.href = \'index.php\';">Profile</button></div>';
		//   echo '<hr />';

		?>

		<div class="row mt-3">
			<table class="table table-bordered">

				<thead>
					<tr class="text-center table-primary">
						<th scope="col"> SCHOOL </th>
						<th scope="col"> STATUS </th>
					</tr>
				</thead>
		        <?php
		          $query = "SELECT * FROM application JOIN reviewer_application ON application.username=reviewer_application.applicantID WHERE application.username='".$_SESSION['id']."'";
		          $data = mysqli_query($dbc, $query);

		          // If The log-in is OK
		          if (mysqli_num_rows($data) == 1) {
		            while ($row = mysqli_fetch_array($data))
		            {
		              echo '<tr><td>'.$row['applicationID'].'</td><td>'.$row['status'].'</td><td id="btnSq"><form method="post" action="application_view.php" target="_blank"><button type="submit" name="view" value="'.$row['applicationID'].'" id="view">View</button></form></td>';
		            }
		          }

		          //displaying the schools and status
		          $query = "select degree_type, final_decision from app where username = '".$_SESSION['id']."'";
		          $data = mysqli_query($dbc, $query);
		        ?>

				<tbody id="apps_status_table">

		<?php
          //checking to see if there are any rows returned
            while ($row = mysqli_fetch_array($data))
            {
              echo '<tr><td>'.$row['degree_type'].'</td>';
              if(strcmp($row['final_decision'], "")==0)
              {
                echo'<td>decision pending</td>';
              }
              else
              {
                echo '<td>'.$row['final_decision'].'</td>';
              }

            }
        ?>
				</tbody>

			</table>
		</div>

	</div>
  </body>
</html>
