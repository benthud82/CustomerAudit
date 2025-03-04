<?php

include_once '../connection/connection_details.php';
include_once '../../globalfunctions/custdbfunctions.php';

// Get salesplan from GET request
$salesplan = $_GET['salesplan'];
$mindate = date('Y-m-d', strtotime(' -90 days'));

// Prepare the SQL query to get the summary data
$sql = $conn1->prepare("SELECT DISTINCT
                            S.SALESPLAN,
                            D.BILLTO,
                            COUNT(*) AS shipCount,
                            SUM(CASE WHEN D.LATE = 0 THEN 1 ELSE 0 END) AS ontimeCount,
                            SUM(CASE WHEN D.LATE = 1 THEN 1 ELSE 0 END) AS lateCount,
                            ROUND((SUM(CASE WHEN D.LATE = 0 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) AS customerExperience
                        FROM
                            custaudit.delivery_dates D
                        INNER JOIN
                            custaudit.salesplan S ON D.BILLTO = S.BILLTO and D.SHIPTO = S.SHIPTO
                        WHERE
                            S.SALESPLAN = :salesplan
                            AND D.SHIPDATE >= :mindate
                        GROUP BY
                            S.SALESPLAN, D.BILLTO
                        ORDER BY
                            S.SALESPLAN, customerExperience DESC");

$sql->bindParam(':salesplan', $salesplan, PDO::PARAM_STR);
$sql->bindParam(':mindate', $mindate, PDO::PARAM_STR);
$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_ASSOC);

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($result);
?> 