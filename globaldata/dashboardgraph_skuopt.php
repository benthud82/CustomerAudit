
<?php

//$var_cust = $_GET['customer'];
//include_once '../functions/customer_audit_functions.php';
//include '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../connection/connection_details.php';

$result1 = $conn1->prepare("SELECT 
                                                        skuopt_summ_date as skuoptdate, SUM(skuopt_summ_count) as skuoptcount
                                                    FROM
                                                        custaudit.massalgorithm_skuopt_summary
                                                    GROUP BY skuopt_summ_date;");
$result1->execute();



$rows = array();
$rows['name'] = 'Date';
$rows1 = array();
$rows1['name'] = 'Sku Opt Opportunity';

foreach ($result1 as $row) {
    $rows['data'][] = $row['skuoptdate'];  //Date push
    $rows1['data'][] = $row['skuoptcount'] * 1;  //total count
}

$result = array();
array_push($result, $rows);
array_push($result, $rows1);

print json_encode($result);
