<?php

ini_set('max_execution_time', 99999);

if (!function_exists('array_column')) {

    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if (!isset($value[$columnKey])) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            } else {
                if (!isset($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if (!is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }

}

include_once '../connection/connection_details.php';
include '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../functions/customer_audit_functions.php';


if (isset($_GET['salesplan'])) {
    $var_salesplan = ($_GET['salesplan']);
    $filter = " and A.BILL_TO in (SELECT DISTINCT PHAN8 FROM HSIPCORDTA.NOTWPY WHERE PHASN = '$var_salesplan') ";
} elseif (isset($_GET['billto'])) {
    $var_salesplan = ($_GET['billto']);
    $filter = " and A.BILL_TO = '$var_salesplan' ";
} elseif (isset($_GET['shipto'])) {
    $var_salesplan = ($_GET['shipto']);
    $filter = " and A.CUSTOMER = '$var_salesplan' ";
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
    $imp_cfr_include = "('" . implode("','", $array_cfr_incl) . "')";


    $filter = " and A.CUSTOMER in $imp_cfr_include ";
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

$fillratedata = $aseriesconn->prepare("SELECT DISTINCT 
                                            ' ',    
                                            A.ITEM, 
                                            B.IMDESC, 
                                            sum(case when A.IP_FIL_TYP = 'XD' then 1 else 0 end) as NSI,
                                            sum(case when A.IP_FIL_TYP = 'BO' then 1 else 0 end) as BO,
                                            sum(case when A.IP_FIL_TYP = 'XS' then 1 else 0 end) as STK_XS,
                                            sum(case when A.IP_FIL_TYP = 'XE' then 1 else 0 end) as NSI_XS,
                                             sum(case when A.IP_FIL_TYP = 'XD' then 1 else 0 end) +
                                            sum(case when A.IP_FIL_TYP = 'BO' then 1 else 0 end) +
                                            sum(case when A.IP_FIL_TYP = 'XS' then 1 else 0 end) +
                                            sum(case when A.IP_FIL_TYP = 'XE' then 1 else 0 end) as TOTAL,
                                            ' ' as RECENTAUDIT
                                            
                                            

                                            FROM HSIPCORDTA.IM0011 A

                                            JOIN HSIPCORDTA.NPFIMS B ON B.IMITEM = A.ITEM

                                            WHERE A.IP_FIL_TYP not in ('D', ' ') and A.OR_DATE >=  $var_rollmonthjdate and A.OR_DATE <=  $var_rollmonthenddate and A.IP_FIL_TYP <> ' ' $filter
                                            
                                            GROUP BY A.ITEM, B.IMDESC

                                            ORDER BY (sum(case when A.IP_FIL_TYP = 'XD' then 1 else 0 end) +
                                            sum(case when A.IP_FIL_TYP = 'BO' then 1 else 0 end) +
                                            sum(case when A.IP_FIL_TYP = 'XS' then 1 else 0 end) +
                                            sum(case when A.IP_FIL_TYP = 'XE' then 1 else 0 end))  DESC");
$fillratedata->execute();
$fillratedataarray = $fillratedata->fetchAll(pdo::FETCH_ASSOC);


//Deterime if item has been recently audited
//Pull all open and closed audits for past 30 days
$recentaudit = $conn1->prepare("SELECT 
                                    *
                                FROM
                                    custaudit.customeraction_asgntasks
                                        LEFT JOIN
                                    custaudit.customeraction_comptasks ON customeraction_comptasks_ASGNTSM = customeraction_asgntasks_ASGNTSM
                                        and customeraction_asgntasks_DATE = customeraction_comptasks_ASGNDATE
                                WHERE
                                    customeraction_asgntasks_DATE >= DATE_SUB(NOW(), INTERVAL 30 DAY) ;");
$recentaudit->execute();
$recentauditarray = $recentaudit->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($fillratedataarray as $key => $value) {
    $perfect_match_key = array_search(intval($fillratedataarray[$key]['ITEM']), array_column($recentauditarray, 'customeraction_asgntasks_ITEM'));
    if ($perfect_match_key !== FALSE) {
        $fillratedataarray[$key]['RECENTAUDIT'] = date('m/d/Y', strtotime($recentauditarray[$perfect_match_key]['customeraction_asgntasks_DATE']));
    }
    $row[] = array_values($fillratedataarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
