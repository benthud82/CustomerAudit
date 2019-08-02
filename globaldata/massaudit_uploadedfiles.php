<?php

include_once '../connection/connection_details.php';



$customerdata = $conn1->prepare("SELECT upload_filename,
                                                                                          upload_custtype,
                                                                                          upload_custid,
                                                                                          upload_date,
                                                                                          upload_tsm
                                                                                    FROM custaudit.custaudit_massaudituploads
                                                                                    ORDER BY upload_date desc");
$customerdata->execute();
$customerdataarray = $customerdata->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($customerdataarray as $key => $value) {
    $row[] = array_values($customerdataarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
