<?php

//$var_userid = $_POST['userid'];
$var_userid = strtoupper($_SESSION['MYUSER']);
$monthlyauditgoal_me = 10;
$monthlyauditgoal_group = 100;
$monthlyauditgoal_all = 200;

//find group
$mygroup = $conn1->prepare("SELECT customeraudit_users_GROUP
                            FROM custaudit.customeraudit_users
                            WHERE UPPER(customeraudit_users_ID = '$var_userid')");
$mygroup->execute();
$mygrouparray = $mygroup->fetchAll(pdo::FETCH_ASSOC);
$mygroupdata = $mygrouparray[0]['customeraudit_users_GROUP'];


$imapact_salesplan = $conn1->prepare("SELECT 
                                                                            SUM(CASE
                                                                                WHEN UPPER(auditcomplete_user) = '$var_userid' THEN 1
                                                                                ELSE 0
                                                                            END) AS SALESPLANAUDITS_ME,
                                                                            AVG(CASE
                                                                                WHEN UPPER(auditcomplete_user) = '$var_userid' THEN ((SCOREMONTH_EXCLDS * 100) - auditcomplete_SCOREMNT)
                                                                            END) AS SPIMPACT_ME,
                                                                            SUM(CASE
                                                                                WHEN UPPER(auditcomplete_USERGROUP) = '$mygroupdata' THEN 1
                                                                                ELSE 0
                                                                            END) AS SALESPLANAUDITS_GROUP,
                                                                            AVG(CASE
                                                                                WHEN UPPER(auditcomplete_USERGROUP) = '$mygroupdata' THEN ((SCOREMONTH_EXCLDS * 100) - auditcomplete_SCOREMNT)
                                                                            END) AS SPIMPACT_GROUP,
                                                                            COUNT(*) AS SALESPLANAUDITS_TOTAL,
                                                                            AVG((SCOREMONTH_EXCLDS * 100) - auditcomplete_SCOREMNT) AS SPIMPACT_TOTAL
                                                                        FROM
                                                                            custaudit.auditcomplete
                                                                                JOIN
                                                                            custaudit.scorecard_display_salesplan ON SALESPLAN = auditcomplete_custid
                                                                        WHERE
                                                                            auditcomplete_custtype = 'SALESPLAN'
                                                                                AND auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
$imapact_salesplan->execute();
$imapact_salesplanarray = $imapact_salesplan->fetchAll(pdo::FETCH_ASSOC);



$auditcount_me_SP = intval($imapact_salesplanarray[0]['SALESPLANAUDITS_ME']);
$auditcount_group_SP = intval($imapact_salesplanarray[0]['SALESPLANAUDITS_GROUP']);
$auditcount_all_SP = intval($imapact_salesplanarray[0]['SALESPLANAUDITS_TOTAL']);

$IMPACT_MNTH_me_SP = number_format($imapact_salesplanarray[0]['SPIMPACT_ME'], 1);
$GOALPERC_me_SP = intval(($auditcount_me_SP / $monthlyauditgoal_me) * 100);

$IMPACT_MNTH_group_SP = number_format($imapact_salesplanarray[0]['SPIMPACT_GROUP'], 1);
$GOALPERC_group_SP = intval(($auditcount_group_SP / $monthlyauditgoal_group) * 100);


$IMPACT_MNTH_all_SP = number_format($imapact_salesplanarray[0]['SPIMPACT_TOTAL'], 1);
$GOALPERC_all_SP = intval(($auditcount_all_SP / $monthlyauditgoal_all) * 100);





$imapact_billto = $conn1->prepare("SELECT
                                            sum(case
                                                when UPPER(auditcomplete_user) = '$var_userid' then 1 else 0
                                            end) as BILLTOAUDITS_ME,
                                            avg(case
                                                when UPPER(auditcomplete_user) = '$var_userid' then ((SCOREMONTH_EXCLDS * 100) - auditcomplete_SCOREMNT)
                                            end) as BTIMPACT_ME,
                                            sum(case
                                                when UPPER(auditcomplete_USERGROUP) = '$mygroupdata' then 1 else 0 
                                            end) as BILLTOAUDITS_GROUP,
                                            avg(case
                                                when UPPER(auditcomplete_USERGROUP) = '$mygroupdata' then ((SCOREMONTH_EXCLDS * 100) - auditcomplete_SCOREMNT)
                                            end) as BTIMPACT_GROUP,
                                            count(*) as BILLTOAUDITS_TOTAL,
                                            AVG((SCOREMONTH_EXCLDS * 100) - auditcomplete_SCOREMNT) as BTIMPACT_TOTAL
                                        FROM
                                            custaudit.auditcomplete
                                                JOIN
                                            custaudit.scorecard_display_billto ON BILLTONUM = auditcomplete_custid
                                        WHERE
                                            auditcomplete_custtype = 'BILLTO'
                                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
$imapact_billto->execute();
$imapact_billtoarray = $imapact_billto->fetchAll(pdo::FETCH_ASSOC);



$auditcount_me_BT = intval($imapact_billtoarray[0]['BILLTOAUDITS_ME']);
$auditcount_group_BT = intval($imapact_billtoarray[0]['BILLTOAUDITS_GROUP']);
$auditcount_all_BT = intval($imapact_billtoarray[0]['BILLTOAUDITS_TOTAL']);

$IMPACT_MNTH_me_BT = number_format($imapact_billtoarray[0]['BTIMPACT_ME'], 1);
$GOALPERC_me_BT = intval(($auditcount_me_BT / $monthlyauditgoal_me) * 100);

$IMPACT_MNTH_group_BT = number_format($imapact_billtoarray[0]['BTIMPACT_GROUP'], 1);
$GOALPERC_group_BT = intval(($auditcount_group_BT / $monthlyauditgoal_group) * 100);


$IMPACT_MNTH_all_BT = number_format($imapact_billtoarray[0]['BTIMPACT_TOTAL'], 1);
$GOALPERC_all_BT = intval(($auditcount_all_BT / $monthlyauditgoal_all) * 100);


$imapact_shipto = $conn1->prepare("SELECT DISTINCT
                                            sum(case
                                                when UPPER(auditcomplete_user) = '$var_userid' then 1 else 0
                                            end) as SHIPTOAUDITS_ME,
                                            avg(case
                                                when UPPER(auditcomplete_user) = '$var_userid' then ((SCOREMONTH_EXCLDS * 100) - auditcomplete_SCOREMNT)
                                            end) as STIMPACT_ME,
                                            sum(case
                                                when UPPER(auditcomplete_USERGROUP) = '$mygroupdata' then 1 else 0
                                            end) as SHIPTOAUDITS_GROUP,
                                            avg(case
                                                when UPPER(auditcomplete_USERGROUP) = '$mygroupdata' then ((SCOREMONTH_EXCLDS * 100) - auditcomplete_SCOREMNT)
                                            end) as STIMPACT_GROUP,
                                            count(*) as SHIPTOAUDITS_TOTAL,
                                            AVG((SCOREMONTH_EXCLDS * 100) - auditcomplete_SCOREMNT) as STIMPACT_TOTAL
                                        FROM
                                            custaudit.auditcomplete
                                                JOIN
                                            custaudit.scorecard_display_shipto ON SHIPTONUM = auditcomplete_custid
                                        WHERE
                                            auditcomplete_custtype = 'SHIPTO'
                                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
$imapact_shipto->execute();
$imapact_shiptoarray = $imapact_shipto->fetchAll(pdo::FETCH_ASSOC);



$auditcount_me_ST = intval($imapact_shiptoarray[0]['SHIPTOAUDITS_ME']);
$auditcount_group_ST = intval($imapact_shiptoarray[0]['SHIPTOAUDITS_GROUP']);
$auditcount_all_ST = intval($imapact_shiptoarray[0]['SHIPTOAUDITS_TOTAL']);

$IMPACT_MNTH_me_ST = number_format($imapact_shiptoarray[0]['STIMPACT_ME'], 1);
$GOALPERC_me_ST = intval(($auditcount_me_ST / $monthlyauditgoal_me) * 100);

$IMPACT_MNTH_group_ST = number_format($imapact_shiptoarray[0]['STIMPACT_GROUP'], 1);
$GOALPERC_group_ST = intval(($auditcount_group_ST / $monthlyauditgoal_group) * 100);


$IMPACT_MNTH_all_ST = number_format($imapact_shiptoarray[0]['STIMPACT_TOTAL'], 1);
$GOALPERC_all_ST = intval(($auditcount_all_ST / $monthlyauditgoal_all) * 100);

