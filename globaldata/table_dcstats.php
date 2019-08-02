<?php

ini_set('max_execution_time', 99999);

include_once '../connection/connection_details.php';
include '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../functions/customer_audit_functions.php';

$var_rollmonthjdate = _rollmonth1yyddd();
$var_rollqtrjdate = _rollquarter1yyddd();
$var_rollr12jdate = _rolling12start1yyddd();

$var_itemcode = ($_GET['itemcode']);


$dcstats = $aseriesconn->prepare("SELECT DISTINCT ORD_PWHS,
                                    
                                    sum(case when A.IP_FIL_TYP = 'XD' then 1 else 0 end) as XD ,
                                    sum(case when A.IP_FIL_TYP = 'BO' then 1 else 0 end) as BO ,
                                    sum(case when A.IP_FIL_TYP = 'XS' then 1 else 0 end) as XS ,
                                    sum(case when A.IP_FIL_TYP = 'XE' then 1 else 0 end) as XE,
                                    sum(case when A.IP_FIL_TYP = 'XD' then 1 else 0 end) +
                                    sum(case when A.IP_FIL_TYP = 'BO' then 1 else 0 end) +
                                    sum(case when A.IP_FIL_TYP = 'XS' then 1 else 0 end) +
                                    sum(case when A.IP_FIL_TYP = 'XE' then 1 else 0 end) as TOTAL_FR,
                                    sum(case when A.IP_FIL_TYP = 'XD' then 1 else 1 end) as TOTAL_LINES,
                                    DECIMAL(100-(((sum(case when A.IP_FIL_TYP = 'XD' then 1 else 0 end) +
                                    sum(case when A.IP_FIL_TYP = 'BO' then 1 else 0 end) +
                                    sum(case when A.IP_FIL_TYP = 'XS' then 1 else 0 end) +
                                    sum(case when A.IP_FIL_TYP = 'XE' then 1 else 0 end)) / DECIMAL(sum(case when A.IP_FIL_TYP = 'XD' then 1 else 1 end),10,4)) * 100),5,2) || '%'

                                    FROM HSIPCORDTA.IM0011 A

                                    WHERE A.OR_DATE >=  $var_rollmonthjdate and ITEM = '$var_itemcode' and ORD_PWHS in (2,3,6,7,9)

                                    GROUP BY ORD_PWHS

                                    ORDER BY ORD_PWHS asc");
$dcstats->execute();
$dcstatsarray = $dcstats->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($dcstatsarray as $key => $value) {
    $row[] = array_values($dcstatsarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
