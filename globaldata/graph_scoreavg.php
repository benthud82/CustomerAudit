
<?php

include_once '../connection/connection_details.php';

$result1 = $conn1->prepare("SELECT 
    scoreavg_salesplan.salesplan_scoreavg_date AS AVG_DATE,
    (scoreavg_salesplan.salesplan_scoreavg_30day) AS AVG_SP,
    (scoreavg_billto.salesplan_scoreavg_30day) AS AVG_BT,
    (scoreavg_shipto.salesplan_scoreavg_30day) AS AVG_ST
FROM
    custaudit.scoreavg_salesplan
        JOIN
    custaudit.scoreavg_billto ON scoreavg_salesplan.salesplan_scoreavg_date = scoreavg_billto.salesplan_scoreavg_date
        JOIN
    custaudit.scoreavg_shipto ON scoreavg_salesplan.salesplan_scoreavg_date = scoreavg_shipto.salesplan_scoreavg_date
WHERE
    scoreavg_salesplan.salesplan_scoreavg_date >= DATE_ADD(CURDATE(), INTERVAL - 365 DAY)
    and scoreavg_salesplan.salesplan_scoreavg_date >= '2019-05-05'
ORDER BY scoreavg_salesplan.salesplan_scoreavg_date");
$result1->execute();



$rows = array();
$rows['name'] = 'Date';
$rows1 = array();
$rows1['name'] = 'Sales Plan';
$rows2 = array();
$rows2['name'] = 'Bill To';
$rows3 = array();
$rows3['name'] = 'Ship To';

foreach ($result1 as $row) {
    $rows['data'][] = $row['AVG_DATE'];  //Date push
    $rows1['data'][] = $row['AVG_SP'] * 100;  //total count
    $rows2['data'][] = $row['AVG_BT'] * 100;  //total count
    $rows3['data'][] = $row['AVG_ST'] * 100;  //total count
}

$result = array();
array_push($result, $rows);
array_push($result, $rows1);
array_push($result, $rows2);
array_push($result, $rows3);

print json_encode($result);
