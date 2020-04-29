<!DOCTYPE html>
<html lang="en">

<head>
    <title>Form One</title>
    <?php
    require_once ('header.php');
    session_start();
	?>
</head>

<?php

$id = $_SESSION["id"];

if (empty($id)) {
    header("Location: login.php");
}

include ('php/connectvars.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$dbc->query('SET foreign_key_checks = 0');
?>

<script type="text/javascript">

function populateCookies()
{
	var expires;
	var date = new Date();
	date.setTime(date.getTime() + (10 * 24 * 60 * 60 * 1000));
	expires = "; expires=" + date.toGMTString();

	var tot=0;

	var array = [];

	var input = document.getElementsByTagName('input');
	document.getElementsByTagName('input')[1].checked = true;

	//if(chkcontroll() != false){
		for(var i = 0; i < input.length; i++) {
			if(input[i].checked == true){
				document.cookie = input[i].value + "=" + "True" + expires + "; path=/";
			}else{
				document.cookie = input[i].value + "=" + "False" + expires + "; path=/";
			}
		}
	/*}else{
		for(var i = 0; i < input.length; i++) {
				document.cookie = input[i].value + "=" + "False" + expires + "; path=/";
		}
	}*/
}
</script>

<body>
<br><br>

    <div class="container pt-3">
    <form method="post" class="card ml-5 mr-5 mb-5" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="card-header">
        <h1 class="text-primary">Form One</h1>
        <h4 class="pl-1 font-weight-lighter"><small>Mark the checkboxes of the courses you intend on taking/have taken</small></h4>
    </div>
        <?php

        // Schedule links to faculty on crn
        // Courses not being taught shouldnt have a proffesoror time alloted to them

        $course_query = 'SELECT * from catalog';

        $result = mysqli_query($dbc, $course_query);

        if (mysqli_num_rows($result) > 0) {
            ?>
            <table class="table ">
                <thead>
                <tr class="text-center">
                    <th scope="col">Course</th>
                    <th scope="col">Title</th>
                    <th scope="col">Credits</th>
                    <th scope="col">Pre-requisite 1</th>
                    <th scope="col">Pre-requisite 2</th>
                    <th scope="col"></th>
                </tr>
                </thead>
            <tbody id="course_table">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr class="text-center">
                <td>
                <?php

                $cid = $row["c_id"];

                $crn = $row["c_no"];
                $dept = $row["department"];
                $title = $row["title"];
                $credits = $row["credits"];

                $prereq_query = "SELECT prereq1, prereq2 FROM prereqs WHERE course_Id=$cid";
                $query_result = mysqli_query($dbc, $prereq_query);
                $data = mysqli_fetch_assoc($query_result);
                $pre1 = explode(' ', trim($data['prereq1']));
                $pre2 = explode(' ', trim($data['prereq2']));

                ?>

                <a href="course.php?cno=<?php echo $crn ?>&dept=<?php echo $dept ?>"> <?php echo $dept ?> <?php echo $crn ?> </a>
                </td>
                <td> <?php echo $title?> </td>
                <td> <?php echo $credits?> </td>

                <?php if (empty($data['prereq1']) && !empty($data['prereq2'])) { ?>
                    <td>None</td>

                    <td>
                    <?php echo $pre2[0] ?> <?php echo $pre2[1] ?>
                    </td>
                <?php } else if (!empty($data['prereq1']) &&  empty($data['prereq2'])) { ?>
                    <td>
                    <?php echo $pre1[0] ?> <?php echo $pre1[1] ?>
                    </td>
                    <td>None</td>
                 <?php } else if (!empty($data['prereq1']) && !empty($data['prereq2'])) { ?>
                    <td>
                    <?php echo $pre1[0] ?> <?php echo $pre1[1] ?>
                    </td>

                    <td>
                    <?php echo $pre2[0] ?> <?php echo $pre2[1] ?>
                    </td>
                <?php  } else { ?>
                    <td>None</td>
                    <td>None</td>
                 <?php } ?>

                <td>
                    <label class="btn btn-primary">
                    <input type="checkbox" value = "<?php$cid?>" autocomplete="off">
                    <span class="glyphicon glyphicon-ok"></span>
                </td>
			    </label>
                </tr>

        <?php
            }
            echo "</tbody>
            </table>";
        } else {
            echo "Error: form one cannot find any classes";
        }
        ?>
         <div class="row mx-auto">
            <div class="col-lg p-2">
            <input type="submit" value="Submit Form" name="submit" onclick='populateCookies();' class="btn btn-primary btn-lg px-5">
            </div>
        </div>
        </form>
    </div>


    <script>
    $(document).ready(function(){
    $("#search_filter").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#course_table tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    });
    </script>

		<?php
		$course_query = 'SELECT * from catalog';

		$result = mysqli_query($dbc, $course_query);
		if(!$result){
			echo("Error description: " . $mysqli -> error);
		}
		if(isset($_POST['submit']))
		{
			if (mysqli_num_rows($result) > 0) {
					$cid = $row["c_id"];
					if($_COOKIE[$cid] == "True"){
						$dbc->query("INSERT INTO formone VALUES ($id, '$cid')");
					}
			}
		}
		?>

</body>

</html>
