<?php
include_once '../connection/connection_details.php';

$userid = trim(strtoupper($_POST['userid']));

$custgroups = $conn1->prepare("SELECT mastergroupings_GROUPID, mastergroupings_NAME FROM custaudit.scorecard_mastergroupings WHERE TRIM(UPPER(mastergroupings_TSM)) = '$userid'");
$custgroups->execute();
$custgrouparrays = $custgroups->fetchAll(pdo::FETCH_ASSOC);

echo json_encode($custgrouparrays);