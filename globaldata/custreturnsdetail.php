
<?php

ini_set('max_execution_time', 99999);


include_once '../connection/connection_details.php';
//include '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../functions/customer_audit_functions.php';

if (isset($_GET['salesplan'])) {
    $var_salesplan = ($_GET['salesplan']);
    $salesplanfilter = " and S.SALESPLAN = '$var_salesplan' ";
    $itemcodefilter = ' ';
} else if (isset($_GET['billto'])) {
    $var_salesplan = ($_GET['billto']);
    $salesplanfilter = " and R.BILLTONUM = '$var_salesplan' ";
} else if (isset($_GET['shipto'])) {
    $var_salesplan = ($_GET['shipto']);
    $salesplanfilter = " and R.SHIPTONUM = '$var_salesplan' ";
} elseif (isset($_GET['customid'])) {
    $var_salesplan = ($_GET['customid']);


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


    $salesplanfilter = " and R.SHIPTONUM in $imp_cfr_include ";
}

if (!empty($_GET['itemcode'])) {
    $var_itemcode = ($_GET['itemcode']);
    $itemcodefilter = " and ITEMCODE = $var_itemcode ";
    $salesplanfilter = ' ';
} else {
    $itemcodefilter = ' ';
}

if (isset($_GET['startdate'])) {
    $startdate = $_GET['startdate'];
} else {
    $startdate = date('Y-m-d', strtotime('-90 days'));
}
if (isset($_GET['enddate'])) {
    $enddate = $_GET['enddate'];
} else {
    $enddate = date('Y-m-d');
}

$datediff = abs(strtotime($startdate) - strtotime($enddate));
$days = intval(floor($datediff / (60 * 60 * 24)));



$custreturnsdetaildata = $conn1->prepare("SELECT ' ',
                                            ITEMCODE,
                                        BILLTONUM,
                                        SHIPTONUM,
                                        WCSNUM,
                                        WONUM,
                                        JDENUM,
                                        SHIPDATEJ,
                                        R.RETURNCODE,
                                        ORD_RETURNDATE,
                                        METRIC,
                                        DESCRIPTION
                                    FROM
                                        custaudit.custreturns R
                                            JOIN
                                        custaudit.salesplan S ON R.BILLTONUM = S.BILLTO
                                            and R.SHIPTONUM = S.SHIPTO
                                            JOIN
                                        custaudit.custreturnmetrics M ON R.RETURNCODE = M.RETURNCODE
                                    WHERE ORD_RETURNDATE BETWEEN DATE_SUB(NOW(), INTERVAL $days DAY) AND NOW() $salesplanfilter $itemcodefilter;");
$custreturnsdetaildata->execute();
$custreturnsdetailarray = $custreturnsdetaildata->fetchAll(pdo::FETCH_ASSOC);



$output = array(
    "aaData" => array()
);
$row = array();

foreach ($custreturnsdetailarray as $key => $value) {
    $custreturnsdetailarray[$key]['SHIPDATEJ'] = _jdatetomysqldate($custreturnsdetailarray[$key]['SHIPDATEJ']);

    $row[] = array_values($custreturnsdetailarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
