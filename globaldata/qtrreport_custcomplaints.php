                        
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


