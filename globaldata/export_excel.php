<?php
// Include necessary libraries
require_once '../connection/connection_details.php';
include_once '../../globalfunctions/custdbfunctions.php';

// Get POST data
$data = json_decode($_POST['data'], true);
$type = $_POST['type'];
$filename = $_POST['filename']; // Already has .csv extension from JS

// Ensure the filename has .csv extension
if (substr($filename, -4) !== '.csv') {
    $filename = $filename . '.csv';
}

// Set headers for CSV download - setting these headers correctly is critical
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

// Create output stream
$output = fopen('php://output', 'w');

// Set title and subtitle
if ($type == 'billto') {
    $salesplan = $_POST['salesplan'];
    $title = "On-Time Performance Report for Sales Plan: $salesplan";
    $reportType = "Bill-To Level Summary";
} else {
    $billto = $_POST['billto'];
    $salesplan = $_POST['salesplan'];
    $title = "On-Time Performance Report for Bill-To: $billto";
    $reportType = "Ship-To Level Summary for Sales Plan: $salesplan";
}

// Output title and report info
fputcsv($output, [$title]);
fputcsv($output, [$reportType]);
fputcsv($output, ['Generated: ' . date('Y-m-d H:i:s')]);
fputcsv($output, []); // Empty line

// Set column headers
if ($type == 'billto') {
    $headers = [
        'Bill-To Customer Number',
        '# Packages',
        '# On Time',
        '# Late',
        'OTP',
        '# Late No Excuse',
        'Customer Experience'
    ];
} else {
    $headers = [
        'Ship-To Customer Number',
        '# Packages',
        '# On Time',
        '# Late',
        'OTP',
        '# Late No Excuse',
        'Customer Experience'
    ];
}

// Output headers
fputcsv($output, $headers);

// Calculate totals
$totalPackages = 0;
$totalOnTime = 0;
$totalLate = 0;

// Output data rows
foreach ($data as $item) {
    if ($type == 'billto') {
        $customerNumber = $item['BILLTO'];
    } else {
        $customerNumber = $item['SHIPTO'];
    }
    
    $packages = $item['shipCount'];
    $onTime = $item['ontimeCount'];
    $late = $item['lateCount'];
    $customerExperience = $item['customerExperience'];
    $otp = $customerExperience . '%'; // Same as customer experience
    
    // We don't have "Late No Excuse" so we'll set it to 0
    $lateNoExcuse = 0;
    
    // Add to totals
    $totalPackages += $packages;
    $totalOnTime += $onTime;
    $totalLate += $late;
    
    // Output row
    fputcsv($output, [
        $customerNumber,
        $packages,
        $onTime,
        $late,
        $otp,
        $lateNoExcuse,
        $customerExperience . '%'
    ]);
}

// Calculate overall percentages
$overallOtp = ($totalPackages > 0) ? round(($totalOnTime / $totalPackages) * 100, 2) : 0;

// Output totals row
fputcsv($output, [
    'Total',
    $totalPackages,
    $totalOnTime,
    $totalLate,
    $overallOtp . '%',
    0, // No Late No Excuse total
    $overallOtp . '%'
]);

// Close output stream
fclose($output);
exit;
?> 