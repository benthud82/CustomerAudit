<?php

include_once '../../globalincludes/usa_asys_session.php';
session_write_close();
include_once '../../MySQLUpdates/updatelogic/sql_dailypick.php';
include_once '../functions/customer_audit_functions.php';
$var_itemcode = $_POST['itemcode'];  //transfers over as bill to, but this is the salesplan

$e3minresult = $aseriesconn->prepare("SELECT
                                        B.IWHSE,
                                        B.IOPIUN,
                                        B.ILTFOR, 
                                        SUM(A.SHIP_QTY_MN) as AVG_UNIT, 
                                        SUM($sql_dailyunit) as DAILY_AVG
                                      FROM HSIPCORDTA.NPTSLD A JOIN E3TSCHEIN.E3ITEMA B on B.IWHSE = A.WAREHOUSE AND B.IITEM = A.ITEM_NUMBER
                                      WHERE IITEM = '$var_itemcode' and B.IWHSE in (2,3,6,7,9)
                                      GROUP BY IWHSE,IOPIUN,ILTFOR
                                      ORDER BY IWHSE asc");
$e3minresult->execute();
$e3minresultarray = $e3minresult->fetchAll(pdo::FETCH_ASSOC);

//logic to determine if E3 orderpoint issue (e3 min)
$daysformin = 3; //is this the correct days to have onhand for min?
$issuecount_e3min = 0; //initialize count of issues.
foreach ($e3minresultarray as $key => $value) {
    $var_whse = intval($e3minresultarray[$key]['IWHSE']);
    $var_orderpoint = intval($e3minresultarray[$key]['IOPIUN']);
    $var_leadtime = number_format($e3minresultarray[$key]['ILTFOR'], 2);
    $var_avgunit = number_format($e3minresultarray[$key]['AVG_UNIT'], 2);
    $var_dailyunit = number_format($e3minresultarray[$key]['DAILY_AVG'], 2);

    //is order point sufficient to meet 3(?) days of average unit?
    $result_array_avg_unit = _average_unit_to_order_point($var_orderpoint, $var_avgunit, $daysformin);

    //is order point sufficient to meet average daily units
    $result_array_daily_unit = _daily_unit_to_order_point($var_orderpoint, $var_dailyunit, $var_leadtime);

    //increment issue count if issue is present
    if ($result_array_avg_unit['ISSUECOUNT'] == 1 || $result_array_daily_unit['ISSUECOUNT'] == 1) {
        $issuecount_e3min += 1;
    }



    //if issue with $result_array_daily_unit, display
    if ($result_array_daily_unit['ISSUECOUNT'] == 1) {
        echo "<li style='text-align: left; margin-bottom: 12px;'>The order point for DC " . $var_whse . " is not sufficient at " . $var_orderpoint . " units.  The average daily units is " . $var_dailyunit . " with a lead time of " . $var_leadtime . " days. Order point suggestion: " . intval($var_leadtime * $var_dailyunit) . " units.</li>";
    }
    //else if issue with $result_array_avg_unit, display
    elseif ($result_array_avg_unit['ISSUECOUNT'] == 1) {
        echo "<li style='text-align: left; margin-bottom: 12px;'>The order point for DC " . $var_whse . " is not sufficient at " . $var_orderpoint . " units.  The average ship quantity is " . $var_avgunit . " with a lead time of " . $var_leadtime . " days. Order point suggestion: " . intval(3 * $var_avgunit) . " units.</li>";
    }
}

//if no issues for any DC, display a green card indicating no issues with E3 orderpoint
if ($issuecount_e3min == 0) { //add classes to e3orderpoint card if no issues present    
    echo "<li style='text-align: left;'>E3 order point is acceptable for all DCs!</li>
       <script>
        $('#panel_e3orderpoint').addClass('bg-success'); 
        $('#icon_e3orderpoint').addClass('fa-check fa-2x'); 
    </script>";
} else { //add classes to e3orderpoint card if issues are present
    echo "<script>
        $('#panel_e3orderpoint').addClass('bg-danger');
        $('#icon_e3orderpoint').addClass('fa-times fa-2x');
    </script>";
}


    