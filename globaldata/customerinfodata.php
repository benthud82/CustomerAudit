<?php
if(file_exists('../connection/connection_details.php')){
include_once '../connection/connection_details.php';
}else{
    include_once 'connection/connection_details.php';
}
   
$var_numtype = $_POST['numtype'];
//$var_custnum = $_POST['customnumber'];

switch ($var_numtype) {
    case 'salesplan':
        $var_custnum = $_POST['salesplan'];
        $sql = "SELECT DISTINCT SALESPLAN_DESC, ABAC08, ABAC10, ABAC04 FROM custaudit.salesplan WHERE SALESPLAN = '$var_custnum'";
        break;
    case 'billto':
        $var_custnum = intval($_POST['billto']);
        $sql = "SELECT DISTINCT
                            BILLTONAME as SALESPLAN_DESC, ABAC08, ABAC10, ABAC04
                        FROM
                            custaudit.salesplan
                            JOIN custaudit.customerscores_billto on BILLTONUM = BILLTO
                        WHERE
                            BILLTONUM = $var_custnum";
        break;
    case 'shipto':
        $var_custnum = intval($_POST['shipto']);
        $sql = "SELECT DISTINCT
                        SHIPTONAME as SALESPLAN_DESC, ABAC08, ABAC10, ABAC04
                    FROM
                        custaudit.salesplan
                        JOIN custaudit.customerscores_shipto on SHIPTONUM = SHIPTO
                    WHERE
                        SHIPTONUM = $var_custnum";
        break;

    case 'custom':
        $sql = 0;
        $var_custnum = $_POST['customnumber'];
        $sql2 = "SELECT 
                            mastergroupings_DESCRIPTION
                        FROM
                            custaudit.scorecard_mastergroupings
                        WHERE
                            mastergroupings_GROUPID = $var_custnum;";
        $custinfo2 = $conn1->prepare("$sql2");
        $custinfo2->execute();
        $custinfoarray2 = $custinfo2->fetchAll(pdo::FETCH_ASSOC);
        break;

    default:
        break;
}
$custinfoarray = array();
if ($sql !== 0) {
    $custinfo = $conn1->prepare("$sql");
    $custinfo->execute();
    $custinfoarray = $custinfo->fetchAll(pdo::FETCH_ASSOC);
}
$keycount = count($custinfoarray);

if ($keycount == 0) {
    $custinfoarray[0]['SALESPLAN_DESC'] = $custinfoarray2[0]['mastergroupings_DESCRIPTION'];
    $custinfoarray[0]['ABAC10'] = 'N/A';
    $custinfoarray[0]['ABAC04'] = 'N/A';
    $custinfoarray[0]['ABAC08'] = 'N/A';
}

echo "<h3 class='printheading'>" . $var_custnum . ' - ' . $custinfoarray[0]['SALESPLAN_DESC'] . '</h3>';

echo '<h5>Associated Market Segments: ';
foreach ($custinfoarray as $key => $value) {
    if ($key == 0) {
        echo $custinfoarray[$key]['ABAC08'];
    } elseif ($custinfoarray[$key - 1]['ABAC08'] !== $custinfoarray[$key]['ABAC08']) {
        echo $custinfoarray[$key]['ABAC08'];
    }
}
echo '</h5>';

echo '<h5>Associated Sales Divisions: ';
foreach ($custinfoarray as $key => $value) {
    if ($key == 0) {
        echo $custinfoarray[$key]['ABAC10'];
    } elseif ($custinfoarray[$key - 1]['ABAC10'] !== $custinfoarray[$key]['ABAC10']) {
        echo ' | ';
        echo $custinfoarray[$key]['ABAC10'];
    }
}
echo '</h5>';

echo "<h5 style='page-break-after:always;'>Associated Practice Types: ";
foreach ($custinfoarray as $key => $value) {
    if ($key == 0) {
        echo $custinfoarray[$key]['ABAC04'];
    } elseif ($custinfoarray[$key - 1]['ABAC04'] !== $custinfoarray[$key]['ABAC04']) {
        echo ' | ';
        echo $custinfoarray[$key]['ABAC04'];
    }
}
echo '</h5>';
?>


