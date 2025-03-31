<?php
include_once '../sessioninclude.php';
include_once '../connection/connection_details.php';

header('Content-Type: application/json');

try {
    $sql = "SELECT * FROM ups_holiday ORDER BY upsholiday_date DESC";
    $stmt = $conn1->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($result);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?> 