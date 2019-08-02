<?php

include_once '../connection/connection_details.php';
$mastergroupid = intval($_POST['mastergroupid']);

$sql = "DELETE FROM custaudit.scorecard_mastergroupings WHERE mastergroupings_GROUPID = $mastergroupid";
$query = $conn1->prepare($sql);
$query->execute();


