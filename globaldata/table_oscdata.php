
<?php

include_once '../connection/connection_details.php';
//include '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../functions/customer_audit_functions.php';


if (isset($_GET['salesplan'])) {
    $var_cust = $_GET['salesplan'];
    $var_numtype = 'salesplan';
} else if (isset($_GET['billto'])) {
    $var_cust = $_GET['billto'];
    $var_numtype = 'billto';
} else if (isset($_GET['shipto'])) {
    $var_cust = $_GET['shipto'];
    $var_numtype = 'shipto';
} elseif (isset($_GET['customid'])) {
    $var_salesplan = ($_GET['customid']);
    $var_numtype = 'custom';

    $sql_cfr_incl = "SELECT 
                                    group_SHIPTO
                                FROM
                                    custaudit.scorecard_groupingdetail
                                WHERE
                                    group_MASTERID = $var_salesplan;";
    $query_cfr_incl = $conn1->prepare($sql_cfr_incl);
    $query_cfr_incl->execute();
    $array_cfr_incl = $query_cfr_incl->fetchAll(pdo::FETCH_COLUMN);
    $array_cfr_incl_data = array();
    $counter = 0;
    $imp_cfr_include = "(" . implode(",", $array_cfr_incl) . ")";
}

$startdate = $_GET['startdate'];

if ($startdate > 0) {
    $var_rollmonthjdate = _gregdateto1yyddd($startdate);
} else {
    $var_rollmonthjdate = _rollmonth1yyddd();  //default
}

$enddate = $_GET['enddate'];
if ($enddate > 0) {
    $var_rollmonthenddate = _gregdateto1yyddd($enddate);
} else {
    $today = date("m/d/Y");
    $var_rollmonthenddate = _gregdateto1yyddd($today);  //default
}



switch ($var_numtype) {
    case 'billto':
        $result1 = $conn1->prepare("SELECT * FROM custaudit.ordershipcomplete WHERE BILLTONUM = $var_cust and ORDDATE >= $var_rollmonthjdate and ORDDATE <= $var_rollmonthenddate");
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
                                            and ORDDATE >= $var_rollmonthjdate  and ORDDATE <= $var_rollmonthenddate");
        $result1->execute();
        $result1array = $result1->fetchAll(pdo::FETCH_ASSOC);
        break;
    case 'shipto':
        $result1 = $conn1->prepare("SELECT * FROM custaudit.ordershipcomplete WHERE SHIPTONUM = $var_cust and ORDDATE >= $var_rollmonthjdate  and ORDDATE <= $var_rollmonthenddate");
        $result1->execute();
        $result1array = $result1->fetchAll(pdo::FETCH_ASSOC);
        break;
    case 'custom':
        $result1 = $conn1->prepare("SELECT * FROM custaudit.ordershipcomplete WHERE SHIPTONUM in $imp_cfr_include and ORDDATE >= $var_rollmonthjdate  and ORDDATE <= $var_rollmonthenddate");
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
    $result1array[$key]['ORDDATE'] = _1yydddtogregdate($result1array[$key]['ORDDATE']);
    $row[] = array_values($result1array[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
