
<?php

include_once '../connection/connection_details.php';
date_default_timezone_set('America/New_York');
$datetime = date('Y-m-d H:i:s');
$customeraction_completetask = 0;

if (isset($_POST['assigntask_id'])) {
    $var_assigntask_id = intval($_POST['assigntask_id']);
    $var_comment = ($_POST['comment']);
    $var_correct = intval($_POST['correct']);
    $var_completeduser = ($_POST['useridmodal']);
}

//pull info for assigned task
$asstaskinfo = $conn1->prepare("SELECT * FROM customeraction_asgntasks WHERE idcustomeraction_asgntasks = $var_assigntask_id");
$asstaskinfo->execute();
$asstaskinfoarray = $asstaskinfo->fetchAll(pdo::FETCH_ASSOC);

$var_ASGNTSM = $asstaskinfoarray[0]['customeraction_asgntasks_ASGNTSM'];
$var_TOTSM = $var_completeduser;
$var_DATE = $asstaskinfoarray[0]['customeraction_asgntasks_DATE'];
$var_GROUP = $asstaskinfoarray[0]['customeraction_asgntasks_GROUP'];
$var_ITEM = intval($asstaskinfoarray[0]['customeraction_asgntasks_ITEM']);



$custgroup = $asstaskinfoarray[0]['customeraction_asgntasks_CUSTGROUP'];
$custid = $asstaskinfoarray[0]['customeraction_asgntask_GROUPID'];
switch ($asstaskinfoarray[0]['customeraction_asgntasks_CUSTGROUP']) {
    case 'SALESPLAN':
        $usetable = 'scorecard_display_salesplan';
        $wherestmt = " SALESPLAN = '$custid'";
        break;
    case 'BILLTO':
        $usetable = 'scorecard_display_billto';
        $wherestmt = " BILLTONUM = '$custid'";
        break;
    case 'SHIPTO':
        $usetable = 'scorecard_display_shipto';
        $wherestmt = " SHIPTONUM = '$custid'";
        break;
    default:
        break;
}


//pull scores and fill rates for assigned group
$scoreinfo = $conn1->prepare("SELECT * FROM $usetable WHERE $wherestmt");
$scoreinfo->execute();
$scoreinfoarray = $scoreinfo->fetchAll(pdo::FETCH_ASSOC);

$var_frbefore = $scoreinfoarray[0]['BEFFRMNT_EXCLDS'];   //month before fill rate
$var_frafter = $scoreinfoarray[0]['AFTFRMNT_EXCLDS'];  //month after fill rate
$var_shipacc = $scoreinfoarray[0]['SHIPACCQUARTER'];  //use 90 day because of lag time on customer returns
$var_dmg = $scoreinfoarray[0]['DMGACCQUARTER']; //use 90 day because of lag time on customer returns
$var_scdesc = $scoreinfoarray[0]['ADDSCACCQUARTER'];  //use 90 day because of lag time on customer returns
$var_osc = $scoreinfoarray[0]['OSCMONTH'];  //month OSC

$var_score_month = intval($scoreinfoarray[0]['SCOREMONTH'] * 100);
$var_score_quarter = intval($scoreinfoarray[0]['SCOREQUARTER'] * 100);
$var_score_r12 = intval($scoreinfoarray[0]['SCOREROLL12'] * 100);



$columns = 'idcustomeraction_comptasks, customeraction_comptasks_ASGNTSM, customeraction_comptasks_TOTSM, customeraction_comptasks_ASGNDATE, customeraction_comptasks_COMPDATE, customeraction_comptasks_GROUP, customeraction_comptasks_ITEM, customeraction_comptasks_CUSTGROUP, customeraction_comptasks_GROUPID, customeraction_comptasks_COMMENT, customeraction_comptasks_CORRECT, customeraction_comptasks_FRBEF, customeraction_comptasks_FRAFT, customeraction_comptasks_SHIPACC, customeraction_comptasks_DMG, customeraction_comptasks_SCDESC, customeraction_comptasks_OSC, customeraction_comptasks_SCOREMNT, customeraction_comptasks_SCOREQTR, customeraction_comptasks_SCORER12, assign_task_ID';
$values = "0, '$var_ASGNTSM', '$var_TOTSM', '$var_DATE', '$datetime', '$var_GROUP', $var_ITEM, '$custgroup', '$custid', '$var_comment', $var_correct, '$var_frbefore', '$var_frafter', '$var_shipacc', '$var_dmg', '$var_scdesc', '$var_osc', $var_score_month, $var_score_quarter, $var_score_r12,$var_assigntask_id";


$sql = "INSERT INTO custaudit.customeraction_comptasks ($columns) VALUES ($values)";
$query = $conn1->prepare($sql);
$query->execute();

//change status on assigned tasks to COMPLETE
$sql2 = "UPDATE customeraction_asgntasks
    SET customeraction_asgntasks_STATUS = 'COMPLETE'
    WHERE idcustomeraction_asgntasks = $var_assigntask_id;";
$query2 = $conn1->prepare($sql2);
$query2->execute();

