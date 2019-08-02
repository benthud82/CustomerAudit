
<?php

include_once '../connection/connection_details.php';
include_once '../../globalfunctions/custdbfunctions.php';

$salesplan = $_GET['salesplan'];
$mindate = date('Y-m-d', strtotime(' -90 days'));


$shiptosql = $conn1->prepare("SELECT 
                                S.SALESPLAN,
                                D.BILLTO,
                                D.SHIPTO,
                                X.SHIPTONAME,
                                WHSE,
                                WCSNUM,
                                WONUM,
                                BOXNUM,
                                BOXSIZE,
                                SHIPZONE,
                                TRACER,
                                concat(SHIPDATE,' ',SHIPTIME) as SHIPDATE,
                                concat(DELIVERDATE,' ',DELIVERTIME) as DELIVERDATE,
                                CARRIER,
                                CAST(SHOULDDAYS as UNSIGNED) as SHOULDDAYS,
                                CAST(ACTUALDAYS as UNSIGNED) as ACTUALDAYS,
                                case when LATE = 1 then 'YES' else 'NO' end as LATE
                            FROM
                                custaudit.delivery_dates D
                                    JOIN
                                custaudit.salesplan S ON S.BILLTO = D.BILLTO
                                    AND S.SHIPTO = D.SHIPTO
                                    JOIN
                                custaudit.scorecard_display_shipto X ON X.BILLTONUM = D.BILLTO
                                    AND X.SHIPTONUM = D.SHIPTO
                              WHERE S.SALESPLAN = '$salesplan' and DELIVERDATE >= '$mindate'");
$shiptosql->execute();
$shiptoarray = $shiptosql->fetchAll(pdo::FETCH_ASSOC);



$output = array(
    "aaData" => array()
);
$row = array();

foreach ($shiptoarray as $key => $value) {
    $row[] = array_values($shiptoarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
