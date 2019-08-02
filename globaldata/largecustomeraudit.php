<?php

ini_set('max_execution_time', 99999);

include_once '../connection/connection_details.php';

$var_includeaudit = intval($_GET['includeaudit']);
$var_allsalesplans = intval($_GET['allsalesplans']);

if ($var_includeaudit == 0) {
    $var_include = "(SELECT DISTINCT
                        auditcomplete_custid
                    FROM
                        custaudit.auditcomplete
                    WHERE
                        auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY))";
} else {
    $var_include = "  (' ')";
}


if ($var_allsalesplans == 0) {
    $var_salesplans = ' and A.TOTR12SALES > 500000';
} else {
    $var_salesplans =' ';
}





$customerdata = $conn1->prepare("SELECT 
                                    A.SALESPLAN,
                                    FORMAT(A.TOTMONTHLINES,0),
                                    CONCAT('$',FORMAT(A.TOTMONTHSALES,0)),
                                    FORMAT(A.TOTR12LINES,0),
                                    CONCAT('$',FORMAT(A.TOTR12SALES,0)),
                                    CONCAT(CAST(A.BEFFRMNT * 100 as DECIMAL (5,2)),'%'),
                                    CONCAT(CAST(A.BEFFRR12 * 100 as DECIMAL (5,2)),'%'),
                                    CONCAT(CAST(A.AFTFRMNT * 100 as DECIMAL (5,2)),'%'),
                                    CONCAT(CAST(A.AFTFRR12 * 100 as DECIMAL (5,2)),'%'),
                                    FORMAT(A.CUSTSCOREMNT_EXCLDS * 100,0),
                                    B.SLOPE30DAY,
                                    FORMAT(A.CUSTSCOREQTR_EXCLDS * 100,0),
                                    B.SLOPE90DAY,
                                    FORMAT(A.CUSTSCORER12_EXCLDS * 100,0),
                                    B.SLOPE12MON,
                                    B.BOMONTH,
                                    B.SLOPEBO30DAY,
                                    B.BOQUARTER,
                                    B.SLOPEBO90DAY,
                                    XSMONTH,
                                    SLOPEXS30DAY,
                                    XSQUARTER,
                                    SLOPEXS90DAY,
                                    XEMONTH,
                                    SLOPEXE30DAY,
                                    XEQUARTER,
                                    SLOPEXE90DAY,
                                    XDMONTH,
                                    SLOPEXD30DAY,
                                    XDQUARTER,
                                    SLOPEXD90DAY,
                                    SHIPACCMONTH,
                                    SLOPESHIPACCMONTH,
                                    SHIPACCQUARTER,
                                    SLOPESHIPACCQUARTER,
                                    DMGACCMONTH,
                                    SLOPEDMGACCMONTH,
                                    DMGACCQUARTER,
                                    SLOPEDMGACCQUARTER,
                                    ADDSCACCMONTH,
                                    SLOPEADDSCACCMONTH,
                                    ADDSCACCQUARTER,
                                    SLOPEADDSCACCQUARTER,
                                    OSCMONTH,
                                    SLOPEOSCMONTH,
                                    OSCQUARTER,
                                    SLOPEOSCQUARTER
                                FROM
                                    custaudit.customerscores_salesplan A
                                        join
                                    custaudit.scorecard_display_salesplan B ON B.SALESPLAN = A.SALESPLAN
                                WHERE
                                    A.SALESPLAN not in $var_include and A.SALESPLAN not in ('SMSTR','CDH01', 'THS13', ' ') $var_salesplans
                                ORDER BY SLOPE30DAY ASC;");
$customerdata->execute();
$customerdataarray = $customerdata->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($customerdataarray as $key => $value) {
    $row[] = array_values($customerdataarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
