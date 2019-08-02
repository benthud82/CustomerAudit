<?php

ini_set('max_execution_time', 99999);

include_once '../connection/connection_details.php';
include '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../functions/customer_audit_functions.php';

$var_itemcode = ($_GET['itemcode']);

$e3stats = $aseriesconn->prepare("SELECT cast(IWHSE as INT),
                                    IBIRDT,
                                    IMINQT,
                                    IBMULT,
                                    IDEM13,
                                    IOPIUN,
                                    IMXUNT,
                                    ISRVGL,
                                    ISRVAT,
                                    ILTFCT
                                  FROM E3TSCHEIN.E3ITEMA
                                  WHERE IITEM = '$var_itemcode' and IWHSE in (2,3,6,7,9)
                                  ORDER BY IWHSE asc");
$e3stats->execute();
$e3statsarray = $e3stats->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($e3statsarray as $key => $value) {
    //convert birthdate to readable date
    $e3statsarray[$key]['IBIRDT'] = _yyyydddtogregdate($e3statsarray[$key]['IBIRDT']);
    $row[] = array_values($e3statsarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
