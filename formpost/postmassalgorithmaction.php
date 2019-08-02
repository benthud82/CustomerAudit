
<?php

include_once '../connection/connection_details.php';
date_default_timezone_set('America/New_York');
$date = date('Y-m-d');
$algorithm = ($_POST['algorithm']);
$assigntask_id = intval($_POST['assigntask_id']);
$comment = addslashes($_POST['comment']);
$useridmodal = strtoupper($_POST['useridmodal']);
$actiontaken = intval($_POST['actiontaken']);
//$whsemodal = intval($_POST['whsemodal']);
//$itemmodal = intval($_POST['itemmodal']);

switch ($algorithm) {
    case 'DAMAGE':
        $idsql = $conn1->prepare("SELECT damage_whse, damage_item from custaudit.massalgorithm_damage_recs WHERE damage_id = $assigntask_id ");
        $idsql->execute();
        $idsqlarray = $idsql->fetchAll(pdo::FETCH_ASSOC);
        $whsemodal = $idsqlarray[0]['damage_whse'];
        $itemmodal = $idsqlarray[0]['damage_item'];
        break;
    case 'SKUOPT':
        $idsql = $conn1->prepare("SELECT skuopt_whse, skuopt_item from custaudit.massalgorithm_skuopt_recs WHERE skuopt_id = $assigntask_id ");
        $idsql->execute();
        $idsqlarray = $idsql->fetchAll(pdo::FETCH_ASSOC);
        $whsemodal = $idsqlarray[0]['skuopt_whse'];
        $itemmodal = $idsqlarray[0]['skuopt_item'];
        break;
    case 'SHIPACC':
        $idsql = $conn1->prepare("SELECT shipacc_whse, shipacc_item from custaudit.massalgorithm_shipacc_recs WHERE shipacc_id = $assigntask_id ");
        $idsql->execute();
        $idsqlarray = $idsql->fetchAll(pdo::FETCH_ASSOC);
        $whsemodal = $idsqlarray[0]['shipacc_whse'];
        $itemmodal = $idsqlarray[0]['shipacc_item'];
        break;
    default:
        break;
}


//add action to massalgorithm_actions table
$columns = 'ma_id, ma_whse, ma_item, ma_algorithm, ma_action, ma_comment, ma_date, ma_TSM';
$values = "0, $whsemodal, $itemmodal, '$algorithm',  $actiontaken, '$comment', '$date', '$useridmodal'";

$sql = "INSERT INTO custaudit.massalgorithm_actions ($columns) VALUES ($values)";
$query = $conn1->prepare($sql);
$query->execute();
