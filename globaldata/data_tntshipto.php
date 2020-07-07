
<?php

include_once '../connection/connection_details.php';
include_once '../../globalfunctions/custdbfunctions.php';

$salesplan = $_GET['salesplan'];
$mindate = date('Y-m-d', strtotime(' -90 days'));


$shiptosql = $conn1->prepare("SELECT 
                                                            D.BILLTO,
                                                            D.SHIPTO,
                                                            N.SHIPTONAME,
                                                            AVG(ACTUALDAYS) AS AVG_DAYS,
                                                            SUM(LATE) AS LATE_DEL,
                                                            COUNT(LATE) AS BOXES,
                                                            (COUNT(LATE) - SUM(LATE)) / COUNT(LATE) AS PERC_ONTIME,
                                                            ' '
                                                        FROM
                                                            custaudit.delivery_dates D
                                                                JOIN
                                                            custaudit.salesplan S ON D.BILLTO = S.BILLTO
                                                                AND D.SHIPTO = S.SHIPTO
                                                                JOIN
                                                            custaudit.scorecard_display_shipto N ON N.BILLTONUM = S.BILLTO
                                                                AND N.SHIPTONUM = S.SHIPTO
                                                        WHERE
                                                            S.SALESPLAN = '$salesplan'
                                                                and D.DELIVERDATE >= '$mindate'
                                                        GROUP BY D.BILLTO , D.SHIPTO
                                                        ORDER BY COUNT(LATE) DESC ");
$shiptosql->execute();
$shiptoarray = $shiptosql->fetchAll(pdo::FETCH_ASSOC);



$output = array(
    "aaData" => array()
);
$row = array();

foreach ($shiptoarray as $key => $value) {
    $shiptoarray[$key]['AVG_DAYS'] = number_format($shiptoarray[$key]['AVG_DAYS'], 2);
    $shiptoarray[$key]['PERC_ONTIME'] = (number_format($shiptoarray[$key]['PERC_ONTIME'] * 100, 2) ) . '%';
    $row[] = array_values($shiptoarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
