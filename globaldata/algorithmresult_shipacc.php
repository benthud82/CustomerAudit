<?php

include_once '../connection/connection_details.php';
include_once '../../globalincludes/usa_asys_session.php';
session_write_close();

include_once '../../MySQLUpdates/updatelogic/sql_dailypick.php';
include_once '../functions/customer_audit_functions.php';
$var_itemcode = $_POST['itemcode'];
$var_rollmonthjdate = _rollmonth1yyddd();
$var_rollqtrjdate = _rollquarter1yyddd();
$var_rollr12jdate = _rolling12start1yyddd();

$itemlines = $aseriesconn->prepare("SELECT                                     
                                    sum(case when OR_DATE >= $var_rollmonthjdate then 1 else 0 end) as LINES_MNTH,
                                    sum(case when OR_DATE >= $var_rollqtrjdate then 1 else 0 end) as LINES_QTR,
                                    sum(case when OR_DATE >= $var_rollr12jdate then 1 else 0 end) as LINES_YEAR
                                        
                                  FROM HSIPCORDTA.IM0011 A

                                  WHERE ITEM = '$var_itemcode'");
$itemlines->execute();
$itemlinesarray = $itemlines->fetchAll(pdo::FETCH_ASSOC);

$lines_mnth = $itemlinesarray[0]['LINES_MNTH'];
$lines_qtr = $itemlinesarray[0]['LINES_QTR'];
$lines_year = $itemlinesarray[0]['LINES_YEAR'];



$shipaccresult = $conn1->prepare("SELECT 
                                        A.RETURNCODE,
                                        B.TRUNCATEDDESC,
                                        sum(case
                                            when RETURNDATE >= $var_rollmonthjdate then 1
                                            else 0
                                        end) as RETURNS_MNTH,
                                        sum(case
                                            when RETURNDATE >= $var_rollqtrjdate then 1
                                            else 0
                                        end) as RETURNS_QTR,
                                        sum(case
                                            when RETURNDATE >= $var_rollr12jdate then 1
                                            else 0
                                        end) as RETURNS_YEAR
                                    FROM
                                        custaudit.custreturns A
                                    JOIN custaudit.custreturnmetrics B on A.RETURNCODE = B.RETURNCODE
                                    WHERE
                                        ITEMCODE = '$var_itemcode' and A.RETURNCODE in ('WISP','WQSP','EXPR')
                                    GROUP BY A.RETURNCODE;");
$shipaccresult->execute();
$shipaccresultarray = $shipaccresult->fetchAll(pdo::FETCH_ASSOC);

$minpercent = .9985;  //if percentage below, then issue
$issuecount_shipacc = 0; //initialize count of issues.
foreach ($shipaccresultarray as $key => $value) {
    $var_returncode = $shipaccresultarray[$key]['RETURNCODE'];
    $var_return_mnth = $shipaccresultarray[$key]['RETURNS_MNTH'];
    $var_return_qtr = $shipaccresultarray[$key]['RETURNS_QTR'];
    $var_return_year = $shipaccresultarray[$key]['RETURNS_YEAR'];
    $var_description = $shipaccresultarray[$key]['TRUNCATEDDESC'];

    $var_accpercent_mnth = number_format(1 - ($var_return_mnth / $lines_mnth), 4);
    $var_accpercent_qtr = number_format(1 - ($var_return_qtr / $lines_qtr), 4);
    $var_accpercent_year = number_format(1 - ($var_return_year / $lines_year), 4);

    //Note: do not look at monthly accuracy because of delay and leadtime to get customer returns back and entered into system. Monthly number is potentially artificially high.
    if ($var_accpercent_year <= $minpercent || $var_accpercent_qtr <= $minpercent) {
        $issuecount_shipacc += 1;
        echo "<li style='text-align: left; margin-bottom: 12px;'>Error Code " . $var_returncode . " (" . $var_description . ") has an overall accuracy of  " . $var_accpercent_year * 100 . "% for the year.  Overall accuracy for the quarter is  " . $var_accpercent_qtr * 100 . "%.</li>";
    }
}


//if no issues for any DC, display a green card indicating no issues with E3 orderpoint
if ($issuecount_shipacc == 0) { //add classes to shipacc card if no issues present    
    echo "<li style='text-align: left;'>There are no shipping accuracy opportunities</li>
       <script>
        $('#panel_shipacc').addClass('bg-success'); 
        $('#icon_shipacc').addClass('fa-check fa-2x'); 
    </script>";
} else { //add classes to shipacc card if issues are present
    echo "<script>
        $('#panel_shipacc').addClass('bg-danger');
        $('#icon_shipacc').addClass('fa-times fa-2x');
    </script>";
}

