
<?php

include_once '../connection/connection_details.php';
date_default_timezone_set('America/New_York');
$datetime = date('Y-m-d H:i:s');
$customeraction_salesplan_id = 0;

$var_custid = $_POST['salesplan'];
$var_custgroup = strtoupper($_POST['custgroup']);


$var_item = intval($_POST['item']);
$var_tsm = $_POST['userid'];
$var_checkboxim = intval($_POST['checkboxim']);
$var_checkboxdc = intval($_POST['checkboxdc']);
$var_checkboxsc = intval($_POST['checkboxsc']);
$var_checkboxother = intval($_POST['checkboxother']);
$var_assignedtsm_im = $_POST['assignedtsm_im'];
$var_assignedtsm_dc = $_POST['assignedtsm_dc'];
$var_assignedtsm_sc = $_POST['assignedtsm_sc'];
$var_assignedtsm_other = $_POST['assignedtsm_other'];
$var_comment_im = $_POST['comment_im'];
$var_comment_dc = $_POST['comment_dc'];
$var_comment_sc = $_POST['comment_sc'];
$var_comment_other = $_POST['comment_other'];


$var_frbefore = intval(str_replace(array('.', '%'), '', $_POST['fillratebefore_month'])) / 10000;
$var_frafter = intval(str_replace(array('.', '%'), '', $_POST['fillrateafter_month'])) / 10000;
$var_shipacc = intval(str_replace(array('.', '%'), '', $_POST['shipacc_month'])) / 10000;
$var_dmg = intval(str_replace(array('.', '%'), '', $_POST['dmgacc_month'])) / 10000;
$var_scdesc = intval(str_replace(array('.', '%'), '', $_POST['addscacc_month'])) / 10000;
$var_osc = intval(str_replace(array('.', '%'), '', $_POST['osc_month'])) / 10000;

$var_score_month = intval($_POST['score_month']);
$var_score_quarter = intval($_POST['score_quarter']);
$var_score_r12 = intval($_POST['score_r12']);

//$columns = 'customeraction_salesplan_id,customeraction_salesplan_salesplan, customeraction_salesplan_item, customeraction_salesplan_tsm, customeraction_salesplan_oppim, customeraction_salesplan_oppdc, customeraction_salesplan_oppsc, customeraction_salesplan_oppother, customeraction_salesplan_oppim_assgntsm, customeraction_salesplan_oppim_comm, customeraction_salesplan_oppdc_assgntsm, customeraction_salesplan_oppdc_comm, customeraction_salesplan_oppsc_assgntsm, customeraction_salesplan_oppsc_comm, customeraction_salesplan_oppother_assgntsm, customeraction_salesplan_oppother_comm, customeraction_salesplan_datetime, customeraction_salesplan_frbef, customeraction_salesplan_fraft, customeraction_salesplan_shipacc, customeraction_salesplan_dmg, customeraction_salesplan_scdesc, customeraction_salesplan_osc, customeraction_salesplan_score_mnt, customeraction_salesplan_score_qtr, customeraction_salesplan_score_r12';
//$values = "$customeraction_salesplan_id,'$var_custid', $var_item, '$var_tsm', $var_checkboxim, $var_checkboxdc, $var_checkboxsc, $var_checkboxother, '$var_assignedtsm_im','$var_comment_im','$var_assignedtsm_dc','$var_comment_dc','$var_assignedtsm_sc', '$var_comment_sc','$var_assignedtsm_other','$var_comment_other','$datetime','$var_frbefore','$var_frafter','$var_shipacc','$var_dmg','$var_scdesc','$var_osc',$var_score_month,$var_score_quarter, $var_score_r12";
//
//$result1 = $conn1->prepare("INSERT INTO custaudit.customeraction_salesplan ($columns) values ($values)");
//$result1->execute();

$columns_asgntasks = 'idcustomeraction_asgntasks, customeraction_asgntasks_ASGNTSM, customeraction_asgntasks_TOTSM, customeraction_asgntasks_DATE, customeraction_asgntasks_GROUP, customeraction_asgntasks_ITEM, customeraction_asgntasks_CUSTGROUP, customeraction_asgntask_GROUPID, customeraction_asgntasks_COMMENT, customeraction_asgntasks_STATUS';
//loop through checkboxes to determine if anything assigned and write to customeraction_asgntasks table
if ($var_checkboxim == 1) {
    $data[] = "(0,'$var_tsm', '$var_assignedtsm_im', '$datetime', 'IM', '$var_item', '$var_custgroup', '$var_custid', '$var_comment_im', 'OPEN')";
}
if ($var_checkboxdc == 1) {
    $data[] = "(0,'$var_tsm', '$var_assignedtsm_dc', '$datetime', 'DC', '$var_item', '$var_custgroup', '$var_custid', '$var_comment_dc', 'OPEN')";
}
if ($var_checkboxsc == 1) {
    $data[] = "(0,'$var_tsm', '$var_assignedtsm_sc', '$datetime', 'SC', '$var_item', '$var_custgroup', '$var_custid', '$var_comment_sc', 'OPEN')";
}
if ($var_checkboxother == 1) {
    $data[] = "(0,'$var_tsm', '$var_assignedtsm_other', '$datetime', 'OTHER', '$var_item', '$var_custgroup', '$var_custid', '$var_comment_other', 'OPEN')";
}



$values_asgntasks = implode(',', $data);

if (!empty($values_asgntasks)) {
    $sql = "INSERT INTO custaudit.customeraction_asgntasks ($columns_asgntasks) VALUES $values_asgntasks";
    $query = $conn1->prepare($sql);
    $query->execute();
}

