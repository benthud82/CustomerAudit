<?php

include_once '../connection/connection_details.php';

$result1 = $conn1->prepare("SELECT 
                                                    CONCAT('>= ',
                                                            CAST(ROUND(SCOREQUARTER, 1) * 100 AS UNSIGNED)) AS BUCKET,
                                                    COUNT(*) AS CUST_COUNT
                                                FROM
                                                    custaudit.scorecard_display_salesplan
                                                WHERE
                                                    TOTR12SALES >= 500000
                                                GROUP BY bucket
                                                ORDER BY bucket;");
$result1->execute();



$rows = array();
$rows['name'] = 'Score';
$rows1 = array();
$rows1['name'] = 'Customer Count';


foreach ($result1 as $row) {
    $rows['data'][] = $row['BUCKET'];
    $rows1['data'][] = $row['CUST_COUNT'] * 1;
}


$result = array();
array_push($result, $rows);
array_push($result, $rows1);



print json_encode($result);

