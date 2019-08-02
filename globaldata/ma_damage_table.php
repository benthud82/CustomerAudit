<?php

ini_set('max_execution_time', 99999);

include_once '../connection/connection_details.php';



$damagesql = $conn1->prepare("SELECT 
                                                                    ' ',
                                                                    damage_id,
                                                                    damage_whse,
                                                                    damage_item,
                                                                    damage_desc,
                                                                    damage_acc30day,
                                                                    damage_30day,
                                                                    damage_acc90day,
                                                                    damage_90day,
                                                                    damage_acc365day,
                                                                    damage_365day
                                                                FROM
                                                                    custaudit.massalgorithm_damage_recs
                                                                        LEFT JOIN
                                                                    custaudit.massalgorithm_actions ON damage_whse = ma_whse
                                                                        AND damage_item = ma_item
                                                                WHERE
                                                                    NOT EXISTS( SELECT 
                                                                            *
                                                                        FROM
                                                                            custaudit.massalgorithm_actions
                                                                        WHERE
                                                                            damage_whse = ma_whse
                                                                                AND damage_item = ma_item
                                                                                AND ma_date >= DATE_ADD(CURDATE(), INTERVAL - 90 DAY))
                                                                ORDER BY damage_acc365day ASC");
$damagesql->execute();
$damagesqlarray = $damagesql->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($damagesqlarray as $key => $value) {
    $row[] = array_values($damagesqlarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
