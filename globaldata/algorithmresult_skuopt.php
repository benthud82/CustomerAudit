<?php

include_once '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../../MySQLUpdates/updatelogic/sql_dailypick.php';
include_once '../functions/customer_audit_functions.php';
$var_itemcode = $_POST['itemcode'];
$var_rollmonthjdate = _rollmonth1yyddd();
$var_rollqtrjdate = _rollquarter1yyddd();
$var_rollr12jdate = _rolling12start1yyddd();

$skuoptresult = $aseriesconn->prepare("SELECT ORD_PWHS, 
                                          ITEM,
                                          sum(case when OR_DATE >= $var_rollmonthjdate then 1 else 0 end) as MONTH, 
                                          sum(case when OR_DATE >= $var_rollqtrjdate then 1 else 0 end) as QTR,
                                          sum(case when OR_DATE >= $var_rollr12jdate then 1 else 0 end) as YEAR,  
                                          WRSSTK
                                       FROM HSIPCORDTA.IM0011
                                       LEFT JOIN HSIPCORDTA.NPFWRS on ORD_PWHS = WRSWHS and ITEM = WRSITM
                                       WHERE ORD_PWHS in (2,3,6,7,9) and ITEM = '$var_itemcode'
                                       GROUP BY ORD_PWHS, ITEM, WRSSTK
                                       ORDER BY ORD_PWHS, ITEM");
$skuoptresult->execute();
$skuoptresultarray = $skuoptresult->fetchAll(pdo::FETCH_ASSOC);

$var_skuoptmin = 7;  //yearly minimum shipments by DC for item to be considered for skuopt
$var_monthcheck = 1; //have we at least shipped once in the last month to determine if shipping is still active
$issuecount_skuopt = 0; //initialize count of issues.
foreach ($skuoptresultarray as $key => $value) {
    $var_whse = $skuoptresultarray[$key]['ORD_PWHS'];
    $var_shipmnth = $skuoptresultarray[$key]['MONTH'];
    $var_shipqtr = $skuoptresultarray[$key]['QTR'];
    $var_shipyear = $skuoptresultarray[$key]['YEAR'];
    $var_stk = $skuoptresultarray[$key]['WRSSTK'];

    if (($var_stk == 'N' || $var_stk == '' || $var_stk == NULL ) && $var_shipmnth >= $var_monthcheck && $var_shipyear >= $var_skuoptmin) {
        $issuecount_skuopt += 1;
        echo "<li style='text-align: left; margin-bottom: 12px;'>DC " . $var_whse . " has had " . $var_shipyear . " orders for this year and " . $var_shipmnth . " orders the past month.  Consider adding this item as stocking.</li>";
    }
}


//if no issues for any DC, display a green card indicating no issues with E3 orderpoint
if ($issuecount_skuopt == 0) { //add classes to e3orderpoint card if no issues present    
    echo "<li style='text-align: left;'>There are no SKU opt opportunities</li>
       <script>
        $('#panel_skuopt').addClass('bg-success'); 
        $('#icon_skuopt').addClass('fa-check fa-2x'); 
    </script>";
} else { //add classes to e3orderpoint card if issues are present
    echo "<script>
        $('#panel_skuopt').addClass('bg-danger');
        $('#icon_skuopt').addClass('fa-times fa-2x');
    </script>";
}

