
<?php
include_once '../../globalincludes/usa_esys.php';
$jde_num = $_POST['jde_num'];


$sql_orderentry = $eseriesconn->prepare("");
$sql_orderentry->execute();
$array_orderentry = $sql_orderentry->fetchAll(pdo::FETCH_ASSOC);

echo 'CUSTOMER DATA HERE';