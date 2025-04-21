<?php
include_once '../sessioninclude.php';
include_once '../connection/connection_details.php';

header('Content-Type: application/json');

try {
    $holiday_date = $_POST['holiday_date'];
    $holiday_desc = $_POST['holiday_desc'];
    
    // Convert to Eastern Time (America/New_York)
    $date = DateTime::createFromFormat('Y-m-d', $holiday_date, new DateTimeZone('America/New_York'));
    $holiday_date_eastern = $date ? $date->format('Y-m-d') : $holiday_date;
    
    // Validate input
    if (empty($holiday_date_eastern) || empty($holiday_desc)) {
        throw new Exception('Date and description are required');
    }
    
    // Check if date already exists
    $check_sql = "SELECT COUNT(*) as count FROM ups_holiday WHERE upsholiday_date = ?";
    $check_stmt = $conn1->prepare($check_sql);
    $check_stmt->execute([$holiday_date_eastern]);
    $exists = $check_stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
    
    if ($exists) {
        throw new Exception('A holiday for this date already exists');
    }
    
    // Insert new holiday
    $sql = "INSERT INTO ups_holiday (upsholiday_date, ups_holiday_desc) VALUES (?, ?)";
    $stmt = $conn1->prepare($sql);
    $stmt->execute([$holiday_date_eastern, $holiday_desc]);
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 