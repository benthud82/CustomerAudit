
<?php

//$var_cust = $_GET['customer'];
//include_once '../functions/customer_audit_functions.php';
//include '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../connection/connection_details.php';
$result1 = $conn1->prepare("SELECT 
                                                        shipacc_summ_date AS shipaccdate,
                                                        SUM(shipacc_summ_count) AS shipacccount
                                                    FROM
                                                        custaudit.massalgorithm_shipacc_summary
                                                    GROUP BY shipacc_summ_date");
$result1->execute();



$rows = array();
$rows['name'] = 'Date';
$rows1 = array();
$rows1['name'] = 'Ship Acc. Opportunity';

foreach ($result1 as $row) {
    $rows['data'][] = $row['shipaccdate'];  //Date push
    $rows1['data'][] = $row['shipacccount'] * 1;  //total count
}

$result = array();
array_push($result, $rows);
array_push($result, $rows1);

print json_encode($result);
