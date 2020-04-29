<?php 
    // runs all lines in sql code
    require_once('connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = file_get_contents('../Deliverables/bigProject.sql');
    $data = mysqli_multi_query($dbc, $query);
    header ('Location: index.php');
?>