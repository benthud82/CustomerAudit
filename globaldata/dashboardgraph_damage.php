
<?php

//$var_cust = $_GET['customer'];
//include_once '../functions/customer_audit_functions.php';
//include '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../connection/connection_details.php';

$result1 = $conn1->prepare("SELECT 
                                                        damage_summ_date AS damagedate,
                                                        SUM(damage_summ_count) AS damagecount
                                                    FROM
                                                        custaudit.massalgorithm_damage_summary
                                                    GROUP BY damage_summ_date");
$result1->execute();



$rows = array();
$rows['name'] = 'Date';
$rows1 = array();
$rows1['name'] = 'Damage Opportunity';

foreach ($result1 as $row) {
    $rows['data'][] = $row['damagedate'];  //Date push
    $rows1['data'][] = $row['damagecount'] * 1;  //total count
}

$result = array();
array_push($result, $rows);
array_push($result, $rows1);

print json_encode($result);
