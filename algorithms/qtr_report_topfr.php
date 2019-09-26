<?php

include_once '../connection/connection_details.php';

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
                                                                    OR_DATE >= 119250 AND item_flu IS NULL
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
    $inv_onorder = intval($array_to_pfr[$key]['inv_onorder']);

    if ($inv_onorder > 0) {
        
        //this is not working.  Need to set the date to 2199-01-01 instead of 0000-00-00 for all of the avg and max dates for teh urfdate_est table
        
        $sql_openpo = $conn1->prepare("SELECT 
                                                                            A.OPENSUPP,
                                                                            A.OPENWHSE,
                                                                            A.OPENITEM,
                                                                            A.OPENPONUM,
                                                                            A.PODATE,
                                                                            LEAST(CASE
                                                                                        WHEN A.AVGURFDATE = '0000-00-00' THEN '9999-99-99'
                                                                                        ELSE A.AVGURFDATE
                                                                                    END,
                                                                                    CASE
                                                                                        WHEN A.AVGEDIDATE = '0000-00-00' THEN '9999-99-99'
                                                                                        ELSE A.AVGEDIDATE
                                                                                    END) AS DATE_EXPECTED,
                                                                            LEAST(CASE
                                                                                        WHEN A.MAXURFDATE = '0000-00-00' THEN '9999-99-99'
                                                                                        ELSE A.MAXURFDATE
                                                                                    END,
                                                                                    CASE
                                                                                        WHEN A.MAXEDIDATE = '0000-00-00' THEN '9999-99-99'
                                                                                        ELSE A.MAXEDIDATE
                                                                                    END) AS DATE_LATEST,
                                                                            OPENPURQTY
                                                                        FROM
                                                                            custaudit.urfdate_est A
                                                                                JOIN
                                                                            custaudit.openpo B ON A.OPENPONUM = B.OPENPONUM
                                                                                AND B.OPENITEM = A.OPENITEM
                                                                        WHERE
                                                                            A.OPENITEM = $item AND A.OPENWHSE = $whse
                                                                            ORDER BY DATE_EXPECTED");
        $sql_openpo->execute();
        $array_openpo = $sql_openpo->fetchAll(pdo::FETCH_ASSOC);
    }
    print_r($array_openpo);
}