<?php
session_start();

    include ('php/connectvars.php');
    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $uid =  $_GET["id"];

    $lift_hold_query = "UPDATE student SET has_hold=0 WHERE u_id=$uid";
    mysqli_query($dbc, $lift_hold_query);
    $dbc->query('SET foreign_key_checks = 0');
    // echo $drop;
    // die(mysqli_error($dbc));

    header("Location: advising_holds_review.php?approved=true");
?>