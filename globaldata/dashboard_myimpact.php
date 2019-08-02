<?php
include_once '../connection/connection_details.php';
$var_userid = strtoupper($_POST['userid']);


$myimpact = $conn1->prepare("SELECT * FROM custaudit.customeraction_comptasks WHERE UPPER(customeraction_comptasks_TOTSM) = '$var_userid'");
$myimpact->execute();
$myimpactarray = $myimpact->fetchAll(pdo::FETCH_ASSOC);
?>
