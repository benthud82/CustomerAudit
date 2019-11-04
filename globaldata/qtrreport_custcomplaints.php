                        
<?php
include_once 'connection/connection_details.php';

$sql_custcomp = $conn1->prepare("SELECT 
                                METRIC,
                                SUM((SELECT 
                                        COUNT(*)
                                    FROM
                                        custaudit.custreturns A
                                    WHERE
                                        ORD_RETURNDATE >= DATE_ADD(CURDATE(), INTERVAL - 90 DAY)
                                            AND A.RETURNCODE = B.RETURNCODE
                                    GROUP BY METRIC)) AS CURQTR,
                                SUM((SELECT 
                                        COUNT(*)
                                    FROM
                                        custaudit.custreturns A
                                    WHERE
                                        ORD_RETURNDATE BETWEEN DATE_ADD(CURDATE(), INTERVAL - 180 DAY) AND DATE_ADD(CURDATE(), INTERVAL - 91 DAY)
                                            AND A.RETURNCODE = B.RETURNCODE
                                    GROUP BY METRIC)) AS PREVQTR
                            FROM
                                custaudit.custreturnmetrics B
                            GROUP BY METRIC");
$sql_custcomp->execute();
$array_custcomp = $sql_custcomp->fetchAll(pdo::FETCH_ASSOC);

$currsum = 0;
foreach ($array_custcomp as $item) {
    $currsum += $item['CURQTR'];
}


$prevsum = 0;
foreach ($array_custcomp as $item) {
    $prevsum += $item['PREVQTR'];
}

if ($prevsum <= $currsum) {
    $headerclass = 'bg-danger';
    $ticlass = 'ti-stats-up text-danger border-danger';
} else {
    $headerclass = 'bg-success';
    $ticlass = 'ti-stats-down text-success border-success';
}
?>


<div class="row">
    <!--Total customer complaints populated outside of array loop since using sum-->
    <div class="col-xs-6">
        <div class="card">
            <div class="card-header h4 <?php echo $headerclass ?>">TOTAL COMPLAINTS</div>
            <div class="card-body">
                <div class="stat-widget-four">
                    <div class="stat-icon dib">
                        <i class="<?php echo $ticlass ?>"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-heading">This Quarter: <strong><?php echo number_format($currsum, 0, ".", ",") ?></strong></div>
                            <div class="stat-text">Last Quarter: <?php echo number_format($prevsum, 0, ".", ",") ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Start array loop for remaining customer complaint metrics-->
    <?php
    foreach ($array_custcomp as $key => $value) {
        $metric = $array_custcomp[$key]['METRIC'];
        $prevsum = $array_custcomp[$key]['PREVQTR'];
        $currsum = $array_custcomp[$key]['CURQTR'];

        if ($prevsum <= $currsum) {
            $headerclass = 'bg-danger';
            $ticlass = 'ti-stats-up text-danger border-danger';
        } else {
            $headerclass = 'bg-success';
            $ticlass = 'ti-stats-down text-success border-success';
        }
        ?>
        <div class="col-xs-6">
            <div class="card">
                <div class="card-header h4 <?php echo $headerclass ?>"><?php echo strtoupper($metric) ?></div>
                <div class="card-body">
                    <div class="stat-widget-four">
                        <div class="stat-icon dib">
                            <i class="<?php echo $ticlass ?>"></i>
                        </div>
                        <div class="stat-content">
                            <div class="text-left dib">
                                <div class="stat-heading">This Quarter: <strong><?php echo number_format($currsum, 0, ".", ",") ?></strong></div>
                                <div class="stat-text">Last Quarter: <?php echo number_format($prevsum, 0, ".", ",") ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php } ?>

</div>
