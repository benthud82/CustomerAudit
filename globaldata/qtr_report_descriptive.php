<?php
include_once 'connection/connection_details.php';
//include_once '../globalfunctions/custdbfunctions.php';

$custcount = $conn1->prepare("SELECT 
                                                                COUNT(*) as CUST_COUNT,
                                                                AVG(SCOREQUARTER_EXCLDS) as AVG_SCORE
                                                            FROM
                                                                custaudit.scorecard_display_salesplan
                                                            WHERE
                                                                TOTR12SALES >= 500000 ");
$custcount->execute();
$custcount_array = $custcount->fetchAll(pdo::FETCH_ASSOC);




$time = strtotime("-90 days", time());
$date = date("Y-m-d", $time);

$scoresql = $conn1->prepare("SELECT 
                                                            @curRank:=@curRank + 1 AS currank,
                                                            p.salesplan_scoreavg_30day * 100 as AVG_SP
                                                        FROM
                                                            custaudit.scoreavg_salesplan p,
                                                            (SELECT @curRank:=0) r
                                                        WHERE
                                                            p.salesplan_scoreavg_date >= '$date'
                                                        ORDER BY p.salesplan_scoreavg_date ASC;  ");
$scoresql->execute();
$scorearray = $scoresql->fetchAll(pdo::FETCH_ASSOC);

$rankarray = array_column($scorearray, 'currank');
$totalscorearray = array_column($scorearray, 'AVG_SP');

$totalscoretrend = linear_regression($rankarray, $totalscorearray);
$totalscoretrend_m = $totalscoretrend['m'];

