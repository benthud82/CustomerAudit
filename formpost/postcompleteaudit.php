
<?php

include_once '../connection/connection_details.php';
date_default_timezone_set('America/New_York');
$datetime = date('Y-m-d H:i:s');
$var_userid = ($_POST['userid']);
//Pull Assigned Group
$groupid = $conn1->prepare("SELECT 
                                    customeraudit_users_GROUP as USERGROUP
                                FROM
                                    custaudit.customeraudit_users
                                WHERE
                                    customeraudit_users_ID = '$var_userid';");
$groupid->execute();
$groupidarray = $groupid->fetchAll(pdo::FETCH_ASSOC);

$var_custalphanum = ($_POST['custalphanum']);

$var_fillratebefore_month = ($_POST['fillratebefore_month']) / 100;
$var_fillrateafter_month = ($_POST['fillrateafter_month']) / 100;
$var_shipacc_month = ($_POST['shipacc_month']) / 100;
$var_dmgacc_month = ($_POST['dmgacc_month']) / 100;
$var_addscacc_month = ($_POST['addscacc_month']) / 100;
$var_osc_month = ($_POST['osc_month']) / 100;
$var_score_month = intval($_POST['score_month']);
$var_score_quarter = intval($_POST['score_quarter']);
$var_score_r12 = intval($_POST['score_r12']);
$var_comment = ($_POST['comment']);
$var_custtype = ($_POST['custtype']);
$var_usergroup = $groupidarray[0]['USERGROUP'];


$columns = 'auditcomplete_id, auditcomplete_user, auditcomplete_custtype, auditcomplete_custid, auditcomplete_date, auditcompletecol_FRBEF, auditcomplete_FRAFT, auditcomplete_SHIPACC, auditcomplete_DMG, auditcomplete_SCDESC, auditcomplete_OSC, auditcomplete_SCOREMNT, auditcomplete_SCOREQTR, auditcomplete_SCORER12, auditcomplete_COMMENT, auditcomplete_USERGROUP';
$values = "0, '$var_userid', '$var_custtype', '$var_custalphanum', '$datetime', '$var_fillratebefore_month', '$var_fillrateafter_month', '$var_shipacc_month', '$var_dmgacc_month', '$var_addscacc_month', '$var_osc_month', $var_score_month, $var_score_quarter, $var_score_r12, '$var_comment', '$var_usergroup'";


$sql = "INSERT INTO custaudit.auditcomplete ($columns) VALUES ($values)";
$query = $conn1->prepare($sql);
$query->execute();


