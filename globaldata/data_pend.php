
<?php
include_once '../../globalincludes/usa_esys.php';
$jde_num = $_POST['jde_num'];


//Did the order pend?
$sql_pend = $eseriesconn->prepare("SELECT * FROM HSIPDTA71.F4209H WHERE HODOCO = $jde_num");
$sql_pend->execute();
$array_pend = $sql_pend->fetchAll(pdo::FETCH_ASSOC);

foreach ($array_pend as $key => $value) {
    echo $array_pend[$key]['HODOCO'];
}