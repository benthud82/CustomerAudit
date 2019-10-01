<?php
include_once 'connection/connection_details.php';
//include_once '../globalfunctions/custdbfunctions.php';

//top 3 salesplans score history increase/decrease
$top3_sql = $conn1->prepare("SELECT 
                                                        S.SALESPLAN,
                                                        CAST(AVG(S.SCOREQUARTER_EXCLDS) * 100 AS UNSIGNED) AS HISTSCORE,
                                                        CAST((SELECT 
                                                                    X.SCOREQUARTER_EXCLDS
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
                                                    WHERE
                                                        S.RECORDDATE BETWEEN DATE_SUB(NOW(), INTERVAL 93 DAY) AND DATE_SUB(NOW(), INTERVAL 87 DAY)
                                                    GROUP BY S.SALESPLAN");
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
                                                                        custaudit.custscoresbyday_salesplan)");
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
<div class="row" style="margin-left: 50px;">
        <?php
        $driver_stmt = '';
        $salesplan = $top3_array[$key]['SALESPLAN'];
        $currscore = $top3_array[$key]['CURRSCORE'];
        $histscore = $top3_array[$key]['HISTSCORE'];
        //pull in driver data
        foreach ($driverlookuparray as $driverkey => $value) {
            $driver_salesplan = $driverlookuparray[$driverkey]['SALESPLAN'];
            if ($salesplan == $driver_salesplan) {
                $driver_stmt = $driverlookuparray[$driverkey]['STMT'];
            }
        }

        if ($currscore > $histscore) {
            $scoredif = $currscore - $histscore;
            $statement = " <strong>increased </strong> by $scoredif points from $histscore last quarter to $currscore this quarter";
        } elseif ($currscore < $histscore) {
            $scoredif = $histscore - $currscore;
            $statement = "<strong>decreased </strong> by  $scoredif points from $histscore last quarter to $currscore this quarter";
        } else {
            $statement = " was <strong> stagnant </strong> at a score of $currscore for both last quarter and this quarter";
        }

        echo "The quarterly score for $salesplan $statement.  $driver_stmt";
        ?>
    </div>

    <?php
}


    