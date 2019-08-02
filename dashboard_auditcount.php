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


$imapact_salesplan = $conn1->prepare("SELECT DISTINCT
                                            case
                                                when UPPER(auditcomplete_user) = '$var_userid' then count(*)
                                            end as SALESPLANAUDITS_ME,
                                            case
                                                when UPPER(auditcomplete_user) = '$var_userid' then AVG((SCOREMONTH * 100) - auditcomplete_SCOREMNT)
                                            end as SPIMPACT_ME,
                                            case
                                                when UPPER(auditcomplete_USERGROUP) = '$mygroupdata' then count(*)
                                            end as SALESPLANAUDITS_GROUP,
                                            case
                                                when UPPER(auditcomplete_USERGROUP) = '$mygroupdata' then AVG((SCOREMONTH * 100) - auditcomplete_SCOREMNT)
                                            end as SPIMPACT_GROUP,
                                            count(*) as SALESPLANAUDITS_TOTAL,
                                            AVG((SCOREMONTH * 100) - auditcomplete_SCOREMNT) as SPIMPACT_TOTAL
                                        FROM
                                            custaudit.auditcomplete
                                                JOIN
                                            custaudit.scorecard_display_salesplan ON SALESPLAN = auditcomplete_custid
                                        WHERE
                                            auditcomplete_custtype = 'SALESPLAN'
                                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY)");
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





$imapact_billto = $conn1->prepare("SELECT DISTINCT
                                            case
                                                when UPPER(auditcomplete_user) = '$var_userid' then count(*)
                                            end as BILLTOAUDITS_ME,
                                            case
                                                when UPPER(auditcomplete_user) = '$var_userid' then AVG((SCOREMONTH * 100) - auditcomplete_SCOREMNT)
                                            end as BTIMPACT_ME,
                                            case
                                                when UPPER(auditcomplete_USERGROUP) = '$mygroupdata' then count(*)
                                            end as BILLTOAUDITS_GROUP,
                                            case
                                                when UPPER(auditcomplete_USERGROUP) = '$mygroupdata' then AVG((SCOREMONTH * 100) - auditcomplete_SCOREMNT)
                                            end as BTIMPACT_GROUP,
                                            count(*) as BILLTOAUDITS_TOTAL,
                                            AVG((SCOREMONTH * 100) - auditcomplete_SCOREMNT) as BTIMPACT_TOTAL
                                        FROM
                                            custaudit.auditcomplete
                                                JOIN
                                            custaudit.scorecard_display_billto ON BILLTONUM = auditcomplete_custid
                                        WHERE
                                            auditcomplete_custtype = 'BILLTO'
                                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY)");
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
                                            case
                                                when UPPER(auditcomplete_user) = '$var_userid' then count(*)
                                            end as SHIPTOAUDITS_ME,
                                            case
                                                when UPPER(auditcomplete_user) = '$var_userid' then AVG((SCOREMONTH * 100) - auditcomplete_SCOREMNT)
                                            end as STIMPACT_ME,
                                            case
                                                when UPPER(auditcomplete_USERGROUP) = '$mygroupdata' then count(*)
                                            end as SHIPTOAUDITS_GROUP,
                                            case
                                                when UPPER(auditcomplete_USERGROUP) = '$mygroupdata' then AVG((SCOREMONTH * 100) - auditcomplete_SCOREMNT)
                                            end as STIMPACT_GROUP,
                                            count(*) as SHIPTOAUDITS_TOTAL,
                                            AVG((SCOREMONTH * 100) - auditcomplete_SCOREMNT) as STIMPACT_TOTAL
                                        FROM
                                            custaudit.auditcomplete
                                                JOIN
                                            custaudit.scorecard_display_shipto ON SHIPTONUM = auditcomplete_custid
                                        WHERE
                                            auditcomplete_custtype = 'SHIPTO'
                                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY)");
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

