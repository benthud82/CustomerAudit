
<?php

//$var_cust = $_GET['customer'];
include_once '../functions/customer_audit_functions.php';
include '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../connection/connection_details.php';


$var_cust = $_GET['salesplan'];

if (!isset($_GET['startfisc'])) {
    $startfisc = _rolling12startfiscal();
} else {
    $startfisc = $_GET['startfisc'];
    $startfisc = str_replace("-", "", $startfisc);
}

if (!isset($_GET['endfisc'])) {
    $endfisc = _currentmonthfiscal();
} else {
    $endfisc = $_GET['endfisc'];
    $endfisc = str_replace("-", "", $endfisc);
}
ini_set('max_execution_time', 99999);
set_time_limit(99999);

//find billto/shipto combinations in salesplan table
$billtoquery = $conn1->prepare("SELECT 
                                                                        group_SHIPTO
                                                                    FROM
                                                                        custaudit.scorecard_groupingdetail
                                                                    WHERE
                                                                        group_MASTERID = $var_cust;");
$billtoquery->execute();
$billtocolumns = $billtoquery->fetchAll(pdo::FETCH_COLUMN);
$billtoinclude = "('" . implode("','", $billtocolumns) . "')";

if (isset($_GET['reporttype'])) {
    $reporttype = $_GET['reporttype'];
} else {
    $reporttype = 'fillrate';  //change this back to fill rate after testing
}


switch ($reporttype) {
    case 'custreturns':
        //pull in invoice lines
        $result1 = $aseriesconn->prepare("SELECT substr(TR_DATE,1,6) as FiscMonth,  cast(count( IM0011.INV_PWHS) as float) as TotLines FROM A.HSIPCORDTA.IM0011 IM0011, A.HSIPCORDTA.IM0018 IM0018 WHERE IM0018.CUSTOMER = IM0011.CUSTOMER and im0018.CUSTOMER in $billtoinclude and substr(TR_DATE,1,6) >= '" . $startfisc . "' and substr(TR_DATE,1,6) <= '" . $endfisc . "' GROUP BY substr(TR_DATE,1,6) ORDER BY substr(TR_DATE,1,6) asc");
        $result1->execute();
        $invlinesarray = $result1->fetchAll(pdo::FETCH_ASSOC);

        //pull in customer returns by metric
        $result2 = $conn1->prepare("SELECT 
                                                                    CONCAT(YEAR(ORD_RETURNDATE),
                                                                            CASE
                                                                                WHEN MONTH(ORD_RETURNDATE) < 10 THEN CONCAT('0', MONTH(ORD_RETURNDATE))
                                                                                ELSE MONTH(ORD_RETURNDATE)
                                                                            END) AS FISCDATE,
                                                                    SUM(CASE
                                                                        WHEN RETURNCODE IN ('WQSP' , 'WISP', 'IBNS') THEN 1
                                                                        ELSE 0
                                                                    END) AS SUM_SHIPACC,
                                                                    SUM(CASE
                                                                        WHEN
                                                                            RETURNCODE IN ('WQTY' , 'WIOD',
                                                                                'TEMP',
                                                                                'SDAT',
                                                                                'EXPR',
                                                                                'NRSP',
                                                                                'LITR',
                                                                                'IBNO',
                                                                                'CNCL')
                                                                        THEN
                                                                            1
                                                                        ELSE 0
                                                                    END) AS SUM_ADDSC,
                                                                    SUM(CASE
                                                                        WHEN RETURNCODE IN ('TDNR' , 'CRID') THEN 1
                                                                        ELSE 0
                                                                    END) AS SUM_DAMAGE
                                                                FROM
                                                                    custaudit.custreturns
                                                                        JOIN
                                                                    custaudit.salesplan ON BILLTO = BILLTONUM
                                                                        AND SHIPTO = SHIPTONUM
                                                                WHERE
                                                                    SALESPLAN = '$var_cust'
                                                                        AND ORD_RETURNDATE >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
                                                                GROUP BY CONCAT(YEAR(ORD_RETURNDATE),
                                                                        '-',
                                                                        CASE
                                                                            WHEN MONTH(ORD_RETURNDATE) < 10 THEN CONCAT('0', MONTH(ORD_RETURNDATE))
                                                                            ELSE MONTH(ORD_RETURNDATE)
                                                                        END)
                                                                ORDER BY ORD_RETURNDATE;");
        $result2->execute();
        $returnsarray = $result2->fetchAll(pdo::FETCH_ASSOC);

        $rows = array();
        $rows['name'] = 'FiscMonth';
        $rows1 = array();
        $rows1['name'] = 'Fill Rate Before';
        $rows2 = array();
        $rows2['name'] = 'Fill Rate After';


        break;   //end of customer returns graph

    case 'fillrate':  //fill rate default
//find billto/shipto combinations in salesplan table

        $result1 = $aseriesconn->prepare("SELECT substr(TR_DATE,1,6) as FiscMonth,  count(case when IP_FIL_TYP = 'BO' then IM0011.INV_PWHS else NULL end) as BO,  count(case when IP_FIL_TYP = 'D' then IM0011.INV_PWHS else NULL end) as DS, count(case when IP_FIL_TYP = 'XD' then IM0011.INV_PWHS else NULL end) as XD,  count(case when IP_FIL_TYP in ('XE','XS') then IM0011.INV_PWHS else NULL end) as XEXS, cast(count( IM0011.INV_PWHS) as float) as TotLines FROM A.HSIPCORDTA.IM0011 IM0011, A.HSIPCORDTA.IM0018 IM0018 WHERE IM0018.CUSTOMER = IM0011.CUSTOMER and im0018.CUSTOMER in $billtoinclude and substr(TR_DATE,1,6) >= '" . $startfisc . "' and substr(TR_DATE,1,6) <= '" . $endfisc . "' GROUP BY substr(TR_DATE,1,6) ORDER BY substr(TR_DATE,1,6) asc");
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
            $rows['data'][] = substr($row['FISCMONTH'], 0, 4) . '-' . substr($row['FISCMONTH'], 4, 2);  //Push fiscal month-year to array
            $rows1['data'][] = (1 - (($row['XEXS'] + $row['XD'] + $row['BO']) / $row['TOTLINES'])) * 100;  //Before fill rate
            $rows2['data'][] = (1 - (($row['XD'] + $row['BO']) / $row['TOTLINES'])) * 100;  //After fill rate
        }

        $result = array();
        array_push($result, $rows);
        array_push($result, $rows1);
        array_push($result, $rows2);
        print json_encode($result);

        break;  //end of default fill rate report
}



