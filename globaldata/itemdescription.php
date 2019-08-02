<?php

include_once '../connection/connection_details.php';
include '../../globalincludes/usa_asys_session.php';
session_write_close();

$var_salesplan = ($_POST['salesplan']);
$var_itemcode = ($_POST['itemcode']);
//$var_whse = intval($_POST['whse']);

$itemdesc = $aseriesconn->prepare("SELECT DISTINCT IITEM, INAME, IBUYR, IVNDR FROM E3TSCHEIN.E3ITEMA WHERE IITEM = '$var_itemcode'");
$itemdesc->execute();
$itemdescarray = $itemdesc->fetchAll(pdo::FETCH_ASSOC);

echo "<h5><i class='fa fa-info-circle fa-lg'></i>". '  ' . $itemdescarray[0]['IITEM'] . ' | ' . $itemdescarray[0]['INAME'] . ' | ' . $itemdescarray[0]['IVNDR'] . ' | Buyer: ' . $itemdescarray[0]['IBUYR'] . "<div class='row'><div class='col-xs-12' style='margin: 15px;'><button id='addaction' type='button' class='btn btn-info commentclick' onclick='' style='margin-bottom: 5px;'>Take Action</button></div></div></h5>";

