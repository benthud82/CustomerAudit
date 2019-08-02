
<?php

//$var_cust = $_GET['customer'];
include_once '../functions/customer_audit_functions.php';
include '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../connection/connection_details.php';

function _arraykeysearch($array, $multikey, $matchvalue) {
    $resultarray = array();
    foreach ($array as $keyval => $value) {
        if ($array[$keyval][$multikey] == $matchvalue) {
            array_push($resultarray, $keyval);
            break;
        }
    }
    return $resultarray;
}

$var_cust = $_GET['salesplan'];
$var_custtype = $_GET['custtype'];

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



switch ($var_custtype) {
    case 'salesplan':
//find billto/shipto combinations in salesplan table
        $billtoquery = $conn1->prepare("SELECT DISTINCT BILLTO FROM custaudit.salesplan WHERE SALESPLAN like '$var_cust';");
        $billtoquery->execute();
        $billtocolumns = $billtoquery->fetchAll(pdo::FETCH_COLUMN);
        $billtoinclude = "('" . implode("','", $billtocolumns) . "')";

//pull in invoice lines
        $result1 = $aseriesconn->prepare("SELECT substr(TR_DATE,1,6) as FiscMonth,  cast(count( IM0011.INV_PWHS) as float) as TotLines FROM A.HSIPCORDTA.IM0011 IM0011, A.HSIPCORDTA.IM0018 IM0018 WHERE IM0018.CUSTOMER = IM0011.CUSTOMER and im0018.BILL_TO in $billtoinclude and substr(TR_DATE,1,6) >= '" . $startfisc . "' and substr(TR_DATE,1,6) <= '" . $endfisc . "' GROUP BY substr(TR_DATE,1,6) ORDER BY substr(TR_DATE,1,6) asc");
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
        $rows1['name'] = 'Shipping Accuracy';
        $rows2 = array();
        $rows2['name'] = 'Supply Chain Discrepancies';
        $rows3 = array();
        $rows3['name'] = 'Damages';


        //need to pull in all available dates
        $startmonth = date('Ym', strtotime(date('Y-m-d') . " -12 months"));
        $month[] = $startmonth;
        for ($i = 11; $i >= 0; $i--) {
            $month[] = date("Ym", strtotime(date('Y-m-d') . " -$i months"));
        }


        foreach ($month as $value) {
            $rows['data'][] = substr($value, 0, 4) . '-' . substr($value, 4, 2);  //Push fiscal month-year to array

            $resultkeyinvoice = _arraykeysearch($invlinesarray, 'FISCMONTH', $value);
             if (count($resultkeyinvoice) !== 0) {
                $invoicelines = intval($invlinesarray[$resultkeyinvoice[0]]['TOTLINES']);
            } else {
                $invoicelines = 0;
            }

            $resultkeyreturns = _arraykeysearch($returnsarray, 'FISCDATE', $value);
            if (count($resultkeyreturns) > 0) {
                $SHIPACC = intval($returnsarray[$resultkeyreturns[0]]['SUM_SHIPACC']);
                $ADDSC = intval($returnsarray[$resultkeyreturns[0]]['SUM_ADDSC']);
                $DAMAGE = intval($returnsarray[$resultkeyreturns[0]]['SUM_DAMAGE']);
            } else {
                $SHIPACC = 0;
                $ADDSC = 0;
                $DAMAGE = 0;
            }


            if ($invoicelines > 0) {
                $rows1['data'][] = (1 - (($SHIPACC) / $invoicelines)) * 100;  //Ship Acc
                $rows2['data'][] = (1 - (($ADDSC) / $invoicelines)) * 100;  //Ship Acc
                $rows3['data'][] = (1 - (($DAMAGE) / $invoicelines)) * 100;  //Ship Acc
            } else {
                $rows1['data'][] = 1 * 100;
                $rows2['data'][] = 1 * 100;
                $rows3['data'][] = 1 * 100;
            }
        }

        $result = array();
        array_push($result, $rows);
        array_push($result, $rows1);
        array_push($result, $rows2);
        array_push($result, $rows3);
        print json_encode($result);

        break;  //end of default fill rate report

    case 'billto':
        //pull in invoice lines
        $result1 = $aseriesconn->prepare("SELECT substr(TR_DATE,1,6) as FiscMonth,  cast(count( IM0011.INV_PWHS) as float) as TotLines FROM A.HSIPCORDTA.IM0011 IM0011, A.HSIPCORDTA.IM0018 IM0018 WHERE IM0018.CUSTOMER = IM0011.CUSTOMER and im0018.BILL_TO = $var_cust and substr(TR_DATE,1,6) >= '" . $startfisc . "' and substr(TR_DATE,1,6) <= '" . $endfisc . "' GROUP BY substr(TR_DATE,1,6) ORDER BY substr(TR_DATE,1,6) asc");
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
                                                                    BILLTONUM = $var_cust
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
        $rows1['name'] = 'Shipping Accuracy';
        $rows2 = array();
        $rows2['name'] = 'Supply Chain Discrepancies';
        $rows3 = array();
        $rows3['name'] = 'Damages';

        //need to pull in all available dates
        $startmonth = date('Ym', strtotime(date('Y-m-d') . " -12 months"));
        $month[] = $startmonth;
        for ($i = 11; $i >= 0; $i--) {
            $month[] = date("Ym", strtotime(date('Y-m-d') . " -$i months"));
        }


        foreach ($month as $value) {
            $rows['data'][] = substr($value, 0, 4) . '-' . substr($value, 4, 2);  //Push fiscal month-year to array

            $resultkeyinvoice = _arraykeysearch($invlinesarray, 'FISCMONTH', $value);
            if (count($resultkeyinvoice) !== 0) {
                $invoicelines = intval($invlinesarray[$resultkeyinvoice[0]]['TOTLINES']);
            } else {
                $invoicelines = 0;
            }

            $resultkeyreturns = _arraykeysearch($returnsarray, 'FISCDATE', $value);
            if (count($resultkeyreturns) > 0) {
                $SHIPACC = intval($returnsarray[$resultkeyreturns[0]]['SUM_SHIPACC']);
                $ADDSC = intval($returnsarray[$resultkeyreturns[0]]['SUM_ADDSC']);
                $DAMAGE = intval($returnsarray[$resultkeyreturns[0]]['SUM_DAMAGE']);
            } else {
                $SHIPACC = 0;
                $ADDSC = 0;
                $DAMAGE = 0;
            }


            if ($invoicelines > 0) {
                $rows1['data'][] = (1 - (($SHIPACC) / $invoicelines)) * 100;  //Ship Acc
                $rows2['data'][] = (1 - (($ADDSC) / $invoicelines)) * 100;  //Ship Acc
                $rows3['data'][] = (1 - (($DAMAGE) / $invoicelines)) * 100;  //Ship Acc
            } else {
                $rows1['data'][] = 1 * 100;
                $rows2['data'][] = 1 * 100;
                $rows3['data'][] = 1 * 100;
            }
        }

        $result = array();
        array_push($result, $rows);
        array_push($result, $rows1);
        array_push($result, $rows2);
        array_push($result, $rows3);
        print json_encode($result);
        break;

    case 'shipto':

//pull in invoice lines
        $result1 = $aseriesconn->prepare("SELECT substr(TR_DATE,1,6) as FiscMonth,  cast(count( IM0011.INV_PWHS) as float) as TotLines FROM A.HSIPCORDTA.IM0011 IM0011, A.HSIPCORDTA.IM0018 IM0018 WHERE IM0018.CUSTOMER = IM0011.CUSTOMER and im0018.CUSTOMER = $var_cust and substr(TR_DATE,1,6) >= '" . $startfisc . "' and substr(TR_DATE,1,6) <= '" . $endfisc . "' GROUP BY substr(TR_DATE,1,6) ORDER BY substr(TR_DATE,1,6) asc");
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
                                                                    SHIPTONUM = $var_cust
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
        $rows1['name'] = 'Shipping Accuracy';
        $rows2 = array();
        $rows2['name'] = 'Supply Chain Discrepancies';
        $rows3 = array();
        $rows3['name'] = 'Damages';

        //need to pull in all available dates
        $startmonth = date('Ym', strtotime(date('Y-m-d') . " -12 months"));
        $month[] = $startmonth;
        for ($i = 11; $i >= 0; $i--) {
            $month[] = date("Ym", strtotime(date('Y-m-d') . " -$i months"));
        }


        foreach ($month as $value) {
            $rows['data'][] = substr($value, 0, 4) . '-' . substr($value, 4, 2);  //Push fiscal month-year to array

            $resultkeyinvoice = _arraykeysearch($invlinesarray, 'FISCMONTH', $value);
            if ($resultkeyinvoice === true) {
                $invoicelines = intval($invlinesarray[$resultkeyinvoice[0]]['TOTLINES']);
            } else {
                $invoicelines = 0;
            }

            $resultkeyreturns = _arraykeysearch($returnsarray, 'FISCDATE', $value);
            if (count($resultkeyreturns) > 0) {
                $SHIPACC = intval($returnsarray[$resultkeyreturns[0]]['SUM_SHIPACC']);
                $ADDSC = intval($returnsarray[$resultkeyreturns[0]]['SUM_ADDSC']);
                $DAMAGE = intval($returnsarray[$resultkeyreturns[0]]['SUM_DAMAGE']);
            } else {
                $SHIPACC = 0;
                $ADDSC = 0;
                $DAMAGE = 0;
            }


            if ($invoicelines > 0) {
                $rows1['data'][] = (1 - (($SHIPACC) / $invoicelines)) * 100;  //Ship Acc
                $rows2['data'][] = (1 - (($ADDSC) / $invoicelines)) * 100;  //Ship Acc
                $rows3['data'][] = (1 - (($DAMAGE) / $invoicelines)) * 100;  //Ship Acc
            } else {
                $rows1['data'][] = 1 * 100;
                $rows2['data'][] = 1 * 100;
                $rows3['data'][] = 1 * 100;
            }
        }

        $result = array();
        array_push($result, $rows);
        array_push($result, $rows1);
        array_push($result, $rows2);
        array_push($result, $rows3);
        print json_encode($result);
        break;

    case 'custom':

        $billtoquery = $conn1->prepare("SELECT 
                                                                        group_SHIPTO
                                                                    FROM
                                                                        custaudit.scorecard_groupingdetail
                                                                    WHERE
                                                                        group_MASTERID = $var_cust;");
        $billtoquery->execute();
        $billtocolumns = $billtoquery->fetchAll(pdo::FETCH_COLUMN);
        $billtoinclude = "('" . implode("','", $billtocolumns) . "')";
        $billtoinclude2 = "(" . implode(",", $billtocolumns) . ")";

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
                                                                    SHIPTONUM in $billtoinclude2
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
        $rows1['name'] = 'Shipping Accuracy';
        $rows2 = array();
        $rows2['name'] = 'Supply Chain Discrepancies';
        $rows3 = array();
        $rows3['name'] = 'Damages';

        //need to pull in all available dates
        $startmonth = date('Ym', strtotime(date('Y-m-d') . " -12 months"));
        $month[] = $startmonth;
        for ($i = 11; $i >= 0; $i--) {
            $month[] = date("Ym", strtotime(date('Y-m-d') . " -$i months"));
        }


        foreach ($month as $value) {
            $rows['data'][] = substr($value, 0, 4) . '-' . substr($value, 4, 2);  //Push fiscal month-year to array

            $resultkeyinvoice = _arraykeysearch($invlinesarray, 'FISCMONTH', $value);
            if (count($resultkeyinvoice) !== 0) {
                $invoicelines = intval($invlinesarray[$resultkeyinvoice[0]]['TOTLINES']);
            } else {
                $invoicelines = 0;
            }

            $resultkeyreturns = _arraykeysearch($returnsarray, 'FISCDATE', $value);
            if (count($resultkeyreturns) > 0) {
                $SHIPACC = intval($returnsarray[$resultkeyreturns[0]]['SUM_SHIPACC']);
                $ADDSC = intval($returnsarray[$resultkeyreturns[0]]['SUM_ADDSC']);
                $DAMAGE = intval($returnsarray[$resultkeyreturns[0]]['SUM_DAMAGE']);
            } else {
                $SHIPACC = 0;
                $ADDSC = 0;
                $DAMAGE = 0;
            }


            if ($invoicelines > 0) {
                $rows1['data'][] = (1 - (($SHIPACC) / $invoicelines)) * 100;  //Ship Acc
                $rows2['data'][] = (1 - (($ADDSC) / $invoicelines)) * 100;  //Ship Acc
                $rows3['data'][] = (1 - (($DAMAGE) / $invoicelines)) * 100;  //Ship Acc
            } else {
                $rows1['data'][] = 1 * 100;
                $rows2['data'][] = 1 * 100;
                $rows3['data'][] = 1 * 100;
            }
        }

        $result = array();
        array_push($result, $rows);
        array_push($result, $rows1);
        array_push($result, $rows2);
        array_push($result, $rows3);
        print json_encode($result);
        break;
}



