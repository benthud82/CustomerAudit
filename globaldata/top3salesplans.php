<?php
include_once 'connection/connection_details.php';
include '../globalincludes/usa_asys_session.php';
//include_once '../globalfunctions/custdbfunctions.php';
//top 3 salesplans score history increase/decrease

$startfisc = _rolling12startfiscal();
$endfisc = _currentmonthfiscal();
$top3_sql = $conn1->prepare("SELECT DISTINCT
                                S.SALESPLAN,
                                SPDESC_DESC,
                                CAST(AVG(S.SCOREMONTH_EXCLDS) * 100 AS UNSIGNED) AS HISTSCORE,
                                CAST((SELECT 
                                            X.SCOREMONTH_EXCLDS
                                        FROM
                                            custaudit.custscoresbyday_salesplan X
                                        WHERE
                                            X.SALESPLAN = S.SALESPLAN
                                        ORDER BY X.RECORDDATE DESC
                                        LIMIT 1) * 100
                                    AS UNSIGNED) AS CURRSCORE
                            FROM
                                custaudit.custscoresbyday_salesplan S
                                    JOIN
                                custaudit.qtrreport_top3 ON top3_salesplan = SALESPLAN
                                    JOIN
                                custaudit.salesplan_desc ON S.SALESPLAN = SPDESC_SALESPLAN
                            WHERE
                                S.RECORDDATE BETWEEN DATE_SUB(NOW(), INTERVAL 93 DAY) AND DATE_SUB(NOW(), INTERVAL 87 DAY)
                            GROUP BY S.SALESPLAN , SPDESC_DESC
                            ORDER BY S.SALESPLAN asc");
$top3_sql->execute();
$top3_array = $top3_sql->fetchAll(pdo::FETCH_ASSOC);

//top3 drivers of score increase/decrease
$driver_sql = $conn1->prepare("SELECT 
                                SALESPLAN,
                                SLOPE90DAY_EXCLDS,
                                SLOPEBO90DAY,
                                SLOPEXD90DAY,
                                SLOPEXE90DAY,
                                SLOPEXS90DAY,
                                SLOPEBEFFRQTR,
                                SLOPEAFTFRQTR,
                                SLOPEOSCQUARTER
                            FROM
                                custaudit.custscoresbyday_salesplan
                                    JOIN
                                custaudit.qtrreport_top3 ON top3_salesplan = SALESPLAN
                            WHERE
                                RECORDDATE = (SELECT 
                                        MAX(RECORDDATE)
                                    FROM
                                        custaudit.custscoresbyday_salesplan)
                            ORDER BY SALESPLAN asc");
$driver_sql->execute();
$driver_array = $driver_sql->fetchAll(pdo::FETCH_ASSOC);

$driverlookuparray = array();


//What is driver
foreach ($driver_array as $driverkey => $value) {
    $driver_sp = $driver_array[$driverkey]['SALESPLAN'];
    $driverlookuparray[$driverkey]['SALESPLAN'] = $driver_sp;
    $driver_slope = $driver_array[$driverkey]['SLOPE90DAY_EXCLDS'];





    if ($driver_slope < 0) {
//if score has decreased, find min value to determine driver of lower score
        $SLOPEBO90DAY = $driver_array[$driverkey]['SLOPEBO90DAY'];
        $SLOPEXD90DAY = $driver_array[$driverkey]['SLOPEXD90DAY'];
        $SLOPEXE90DAY = $driver_array[$driverkey]['SLOPEXE90DAY'];
        $SLOPEXS90DAY = $driver_array[$driverkey]['SLOPEXS90DAY'];
        $SLOPEOSCQUARTER = $driver_array[$driverkey]['SLOPEOSCQUARTER'];
        $minval = min($SLOPEBO90DAY, $SLOPEXD90DAY, $SLOPEXE90DAY, $SLOPEXS90DAY, $SLOPEOSCQUARTER);
        $driverlookuparray[$driverkey]['VAL'] = $minval;
        switch ($minval) {
            case $SLOPEBO90DAY:
                $driverlookuparray[$driverkey]['STMT'] = 'Main driver was increase in items on backorder.';
                break;
            case $SLOPEXD90DAY:
                $driverlookuparray[$driverkey]['STMT'] = 'Main driver was increase in NSI item orders.';
                break;
            case $SLOPEXE90DAY:
                $driverlookuparray[$driverkey]['STMT'] = 'Main driver was increase in non-stock cross-ships.';
                break;
            case $SLOPEXS90DAY:
                $driverlookuparray[$driverkey]['STMT'] = 'Main driver was increase in stocking cross-ships.';
                break;
            case $SLOPEOSCQUARTER:
                $driverlookuparray[$driverkey]['STMT'] = 'Main driver was decrease in order shipped complete.';
                break;

            default:
                break;
        }
    } elseif ($driver_slope > 0) {
        //if score has increased, find max value to determine driver of lower score
        $SLOPEBO90DAY = $driver_array[$driverkey]['SLOPEBO90DAY'];
        $SLOPEXD90DAY = $driver_array[$driverkey]['SLOPEXD90DAY'];
        $SLOPEXE90DAY = $driver_array[$driverkey]['SLOPEXE90DAY'];
        $SLOPEXS90DAY = $driver_array[$driverkey]['SLOPEXS90DAY'];
        $SLOPEOSCQUARTER = $driver_array[$driverkey]['SLOPEOSCQUARTER'];
        $maxval = max($SLOPEBO90DAY, $SLOPEXD90DAY, $SLOPEXE90DAY, $SLOPEXS90DAY, $SLOPEOSCQUARTER);
        $driverlookuparray[$driverkey]['VAL'] = $maxval;
        switch ($maxval) {
            case $SLOPEBO90DAY:
                $driverlookuparray[$driverkey]['STMT'] = 'Main driver was decrease in items on backorder.';
                break;
            case $SLOPEXD90DAY:
                $driverlookuparray[$driverkey]['STMT'] = 'Main driver was decrease in NSI item orders.';
                break;
            case $SLOPEXE90DAY:
                $driverlookuparray[$driverkey]['STMT'] = 'Main driver was decrease in non-stock cross-ships.';
                break;
            case $SLOPEXS90DAY:
                $driverlookuparray[$driverkey]['STMT'] = 'Main driver was decrease in stocking cross-ships.';
                break;
            case $SLOPEOSCQUARTER:
                $driverlookuparray[$driverkey]['STMT'] = 'Main driver was increase in order shipped complete.';
                break;

            default:
                break;
        }
    } else {
        $driverlookuparray[$driverkey]['VAL'] = '0.0';
        $driverlookuparray[$driverkey]['STMT'] = 'Score was stagnant';
    }
}

foreach ($top3_array as $key => $value) {
    ?>
    <div class="col-xs-6" style="">
        <!--<div class="row" style="margin-left: 50px;">-->
        <?php
        $driver_stmt = '';
        $salesplan = $top3_array[$key]['SALESPLAN'];
        $salesplan_desc = $top3_array[$key]['SPDESC_DESC'];
        $currscore = $top3_array[$key]['CURRSCORE'];
        $histscore = $top3_array[$key]['HISTSCORE'];
        if ($currscore < $histscore) {
            $headerclass = 'danger';
        } else {
            $headerclass = 'success';
        }
        //pull in driver data
        foreach ($driverlookuparray as $driverkey => $value) {
            $driver_salesplan = $driverlookuparray[$driverkey]['SALESPLAN'];
            if ($salesplan == $driver_salesplan) {
                $driver_stmt = $driverlookuparray[$driverkey]['STMT'];
            }
        }

        if ($currscore > $histscore) {
            $scoredif = $currscore - $histscore;
            $statement = " <strong> increased </strong> by $scoredif points to $currscore this quarter from $histscore last quarter.";
        } elseif ($currscore < $histscore) {
            $scoredif = $histscore - $currscore;
            $statement = "<strong> decreased </strong> by  $scoredif points to $currscore this quarter from $histscore last quarter.";
        } else {
            $statement = " was <strong> stagnant </strong> at a score of $currscore for both last quarter and this quarter.";
        }

        //find billto/shipto combinations in salesplan table
        $billtoquery = $conn1->prepare("SELECT DISTINCT BILLTO FROM custaudit.salesplan WHERE SALESPLAN like '$salesplan';");
        $billtoquery->execute();
        $billtocolumns = $billtoquery->fetchAll(pdo::FETCH_COLUMN);
        $billtoinclude = "('" . implode("','", $billtocolumns) . "')";

        $result1 = $aseriesconn->prepare("SELECT  
                                                   1 - ((count(case when IP_FIL_TYP = 'BO' then IM0011.INV_PWHS else NULL end) +
                                                    count(case when IP_FIL_TYP = 'XD' then IM0011.INV_PWHS else NULL end)) /
                                                    cast(count( IM0011.INV_PWHS) as float)) as FR_AFT 
                                            FROM A.HSIPCORDTA.IM0011 IM0011, A.HSIPCORDTA.IM0018 IM0018 
                                            WHERE 
                                                    IM0018.CUSTOMER = IM0011.CUSTOMER 
                                                    and im0018.BILL_TO in $billtoinclude 
                                                    and substr(TR_DATE,1,6) >= '$startfisc' 
                                                    and substr(TR_DATE,1,6) <= '$endfisc' 
                                            GROUP BY substr(TR_DATE,1,6) ORDER BY substr(TR_DATE,1,6) asc");
        $result1->execute();
        $fillratecolumns = $result1->fetchAll(pdo::FETCH_COLUMN);

        $fillrates = implode(",", $fillratecolumns);

        $colcount = count($fillratecolumns);
        $endnum = $colcount - 1;
        $fr_start = number_format($fillratecolumns[0] * 100, 2);
        $fr_end = number_format($fillratecolumns[$endnum] * 100, 2);
        ?>


        <div class="brand-card">
            <div class="card-header bg-<?php echo $headerclass ?>">
                <div class="h4" style="color: white; text-align: center;"><?php echo $salesplan . ' | ' . $salesplan_desc ?></div>

            </div>
            <div class="brand-card-body">
                <div>
                    <div class="text-value"><?php echo $currscore ?></div>
                    <div class="text-uppercase text-muted small">Current Score</div>
                </div>
                <div>
                    <div class="text-value"><?php echo $histscore ?></div>
                    <div class="text-uppercase text-muted small">Last Qtr Score</div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="callout callout-<?php echo $headerclass ?>">
                    <div><?php echo "The quarterly score for " . $salesplan . $statement; ?></div>
                    <div><?php echo $driver_stmt; ?></div>
                </div>
            </div>
            <div class="chart-wrapper mx-auto" style="text-align: center">
                <span id="sparkline<?php echo $key; ?>"><?php echo $fillrates ?></span>
                <div class="col-xs-12">
                    <div class="row">
                        <div class="text-uppercase text-muted small text-center" style="margin: 5px;">
                            <span style="margin-right: 5px;"><strong><?php echo 'START: ' . $fr_start . '%'; ?></strong></span>
                            <span>Rolling 12 month after fill rate</span>
                            <span style="margin-left: 5px;"><strong><?php echo 'END: ' . $fr_end . '%'; ?></strong></span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <?php
}
?>


