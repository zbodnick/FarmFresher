<?php
    $page_title='System Admin';
    require_once('header.php');
    require_once('connectvars.php');
    session_start();
    $search = '';
    if (isset($_POST['submit'])) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "SELECT * FROM user where username='".$_POST['user']."'";
		$data = mysqli_query($dbc, $query);
		if(0==mysqli_num_rows($data)) {
			$query = "INSERT INTO user VALUES (".$_POST['user'].",'".$_POST['pass']."',".$_POST['perm'].",'".$_POST['fname']."','".$_POST['lname']."')";
            $data = mysqli_query($dbc, $query);
		}
    }
    else if (isset($_POST['search'])) {
        if (!empty($_POST['userSearch'])) {
            $search = "SELECT username,password,permission,fname,lname FROM user WHERE username='". $_POST['userSearch'] ."'";
        }
        else {
            $search = "SELECT username,password,permission,fname,lname FROM user";
        }
    }
    else if (isset($_POST['delete'])) {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "DELETE FROM user WHERE username='".$_POST['username']."'";
            $data = mysqli_query($dbc, $query);

            $query = "DELETE FROM applicant WHERE username='".$_POST['username']."'";
            $data = mysqli_query($dbc, $query);

            $query = "DELETE FROM application WHERE username='".$_POST['username']."'";
            $data = mysqli_query($dbc, $query);

            $search = "SELECT username,password,permission FROM user";
    }
?>

<div class="nav"><button id="btn" onclick="window.location.href='logout.php';">Log Out</button></div>
<hr>
<b>CREATE USER:</b>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="username">Username:</label>
    <input type="text" name="user" value="" required/><br />
    <br/>
    <label for="password">Password:</label>
    <input type="text" name="pass" value="" required/><br />
    <br/>
    <label for="permission">Permission:</label>
    <input type="text" name="perm" value="" required/><br />
    <br/>
    <label for="fname">First name:</label>
    <input type="text" name="fname" value="" required/><br />
    <br/>
    <label for="lname">Last name:</label>
    <input type="text" name="lname" value="" required/><br />
    <input type="hidden" name="userSearch" value=""/><br />
    <input id="btn" type="submit" value="Create User" name="submit" />
</form>

<hr>
<b>SEARCH USERS:</b><br/>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="userSearch">Username:</label>
    <input type="text" name="userSearch" value="" /><br />
    <input id="btn" type="submit" value="Search" name="search" />
</form>
<hr>
<?php 
    if(!empty($_POST['userSearch'])) { 
        echo '<table>
                <tr><td>Username</td><td>Password</td><td>Name</td><td>Permission</td><td><td/>';
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $data = mysqli_query($dbc, $search);
        while ($row = mysqli_fetch_array($data)) {
            echo '<tr><td>'.$row['username'].'</td><td>'.$row['password'].'</td><td>'.$row['fname']." ".$row['lname'].'</td><td>'.$row['permission'].'</td><td width="50px"><form action="sysadmin.php" method="post"><input type="submit" id="btn" value="Delete" name="delete"><input type="hidden" name="username" value="'.$row['username'].'" /></form></td>';
        }
    }
    else if (isset($_POST['search'])) {
        echo '<table>
                <tr><td>Username</td><td>Password</td><td>Name</td><td>Permission</td>';
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $data = mysqli_query($dbc, $search);
        while ($row = mysqli_fetch_array($data)) {
            echo '<tr><td>'.$row['username'].'</td><td>'.$row['password'].'</td><td>'.$row['fname']." ".$row['lname'].'</td><td>'.$row['permission'].'</td><td><form action="sysadmin.php" method="post"><input type="submit" id="btn" value="Delete" name="delete"><input type="hidden" name="username" value="'.$row['username'].'" /></form></td>';
        }
    }
?>