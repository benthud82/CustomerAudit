<?php

If (!isset($conn1)) {
    include_once '../connection/connection_details.php';
    include_once '../functions/customer_audit_functions.php';
}

$rollqtrdate = date('Y-m-d', strtotime('-90 days'));
$rollqtrjdate = _gregdateto1yyddd($rollqtrdate);

//pull in top 10 fill rate hits
//excludes assumed mfg bo
//excludes flu items
//only currently stocking items

$sql_top_fr = $conn1->prepare("SELECT 
                                                                    INV_PWHS,
                                                                    ITEM,
                                                                    COUNT(*) AS CNT_DC,
                                                                    inv_onorder,
                                                                    inv_onhand,
                                                                    inv_boq,
                                                                    (SELECT 
                                                                            SUM(SMTH_SLS_MN)
                                                                        FROM
                                                                            slotting.mysql_nptsld
                                                                        WHERE
                                                                            WAREHOUSE = INV_PWHS
                                                                                AND ITEM_NUMBER = ITEM) AS AVG_DAILY_UNITS,
                                                                    (SELECT 
                                                                            SUM(PICK_QTY_SM)
                                                                        FROM
                                                                            slotting.mysql_nptsld
                                                                        WHERE
                                                                            WAREHOUSE = INV_PWHS
                                                                                AND ITEM_NUMBER = ITEM) AS AVG_DAILY_PICKS
                                                                FROM
                                                                    custaudit.im0011_frissues
                                                                        LEFT JOIN
                                                                    largecust.mfgbo ON mfgbo_item = ITEM
                                                                        LEFT JOIN
                                                                    largecust.flu ON item_flu = ITEM
                                                                        JOIN
                                                                    largecust.dcstats ON ITEM = dcstats_item
                                                                        AND dcstats_whse = SHIP_DC
                                                                        JOIN
                                                                    largecust.status_inv ON inv_whse = INV_PWHS AND inv_item = ITEM
                                                                WHERE
                                                                    OR_DATE >= $rollqtrjdate AND item_flu IS NULL
                                                                        AND mfgbo_item IS NULL
                                                                GROUP BY INV_PWHS , ITEM
                                                                ORDER BY CNT_DC DESC
                                                                LIMIT 10");
$sql_top_fr->execute();
$array_to_pfr = $sql_top_fr->fetchAll(pdo::FETCH_ASSOC);

//loop through array to determine when next expected shipments are coming in

foreach ($array_to_pfr as $key => $value) {
    $whse = $array_to_pfr[$key]['INV_PWHS'];
    $item = $array_to_pfr[$key]['ITEM'];

    $sql_openpo = $conn1->prepare("SELECT 
                                                                        A.OPENWHSE,
                                                                        A.OPENITEM,
                                                                        A.OPENPONUM,
                                                                        A.PODATE,
                                                                        LEAST(A.AVGURFDATE, A.AVGEDIDATE) AS DATE_EXPECTED,
                                                                        LEAST(A.MAXURFDATE, A.MAXEDIDATE) AS DATE_LATEST,
                                                                        OPENPURQTY
                                                                    FROM
                                                                        custaudit.urfdate_est A
                                                                            JOIN
                                                                        custaudit.openpo B ON A.OPENPONUM = B.OPENPONUM
                                                                            AND B.OPENITEM = A.OPENITEM
                                                                    WHERE
                                                                        A.OPENITEM = $item AND A.OPENWHSE = $whse
                                                                    HAVING DATE_EXPECTED > '2018-01-01'
                                                                        AND DATE_LATEST > '2018-01-01'
                                                                    ORDER BY DATE_EXPECTED");
    $sql_openpo->execute();
    $array_openpo = $sql_openpo->fetchAll(pdo::FETCH_ASSOC);

    if (!empty($array_openpo)) {
        $openpocount = count($array_openpo);
        $array_to_pfr[$key]['PO_OPEN'] = $openpocount;
        $array_to_pfr[$key]['DATE_EXPECTED'] = $array_openpo[0]['DATE_EXPECTED'];
        $array_to_pfr[$key]['DATE_LATEST'] = $array_openpo[0]['DATE_LATEST'];
        $array_to_pfr[$key]['OPENPURQTY'] = $array_openpo[0]['OPENPURQTY'];
    } else {
        //apend no open po data to fill rate array
        $array_to_pfr[$key]['PO_OPEN'] = 0;
        $array_to_pfr[$key]['DATE_EXPECTED'] = 'NA';
        $array_to_pfr[$key]['DATE_LATEST'] = 'NA';
        $array_to_pfr[$key]['OPENPURQTY'] = 0;
    }
    //pull in variables for analysis
    $CNT_DC = $array_to_pfr[$key]['CNT_DC'];
    $inv_onorder = $array_to_pfr[$key]['inv_onorder'];
    $inv_onhand = $array_to_pfr[$key]['inv_onhand'];
    $inv_boq = $array_to_pfr[$key]['inv_boq'];
    $AVG_DAILY_UNITS = $array_to_pfr[$key]['AVG_DAILY_UNITS'];
    $AVG_DAILY_PICKS = $array_to_pfr[$key]['AVG_DAILY_PICKS'];

    //is item still at risk?
    $array_atrisk = _atrisk($CNT_DC, $inv_onorder, $inv_onhand, $inv_boq, $AVG_DAILY_UNITS, $AVG_DAILY_PICKS);
    if ($array_atrisk == 0) {
        print_r($array_to_pfr[$key]);
        echo '<br>';
        echo '<br>';
    }
}

