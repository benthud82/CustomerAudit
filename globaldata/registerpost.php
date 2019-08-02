<?php
//add the user to the slottingdb_users table
include_once '../connection/connection_details.php';

$userid = $_POST["username"];
$userfirst = $_POST["firstname"];
$userlast = $_POST["lastname"];
$usergroup = ($_POST["groupsel"]);

$result1 = $conn1->prepare("INSERT INTO custaudit.customeraudit_users (customeraudit_users_ID, customeraudit_users_FIRSTNAME, customeraudit_users_LASTNAME, customeraudit_users_GROUP) values ('$userid','$userfirst','$userlast', '$usergroup')");
$result1->execute();

header('Location: ../signin.php');