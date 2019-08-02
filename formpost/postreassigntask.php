
<?php

include_once '../connection/connection_details.php';
date_default_timezone_set('America/New_York');
$datetime = date('Y-m-d H:i:s');


if (isset($_POST['assigntask_id'])) {
    $var_assigntask_id = intval($_POST['assigntask_id']);
    $var_reassign_group = ($_POST['reassign_group']);
    $var_reassign_TSM = ($_POST['reassign_TSM']);
}

//pull info for assigned task
$reasstaskinfo = $conn1->prepare("UPDATE customeraction_asgntasks
    SET customeraction_asgntasks_TOTSM = '$var_reassign_TSM', customeraction_asgntasks_GROUP = '$var_reassign_group', customeraction_asgntasks_DATE = '$datetime'
    WHERE idcustomeraction_asgntasks = $var_assigntask_id;");
$reasstaskinfo->execute();
$reasstaskinfoarray = $reasstaskinfo->fetchAll(pdo::FETCH_ASSOC);


