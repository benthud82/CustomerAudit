<?php

include_once '../connection/connection_details.php';
include_once '../../globalfunctions/custdbfunctions.php';

$salesplan = $_GET['salesplan'];
$showLateOnly = isset($_GET['late']) ? $_GET['late'] : 1; // Default to showing only late shipments

// Handle date parameters
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $startDate = $_GET['start_date'];
    $endDate = $_GET['end_date'];
    
    // Validate date range (max 90 days, not more than 2 years old)
    $today = new DateTime();
    $startDateObj = new DateTime($startDate);
    $endDateObj = new DateTime($endDate);
    $twoYearsAgo = new DateTime();
    $twoYearsAgo->modify('-2 years');
    
    // Calculate date difference
    $dateDiff = $endDateObj->diff($startDateObj)->days;
    
    // Validate and adjust if needed
    if ($dateDiff > 96 || $startDateObj < $twoYearsAgo) {
        // If invalid, default to last 90 days
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-90 days'));
    }
} else {
    // Default to last 90 days if not specified
    $endDate = date('Y-m-d');
    $startDate = date('Y-m-d', strtotime('-90 days'));
}

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
                            WHERE D.SALESPLAN = :salesplan 
                              AND DELIVERDATE BETWEEN :startDate AND :endDate
                              " . ($showLateOnly == 1 ? "AND LATE = 1" : ""));

$shiptosql->bindParam(':salesplan', $salesplan, PDO::PARAM_STR);
$shiptosql->bindParam(':startDate', $startDate, PDO::PARAM_STR);
$shiptosql->bindParam(':endDate', $endDate, PDO::PARAM_STR);
$shiptosql->execute();
$shiptoarray = $shiptosql->fetchAll(PDO::FETCH_ASSOC);

$output = array(
    "aaData" => array()
);

// Initialize the row array outside the loop
$rows = array();

foreach ($shiptoarray as $value) {
    $currentrow = array_values($value);
    
    // Handle UPS tracking number formatting
    $tracer = $value['TRACER'];
    if (!empty($tracer) && substr($tracer, 0, 2) === '1Z') {
        $tracerLink = '<a href="https://www.ups.com/track?tracknum=' . $tracer . '" target="_blank" style="color: #ff6600; font-weight: 500; padding: 2px 5px; border-radius: 3px; background-color: #f8f8f8; transition: all 0.2s ease; display: inline-block;">' . $tracer . ' <i class="fa fa-external-link" style="font-size: 0.8em;"></i></a>';
        // Find the index of the tracer in the currentrow array (should be 9 based on the SQL)
        $currentrow[9] = $tracerLink;
    }
    
    // Add the processed row to our rows array
    $rows[] = $currentrow;
}

// Set the processed rows to the output
$output['aaData'] = $rows;

// Return JSON response
header('Content-Type: application/json');
echo json_encode($output);
