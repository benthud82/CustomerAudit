<?php

ini_set('max_execution_time', 99999);

include_once '../connection/connection_details.php';



$shipaccsql = $conn1->prepare("SELECT 
                                                                ' ',
                                                                shipacc_id,
                                                                shipacc_whse,
                                                                shipacc_item,
                                                                shipacc_desc,
                                                                shipacc_acc30day,
                                                                shipacc_30day,
                                                                shipacc_acc90day,
                                                                shipacc_90day,
                                                                shipacc_acc365day,
                                                                shipacc_365day
                                                            FROM
                                                                custaudit.massalgorithm_shipacc_recs
                                                                    LEFT JOIN
                                                                custaudit.massalgorithm_actions ON shipacc_whse = ma_whse
                                                                    AND shipacc_item = ma_item
                                                            WHERE
                                                                NOT EXISTS( SELECT 
                                                                        *
                                                                    FROM
                                                                        custaudit.massalgorithm_actions
                                                                    WHERE
                                                                        shipacc_whse = ma_whse
                                                                            AND shipacc_item = ma_item
                                                                            AND ma_date >= DATE_ADD(CURDATE(), INTERVAL - 90 DAY))
                                                            ORDER BY shipacc_acc365day ASC");
$shipaccsql->execute();
$shipaccsqlarray = $shipaccsql->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($shipaccsqlarray as $key => $value) {
    $row[] = array_values($shipaccsqlarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
