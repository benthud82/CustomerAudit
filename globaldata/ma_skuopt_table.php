<?php

ini_set('max_execution_time', 99999);

include_once '../connection/connection_details.php';



$skuoptsql = $conn1->prepare("SELECT 
                                                                ' ',
                                                                skuopt_id,
                                                                skuopt_whse,
                                                                skuopt_item,
                                                                skuopt_desc,
                                                                skuopt_monthunits,
                                                                skuopt_yearunits
                                                            FROM
                                                                custaudit.massalgorithm_skuopt_recs
                                                                    LEFT JOIN
                                                                custaudit.massalgorithm_actions ON skuopt_whse = ma_whse
                                                                    AND skuopt_item = ma_item
                                                            WHERE
                                                                NOT EXISTS( SELECT 
                                                                        *
                                                                    FROM
                                                                        custaudit.massalgorithm_actions
                                                                    WHERE
                                                                        skuopt_whse = ma_whse
                                                                            AND skuopt_item = ma_item
                                                                            AND ma_date >= DATE_ADD(CURDATE(), INTERVAL - 90 DAY))
                                                            ORDER BY skuopt_yearunits DESC");
$skuoptsql->execute();
$skuoptsqlarray = $skuoptsql->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($skuoptsqlarray as $key => $value) {
    $row[] = array_values($skuoptsqlarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
