
<?php
ini_set('max_execution_time', 99999);


include_once '../connection/connection_details.php';
session_write_close();
include_once '../functions/customer_audit_functions.php';
include_once '../../MySQLUpdates/globalfunctions.php';

if (isset($_GET['salesplan'])) {
    $var_salesplan = ($_GET['salesplan']);
    $salesplanfilter = " and S.SALESPLAN = '$var_salesplan' ";
    $itemcodefilter = ' ';
}else if(isset($_GET['billto'])) {
    $var_salesplan = ($_GET['billto']);
    $salesplanfilter = " and R.BILLTONUM = '$var_salesplan' ";
}else if(isset($_GET['shipto'])) {
    $var_salesplan = ($_GET['shipto']);
    $salesplanfilter = " and R.SHIPTONUM = '$var_salesplan' ";
}

if (!empty($_GET['itemcode'])) {
    $var_itemcode = ($_GET['itemcode']);
    $itemcodefilter = " and ITEMCODE = $var_itemcode ";
    $salesplanfilter = ' ';
}else{
    $itemcodefilter = ' ';
}

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
                                    WHERE ORD_RETURNDATE BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW() $salesplanfilter $itemcodefilter;");
$custreturnsdetaildata->execute();
$custreturnsdetailarray = $custreturnsdetaildata->fetchAll(pdo::FETCH_ASSOC);



$output = array(
    "aaData" => array()
);
$row = array();

foreach ($custreturnsdetailarray as $key => $value) {
    $custreturnsdetailarray[$key]['SHIPDATEJ'] = _jdatetomysqldate( $custreturnsdetailarray[$key]['SHIPDATEJ']);

    $row[] = array_values($custreturnsdetailarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
