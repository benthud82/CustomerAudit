<?php

include_once '../connection/connection_details.php';
$var_userid = strtoupper($_GET['userid']);


$comptasks = $conn1->prepare("SELECT idcustomeraction_comptasks,
                                   customeraction_comptasks_ASGNTSM,
                                   customeraction_comptasks_ASGNDATE,
                                   customeraction_comptasks_TOTSM,
                                   customeraction_comptasks_GROUP,
                                   customeraction_comptasks_COMPDATE,
                                   customeraction_comptasks_CUSTGROUP, 
                                   customeraction_comptasks_GROUPID, 
                                   customeraction_comptasks_ITEM, 
                                   customeraction_comptasks_COMMENT
                            FROM custaudit.customeraction_comptasks 
                            WHERE UPPER(customeraction_comptasks_TOTSM) = '$var_userid'
                            ORDER BY customeraction_comptasks_COMPDATE desc;");
$comptasks->execute();
$comptasksarray = $comptasks->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($comptasksarray as $key => $value) {
    $row[] = array_values($comptasksarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
