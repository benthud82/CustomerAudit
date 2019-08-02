
<?php

include '../../globalincludes/usa_asys_session.php';
session_write_close();
include '../../globalfunctions/custdbfunctions.php';
include '../../globalincludes/nahsi_mysql.php';  //production connection
//include '../../globalincludes/ustxgpslotting_mysql.php';  //modelling connection

if (isset($_GET['salesplan'])) {
    $var_cust = $_GET['salesplan'];
    $var_numtype = 'salesplan';
} else if (isset($_GET['billto'])) {
    $var_cust = $_GET['billto'];
    $var_numtype = 'billto';
}else if (isset($_GET['shipto'])) {
    $var_cust = $_GET['shipto'];
    $var_numtype = 'shipto';
}

$startdate = _rollmonth1yyddd();  //call current month function to find start for for current month for sql


switch ($var_numtype) {
    case 'billto':
        $result1 = $conn1->prepare("SELECT * FROM custaudit.ordershipcomplete WHERE BILLTONUM = $var_cust and ORDDATE >= $startdate");
        $result1->execute();
        $result1array = $result1->fetchAll(pdo::FETCH_ASSOC);
        break;
    case 'salesplan':
        $result1 = $conn1->prepare("SELECT 
                                        *
                                    FROM
                                        custaudit.ordershipcomplete A
                                            join
                                        custaudit.salesplan B ON A.BILLTONUM = B.BILLTO
                                            and A.SHIPTONUM = B.SHIPTO
                                    WHERE
                                        SALESPLAN = '$var_cust'
                                            and ORDDATE >= $startdate");
        $result1->execute();
        $result1array = $result1->fetchAll(pdo::FETCH_ASSOC);
        break;
    case 'shipto':
        $result1 = $conn1->prepare("SELECT * FROM custaudit.ordershipcomplete WHERE SHIPTONUM = $var_cust and ORDDATE >= $startdate");
        $result1->execute();
        $result1array = $result1->fetchAll(pdo::FETCH_ASSOC);
        break;

    default:
        break;
}

$output = array(
    "aaData" => array()
);
$row = array();

foreach ($result1array as $key => $value) {
    $row[] = array_values($result1array[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
