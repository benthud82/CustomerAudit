<?php

include_once '../connection/connection_details.php';
include_once '../../globalfunctions/custdbfunctions.php';

$salesplan = $_GET['salesplan'];
$mindate = date('Y-m-d', strtotime(' -90 days'));
$showLateOnly = isset($_GET['late']) ? $_GET['late'] : 1; // Default to showing only late shipments

$shiptosql = $conn1->prepare("SELECT 
                                D.SALESPLAN,
                                D.BILLTO,
                                D.SHIPTO,
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
                            WHERE D.SALESPLAN = '$salesplan' 
                              AND DELIVERDATE >= '$mindate'
                              " . ($showLateOnly == 1 ? "AND LATE = 1" : "") . "");
$shiptosql->execute();
$shiptoarray = $shiptosql->fetchAll(pdo::FETCH_ASSOC);



$output = array(
    "aaData" => array()
);
$row = array();

foreach ($shiptoarray as $key => $value) {
    $currentrow = array_values($value);
    
    $tracer = $value['TRACER'];
    
    // Detect UPS tracking numbers by their format (starting with 1Z)
    if (!empty($tracer) && substr($tracer, 0, 2) === '1Z') {
        // Create a styled clickable link for UPS tracer numbers
        $tracerLink = '<a href="https://www.ups.com/track?tracknum=' . $tracer . '" target="_blank" style="color: #ff6600; font-weight: 500; padding: 2px 5px; border-radius: 3px; background-color: #f8f8f8; transition: all 0.2s ease; display: inline-block;">' . $tracer . ' <i class="fa fa-external-link" style="font-size: 0.8em;"></i></a>';
        $currentrow[9] = $tracerLink; // Replace the tracer number with the link
    }
    
    $row[] = $currentrow;
}


$output['aaData'] = $row;
echo json_encode($output);
