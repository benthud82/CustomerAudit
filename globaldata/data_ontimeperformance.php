<?php

include_once '../connection/connection_details.php';
include_once '../../globalfunctions/custdbfunctions.php';

// Get salesplan from GET request
$salesplan = $_GET['salesplan'];

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

// Prepare the SQL query to get the summary data
$sql = $conn1->prepare("SELECT DISTINCT
                            D.SALESPLAN,
                            D.BILLTO,
                            COUNT(*) AS shipCount,
                            SUM(CASE WHEN D.LATE = 0 THEN 1 ELSE 0 END) AS ontimeCount,
                            SUM(CASE WHEN D.LATE = 1 THEN 1 ELSE 0 END) AS lateCount,
                            ROUND((SUM(CASE WHEN D.LATE = 0 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) AS customerExperience
                        FROM
                            custaudit.delivery_dates D
                        WHERE
                            D.SALESPLAN = :salesplan
                            AND D.DELIVERDATE BETWEEN :startDate AND :endDate
                        GROUP BY
                            D.SALESPLAN, D.BILLTO
                        ORDER BY
                            D.SALESPLAN, customerExperience DESC");

$sql->bindParam(':salesplan', $salesplan, PDO::PARAM_STR);
$sql->bindParam(':startDate', $startDate, PDO::PARAM_STR);
$sql->bindParam(':endDate', $endDate, PDO::PARAM_STR);
$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_ASSOC);

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($result);
?> 