
<?php

include_once '../connection/connection_details.php';
include_once '../../globalfunctions/custdbfunctions.php';

$salesplan = $_GET['salesplan'];


$ordfreqsql = $conn1->prepare("SELECT 
                                                                O.BILLTONUM,
                                                                O.SHIPTONUM,
                                                                SHIPTONAME,
                                                                TOTAL_ORDERS_MNTH,
                                                                TOTAL_ORDERS_MNTH / 4.33 AS AVG_MNT,
                                                                TOTAL_ORDERS_QTR,
                                                                TOTAL_ORDERS_QTR / 13 AS AVG_QTR,
                                                                TOTAL_ORDERS_R12,
                                                                TOTAL_ORDERS_R12 / 52 AS AVG_R12,
                                                                (TOTAL_ORDERS_MNTH / 4.33) - (TOTAL_ORDERS_R12 / 52) AS COMP
                                                            FROM
                                                                custaudit.oscbyshipto O
                                                                    JOIN
                                                                custaudit.salesplan S ON BILLTO = O.BILLTONUM
                                                                    AND SHIPTO = SHIPTONUM
                                                                    JOIN
                                                                custaudit.scorecard_display_shipto D ON D.SHIPTONUM = O.SHIPTONUM
                                                                    AND D.BILLTONUM = O.BILLTONUM
                                                            WHERE
                                                                SALESPLAN = '$salesplan'
                                                            ORDER BY AVG_MNT DESC");
$ordfreqsql->execute();
$ordfreqarray = $ordfreqsql->fetchAll(pdo::FETCH_ASSOC);



$output = array(
    "aaData" => array()
);
$row = array();

foreach ($ordfreqarray as $key => $value) {
    $ordfreqarray[$key]['AVG_MNT'] = number_format($ordfreqarray[$key]['AVG_MNT'], 2);
    $ordfreqarray[$key]['AVG_QTR'] = number_format($ordfreqarray[$key]['AVG_QTR'], 2);
    $ordfreqarray[$key]['AVG_R12'] = number_format($ordfreqarray[$key]['AVG_R12'], 2);
    $ordfreqarray[$key]['COMP'] = number_format($ordfreqarray[$key]['COMP'], 2);
    
    $row[] = array_values($ordfreqarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
