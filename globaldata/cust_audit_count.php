<?php

include_once 'connection/connection_details.php';
//include_once '../globalfunctions/custdbfunctions.php';
//top 3 salesplans score history increase/decrease
$sql_custauditcount = $conn1->prepare("SELECT 
                                            auditcomplete_custtype, COUNT(*) AS AUDIT_COUNT
                                        FROM
                                            custaudit.auditcomplete
                                        WHERE
                                            auditcomplete_date >= DATE_ADD(CURDATE(), INTERVAL - 90 DAY)
                                        GROUP BY auditcomplete_custtype");
$sql_custauditcount->execute();
$array_custauditcount = $sql_custauditcount->fetchAll(pdo::FETCH_ASSOC);

$sql_itemauditcount = $conn1->prepare("SELECT 
                                            COUNT(DISTINCT customeraction_asgntasks_ITEM) AS ITEM_COUNT
                                        FROM
                                            custaudit.customeraction_asgntasks
                                        WHERE
                                            customeraction_asgntasks_DATE >= DATE_ADD(CURDATE(), INTERVAL - 90 DAY)
                                                AND customeraction_asgntasks_STATUS = 'COMPLETE'");
$sql_itemauditcount->execute();
$array_itemauditcount = $sql_itemauditcount->fetchAll(pdo::FETCH_ASSOC);

//mass alorithm recommendations
$sql_damage = $conn1->prepare("SELECT 
                                COUNT(*) AS DAMAGE
                            FROM
                                custaudit.massalgorithm_damage_recs;");
$sql_damage->execute();
$array_damage = $sql_damage->fetchAll(pdo::FETCH_ASSOC);

$sql_shipacc = $conn1->prepare("SELECT 
                                COUNT(*) AS SHIPACC
                            FROM
                                custaudit.massalgorithm_shipacc_recs;");
$sql_shipacc->execute();
$array_shipacc = $sql_shipacc->fetchAll(pdo::FETCH_ASSOC);

$sql_skuopt = $conn1->prepare("SELECT 
                                COUNT(*) AS SKUOPT
                            FROM
                                custaudit.massalgorithm_skuopt_recs;");
$sql_skuopt->execute();
$array_skuopt = $sql_skuopt->fetchAll(pdo::FETCH_ASSOC);

$sql_ma_actions = $conn1->prepare("SELECT 
                                COUNT(*) as ACTIONS
                            FROM
                                custaudit.massalgorithm_actions
                            WHERE
                                ma_date >= DATE_ADD(CURDATE(), INTERVAL - 90 DAY)");
$sql_ma_actions->execute();
$array_ma_actions = $sql_ma_actions->fetchAll(pdo::FETCH_ASSOC);

//assign variables
$count_damage = $array_damage[0]['DAMAGE'];
$count_skuopt = $array_skuopt[0]['SKUOPT'];
$count_shipacc = $array_shipacc[0]['SHIPACC'];
$count_totaction = $array_ma_actions[0]['ACTIONS'];

$tot_audits = 0;
foreach ($array_custauditcount as $key => $value) {
    $tot_audits += $array_custauditcount[$key]['AUDIT_COUNT'];
}





