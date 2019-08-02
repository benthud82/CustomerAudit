
<?php

//$var_cust = $_GET['customer'];
include_once '../functions/customer_audit_functions.php';
include '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../connection/connection_details.php';


$var_cust = $_GET['billto'];

if ( !isset($_GET['startfisc']) ){
    $startfisc = _rolling12startfiscal();
}else{
    $startfisc = $_GET['startfisc'];
    $startfisc = str_replace("-", "", $startfisc);
}


if ( !isset($_GET['endfisc']) ){
    $endfisc = _currentmonthfiscal();
}else{
    $endfisc = $_GET['endfisc'];
    $endfisc = str_replace("-", "", $endfisc);
}


ini_set('max_execution_time', 99999);
set_time_limit(99999);

$result1 = $aseriesconn->prepare("SELECT substr(TR_DATE,1,6) as FiscMonth,  count(case when IP_FIL_TYP = 'BO' then IM0011.INV_PWHS else NULL end) as BO,  count(case when IP_FIL_TYP = 'D' then IM0011.INV_PWHS else NULL end) as DS, count(case when IP_FIL_TYP = 'XD' then IM0011.INV_PWHS else NULL end) as XD,  count(case when IP_FIL_TYP in ('XE','XS') then IM0011.INV_PWHS else NULL end) as XEXS, cast(count( IM0011.INV_PWHS) as float) as TotLines FROM A.HSIPCORDTA.IM0011 IM0011, A.HSIPCORDTA.IM0018 IM0018 WHERE IM0018.CUSTOMER = IM0011.CUSTOMER and im0018.BILL_TO = $var_cust and substr(TR_DATE,1,6) >= '" . $startfisc . "' and substr(TR_DATE,1,6) <= '" . $endfisc . "' GROUP BY substr(TR_DATE,1,6) ORDER BY substr(TR_DATE,1,6) asc");
$result1->execute();



$rows = array();
$rows['name'] = 'FiscMonth';
$rows1 = array();
$rows1['name'] = 'Fill Rate Before';
$rows2 = array();
$rows2['name'] = 'Fill Rate After';

//includes drop ships
//foreach ($result1 as $row) {
//    $rows['data'][] = substr($row['FISCMONTH'], 0,4) . '-' . substr($row['FISCMONTH'], 4,2);  //Push fiscal month-year to array
//    $rows1['data'][] = (1 - (($row['XEXS'] + $row['XD'] + $row['BO'] + $row['DS']) / $row['TOTLINES'])) * 100;  //Before fill rate
//    $rows2['data'][] = (1 - (($row['XD'] + $row['BO'] + $row['DS']) / $row['TOTLINES'])) * 100;  //After fill rate
//}

//excludes drop ships
foreach ($result1 as $row) {
    $rows['data'][] = substr($row['FISCMONTH'], 0,4) . '-' . substr($row['FISCMONTH'], 4,2);  //Push fiscal month-year to array
    $rows1['data'][] = (1 - (($row['XEXS'] + $row['XD'] + $row['BO']) / $row['TOTLINES'])) * 100;  //Before fill rate
    $rows2['data'][] = (1 - (($row['XD'] + $row['BO']) / $row['TOTLINES'])) * 100;  //After fill rate
}



$result = array();
array_push($result, $rows);
array_push($result, $rows1);
array_push($result, $rows2);


print json_encode($result);
