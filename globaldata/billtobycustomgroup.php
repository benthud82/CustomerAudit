<?php
ini_set('max_execution_time', 99999);

include_once '../connection/connection_details.php';

$groupid = ($_GET['groupid']);


$customerdata = $conn1->prepare("SELECT DISTINCT
                                                                                A.BILLTONUM,
                                                                                A.BILLTONAME,
                                                                                FORMAT(A.TOTMONTHLINES, 0),
                                                                                CONCAT('$', FORMAT(A.TOTMONTHSALES, 0)),
                                                                                FORMAT(A.TOTR12LINES, 0),
                                                                                CONCAT('$', FORMAT(A.TOTR12SALES, 0)),
                                                                                CONCAT(CAST(A.BEFFRMNT * 100 AS DECIMAL (5 , 2 )),
                                                                                        '%'),
                                                                                CONCAT(CAST(A.BEFFRR12 * 100 AS DECIMAL (5 , 2 )),
                                                                                        '%'),
                                                                                CONCAT(CAST(A.AFTFRMNT * 100 AS DECIMAL (5 , 2 )),
                                                                                        '%'),
                                                                                CONCAT(CAST(A.AFTFRR12 * 100 AS DECIMAL (5 , 2 )),
                                                                                        '%'),
                                                                                FORMAT(A.CUSTSCOREMNT_EXCLDS * 100, 0),
                                                                                FORMAT(A.CUSTSCOREQTR_EXCLDS * 100, 0),
                                                                                FORMAT(A.CUSTSCORER12_EXCLDS * 100, 0),
                                                                                B.SLOPE30DAY,
                                                                                B.SLOPELINES30DAY
                                                                            FROM
                                                                                custaudit.customerscores_billto A
                                                                                    JOIN
                                                                                custaudit.scorecard_display_billto B ON B.BILLTONUM = A.BILLTONUM
                                                                                    JOIN
                                                                                custaudit.scorecard_groupingdetail C ON C.group_BILLTO = A.BILLTONUM
                                                                            WHERE
                                                                                C.group_MASTERID = $groupid
                                                                            ORDER BY A.TOTMONTHSALES DESC");
$customerdata->execute();
$customerdataarray = $customerdata->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($customerdataarray as $key => $value) {
    $row[] = array_values($customerdataarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
