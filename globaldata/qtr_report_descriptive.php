<?php
include_once 'connection/connection_details.php';
//include_once '../globalfunctions/custdbfunctions.php';

$custcount = $conn1->prepare("SELECT 
                                                                COUNT(*) as CUST_COUNT,
                                                                AVG(SCOREQUARTER_EXCLDS) as AVG_SCORE
                                                            FROM
                                                                custaudit.scorecard_display_salesplan
                                                            WHERE
                                                                TOTR12SALES >= 500000 ");
$custcount->execute();
$custcount_array = $custcount->fetchAll(pdo::FETCH_ASSOC);




$time = strtotime("-90 days", time());
$date = date("Y-m-d", $time);

$scoresql = $conn1->prepare("SELECT 
                                                            @curRank:=@curRank + 1 AS currank,
                                                            p.salesplan_scoreavg_30day * 100 as AVG_SP
                                                        FROM
                                                            custaudit.scoreavg_salesplan p,
                                                            (SELECT @curRank:=0) r
                                                        WHERE
                                                            p.salesplan_scoreavg_date >= '$date'
                                                        ORDER BY p.salesplan_scoreavg_date ASC;  ");
$scoresql->execute();
$scorearray = $scoresql->fetchAll(pdo::FETCH_ASSOC);

$rankarray = array_column($scorearray, 'currank');
$totalscorearray = array_column($scorearray, 'AVG_SP');

$totalscoretrend = linear_regression($rankarray, $totalscorearray);
$totalscoretrend_m = $totalscoretrend['m'];
?> 
<div class="col-xs-6" style="padding-top: 30px">
    <div class="row">
        <h4> <?php echo 'Total number of customers tracked: ' . $custcount_array[0]['CUST_COUNT']; ?> </h4>
    </div>
    <div class="row">
        <h4>  <?php echo 'Average quarterly score: ' . intval($custcount_array[0]['AVG_SCORE'] * 100); ?> </h4>
    </div>
    <div class="row">
        <h4>  <?php
            $plusminus = ($totalscoretrend_m >= 0 ? '+' : '-');
            echo 'The average score trend: ' . $plusminus . number_format($totalscoretrend_m * 100,1);
            ?> </h4>
    </div>
</div>

