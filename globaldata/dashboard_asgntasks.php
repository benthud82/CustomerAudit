<?php

include_once '../connection/connection_details.php';
$var_userid = strtoupper($_GET['userid']);


$mytasks = $conn1->prepare("SELECT idcustomeraction_asgntasks,
                                   customeraction_asgntasks_ASGNTSM,
                                   customeraction_asgntasks_DATE,
                                   customeraction_asgntasks_TOTSM,
                                   customeraction_asgntasks_GROUP,
                                   customeraction_asgntasks_CUSTGROUP, 
                                   customeraction_asgntask_GROUPID, 
                                   customeraction_asgntasks_ITEM, 
                                   customeraction_asgntasks_COMMENT,
                                   ' '
                            FROM custaudit.customeraction_asgntasks 
                            WHERE customeraction_asgntasks_STATUS = 'OPEN' and UPPER(customeraction_asgntasks_TOTSM) = '$var_userid'
                            ORDER BY customeraction_asgntasks_DATE asc;");
$mytasks->execute();
$mytasksarray = $mytasks->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($mytasksarray as $key => $value) {
    $row[] = array_values($mytasksarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
