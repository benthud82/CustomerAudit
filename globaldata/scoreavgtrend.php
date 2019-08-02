
<?php
include_once '../connection/connection_details.php';
include_once '../../globalfunctions/custdbfunctions.php';

$time = strtotime("-90 days", time());
$date = date("Y-m-d", $time);

$scoresql = $conn1->prepare("SELECT 
                                                            @curRank:=@curRank + 1 AS rank,
                                                            p.salesplan_scoreavg_30day * 100 as AVG_SP,
                                                            b.salesplan_scoreavg_30day * 100 as AVG_BT,
                                                            s.salesplan_scoreavg_30day * 100 as AVG_ST
                                                        FROM
                                                            custaudit.scoreavg_salesplan p
                                                                JOIN
                                                            custaudit.scoreavg_billto b ON p.salesplan_scoreavg_date = b.salesplan_scoreavg_date
                                                                JOIN
                                                            custaudit.scoreavg_shipto s ON p.salesplan_scoreavg_date = s.salesplan_scoreavg_date,
                                                            (SELECT @curRank:=0) r
                                                        WHERE
                                                            p.salesplan_scoreavg_date >= '$date'
                                                        ORDER BY p.salesplan_scoreavg_date ASC;  ");
$scoresql->execute();
$scorearray = $scoresql->fetchAll(pdo::FETCH_ASSOC);

$rankarray = array_column($scorearray, 'rank');
$totalscorearray = array_column($scorearray, 'AVG_SP');
$replenscorearray = array_column($scorearray, 'AVG_BT');
$walkscorearray = array_column($scorearray, 'AVG_ST');

$totalscoretrend = linear_regression($rankarray, $totalscorearray);
$totalscoretrend_m = $totalscoretrend['m'];
if ($totalscoretrend_m >= 0) {
    $totalscoretrend_color = 'green-jungle';
} else {
    $totalscoretrend_color = 'red-intense';
}

$replenscoretrend = linear_regression($rankarray, $replenscorearray);
$replenscoretrend_m = $replenscoretrend['m'];
if ($replenscoretrend_m >= 0) {
    $replenscoretrend_color = 'green-jungle';
} else {
    $replenscoretrend_color = 'red-intense';
}

$walkscoretrend = linear_regression($rankarray, $walkscorearray);
$walkscoretrend_m = $walkscoretrend['m'];
if ($walkscoretrend_m >= 0) {
    $walkscoretrend_color = 'green-jungle';
} else {
    $walkscoretrend_color = 'red-intense';
}
?>

<div class="row" style="padding-top: 25px">
    <div class="col-lg-4 " id="stat_totalscoretrend">
        <div class="dashboard-stat dashboard-stat-v2 <?php echo $totalscoretrend_color; ?>">  
            <div class="visual">
                <i class="fa fa-info-circle"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="1349"><?php echo number_format($totalscoretrend_m * 100, 2); ?></span>
                </div>
                <div class="desc">Sales Plan Score Trend</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 " id="stat_replenscoretrend">
        <div class="dashboard-stat dashboard-stat-v2 <?php echo $replenscoretrend_color; ?>">  
            <div class="visual">
                <i class="fa fa-info-circle"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="1349"><?php echo number_format($replenscoretrend_m * 100, 2); ?></span>
                </div>
                <div class="desc">Bill To Score Trend</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 " id="stat_walkscoretrend">
        <div class="dashboard-stat dashboard-stat-v2 <?php echo $walkscoretrend_color; ?>">  
            <div class="visual">
                <i class="fa fa-info-circle"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="1349"><?php echo number_format($walkscoretrend_m * 100, 2); ?></span>
                </div>
                <div class="desc">Ship To Score Trend</div>
            </div>
        </div>
    </div>



</div>
