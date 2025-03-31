<?php
include_once '../sessioninclude.php';
include_once '../connection/connection_details.php';

header('Content-Type: application/json');

try {
    $holiday_date = $_POST['holiday_date'];
    
    // Validate input
    if (empty($holiday_date)) {
        throw new Exception('Date is required');
    }
    
    // Delete holiday
    $sql = "DELETE FROM ups_holiday WHERE upsholiday_date = ?";
    $stmt = $conn1->prepare($sql);
    $stmt->execute([$holiday_date]);
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('No holiday found for this date');
    }
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 