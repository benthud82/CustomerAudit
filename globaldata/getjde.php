
<?php

include_once '../../globalincludes/usa_asys.php';

$num_invoice = intval($_POST['num_invoice']);


$sql_jde_closed = $aseriesconn->prepare("SELECT DISTINCT PBDOCO FROM HSIPCORDTA.NOTWPS WHERE PBWCS# = $num_invoice");
$sql_jde_closed->execute();
$array_jde_closed = $sql_jde_closed->fetchAll(pdo::FETCH_ASSOC);

//if not in closed table, check open table
if (empty($array_jde_closed)) {
    $sql_jde_closed = $aseriesconn->prepare("SELECT DISTINCT PBDOCO FROM HSIPCORDTA.NOTWPB WHERE PBWCS# = $num_invoice");
    $sql_jde_closed->execute();
    $array_jde_closed = $sql_jde_closed->fetchAll(pdo::FETCH_ASSOC);
}

//if array still empty, return error
if (empty($array_jde_closed)) {
    $jdenum = 'ERR';
} else {
    $jdenum = $array_jde_closed[0]['PBDOCO'];
}

$jdenum = $array_jde_closed[0]['PBDOCO'];

echo json_encode($jdenum);
