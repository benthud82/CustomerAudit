
<?php
include_once '../../globalincludes/usa_esys.php';
$jde_num = $_POST['jde_num'];


//Did the order pend?
$sql_orderentry = $eseriesconn->prepare("SELECT * FROM HSIPDTA71.F5501 WHERE QCDOCO  = $jde_num");
$sql_orderentry->execute();
$array_orderentry = $sql_orderentry->fetchAll(pdo::FETCH_ASSOC);

foreach ($array_orderentry as $key => $value) {
    echo $array_orderentry[$key]['QCDOCO'];
}