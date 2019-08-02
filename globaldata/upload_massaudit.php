<?php

include '../sessioninclude.php';
include_once '../connection/connection_details.php';
$var_userid = strtoupper($_SESSION['MYUSER']);
$usersql = $conn1->prepare("SELECT  customeraudit_users_GROUP FROM custaudit.customeraudit_users WHERE upper(customeraudit_users_ID) =  '$var_userid'");
$usersql->execute();
$userarray = $usersql->fetchAll(pdo::FETCH_ASSOC);
$usergroup = $userarray[0]['customeraudit_users_GROUP'];
$now = date("Y-m-d H:i:s");
$today = date("Y-m-d");
//error formatting
$errorprefix = '<svg class="svg_error" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
  <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
  <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
  <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
</svg>
<p class="svgtext error">';
$errorpostfix = "<p>";

$successprefix = '<svg class="svg_success" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
  <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
  <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
</svg>
<p class="svgtext success">';
$successpostfix = "<p>";

$clearfile = "<script>document.getElementById('fileToUpload').value = null;</script>";
$cleargroupid = "<script>document.getElementById('groupid').value = null;</script>";


//no group ID
if (!isset($_POST['groupid']) || $_POST['groupid'] == '' || is_null($_POST['groupid'])) {
    exit($errorprefix . "Please enter a Group ID." . $errorpostfix);
} else {
    $var_custid = ($_POST['groupid']);
}
$var_custtype = $_POST['grouptype'];

//pull in FR info based of scorecard display table
switch ($var_custtype) {
    case 'SALESPLAN':
        $frsql = "SELECT 
                            BEFFRMNT_EXCLDS,
                            AFTFRMNT_EXCLDS,
                            SHIPACCMONTH,
                            DMGACCMONTH,
                            ADDSCACCMONTH,
                            OSCMONTH_EXCLDS,
                            CAST(SCOREMONTH * 100 AS UNSIGNED) AS SCOREMONTH,
                            CAST(SCOREQUARTER * 100 AS UNSIGNED) AS SCOREQUARTER,
                            CAST(SCOREROLL12 * 100 AS UNSIGNED) AS SCOREROLL12
                        FROM
                            custaudit.scorecard_display_salesplan
                        WHERE
                            SALESPLAN = '$var_custid'";
        break;
    case 'SHIPTO':
        $frsql = "SELECT DISTINCT
                                    BEFFRMNT_EXCLDS,
                                    AFTFRMNT_EXCLDS,
                                    SHIPACCMONTH,
                                    DMGACCMONTH,
                                    ADDSCACCMONTH,
                                    OSCMONTH_EXCLDS,
                                    CAST(SCOREMONTH * 100 AS UNSIGNED) AS SCOREMONTH,
                                    CAST(SCOREQUARTER * 100 AS UNSIGNED) AS SCOREQUARTER,
                                    CAST(SCOREROLL12 * 100 AS UNSIGNED) AS SCOREROLL12
                                FROM
                                    custaudit.scorecard_display_shipto
                                WHERE
                                    SHIPTONUM = '$var_custid'";
        break;
    case 'BILLTO':
        $frsql = "SELECT DISTINCT
                                    BEFFRMNT_EXCLDS,
                                    AFTFRMNT_EXCLDS,
                                    SHIPACCMONTH,
                                    DMGACCMONTH,
                                    ADDSCACCMONTH,
                                    OSCMONTH_EXCLDS,
                                    CAST(SCOREMONTH * 100 AS UNSIGNED) AS SCOREMONTH,
                                    CAST(SCOREQUARTER * 100 AS UNSIGNED) AS SCOREQUARTER,
                                    CAST(SCOREROLL12 * 100 AS UNSIGNED) AS SCOREROLL12
                                FROM
                                    custaudit.scorecard_display_billto
                                WHERE
                                    BILLTONUM = '$var_custid'";
        break;
}

$frsql_exe = $conn1->prepare($frsql);
$frsql_exe->execute();
$fr_array = $frsql_exe->fetchAll(pdo::FETCH_ASSOC);
//is group ID in the FR table?
if (count($fr_array) == 0) {
    exit($errorprefix . $var_custtype . " " . $var_custid . " not found." . $errorpostfix);
}



$target_dir = "../uploads_massaudit/";
//was a file selected to upload
if (array_key_exists('file', $_FILES)) {
    $target_basename = basename($_FILES["file"]["name"]);
} else {
    exit($errorprefix . "Please choose file to upload." . $errorpostfix);
}
//is the file the correct type of .xlsx
$target_file = $target_dir . $target_basename;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
if ($imageFileType <> 'xlsx') {
    exit($errorprefix . "File type must be Excel with extension must be .XLSX" . $errorpostfix . $clearfile);
}

//has the file already been uploaded?  Pull in all uploaded file names for the previous 3 months and compare to new file being uploaded
$docsloaded = $conn1->prepare("SELECT 
    upload_filename
FROM
    custaudit.custaudit_massaudituploads
WHERE
    upload_filename = '$target_basename' and upload_date BETWEEN CURDATE() - INTERVAL 90 DAY AND CURDATE();");
$docsloaded->execute();
$docsloadedarray = $docsloaded->fetchAll(pdo::FETCH_ASSOC);

if (count($docsloadedarray) > 0) {
    exit($errorprefix . "This file has already been loaded.  Please select a different file." . $errorpostfix . $clearfile);
}
//move the file to folder
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

$sheetkey = null;  //initialize as null for error checking
$sheetcolumns = array('SKU', 'STATUS');  //columns needed to insert into customeraction_asgntasks table
$data = array();
$data_auditcomplete = array();
require_once '../../simplexlsx.class.php';

//determine table for fill rate info based on custtype
//hardcoded for example.  Will need to do the parsing by dynamically loading the file based on POST from auditupload.php
if ($xlsx = SimpleXLSX::parse("$target_file")) {
    //what are the available sheets
    $sheetsarray = $xlsx->sheetNames();

    //loop through sheets to find index value of "item detail" sheet
    foreach ($sheetsarray as $key => $sheetname) {
        if (strtoupper($sheetname) == 'ITEM DETAIL') {
            $sheetkey = $key;
            break;
        }
    }

    if (is_null($sheetkey)) { //error handling for no sheet named item detail.
        unlink($target_file);
        exit($errorprefix . "There is not a worksheet named: Item Detail" . $errorpostfix . $clearfile);
    }

    list( $num_cols, $num_rows ) = $xlsx->dimension($sheetkey);

    //Find the key of each relevant column heading.  Need to put in error tracking so can tell if sheet is missing or column is missing.
    $headerrows = 0; //intialize rowcount to determine which row has column headings
    $colindex_SKU = $colindex_STATUS = null; //set the colindex for columns to null.  Once set, loop will be exited.
    foreach ($xlsx->rows($sheetkey) as $r) {
        $headerrows += 1;

        foreach ($r as $colkey => $colname) { //loop through columns on row and determine if SKU or STATUS
            if (is_null($colindex_SKU)) { //is SKU col already set?
                if (strtoupper($colname) == 'SKU') {
                    $colindex_SKU = $colkey;
                }
            }
            if (is_null($colindex_STATUS)) { //is STATUS col already set?
                if (strtoupper($colname) == 'STATUS') {
                    $colindex_STATUS = $colkey;
                }
            }
            if (!is_null($colindex_SKU) && !is_null($colindex_STATUS)) {
                break 2; //break out of loop once all key columns are determined
            }
        }
    }

    if (is_null($colindex_SKU) || is_null($colindex_STATUS)) {
        unlink($target_file);
        exit($errorprefix . 'There is not a column named "Status" and/or "SKU".  Please correct and upload again.' . $errorpostfix . $clearfile);
    }


    //Build data array from start row to last row using key columns and posted data
    foreach ($xlsx->rows($sheetkey) as $r) {
        //deduct one from header row

        if ($headerrows > 0) {
            $headerrows -= 1;
            continue;
        }
        //create data array
//        $comment = mysqli_real_escape_string($conn1, $r[$colindex_STATUS]);
        $data[] = "(0,'$var_userid', '$var_userid', '$now', '$usergroup', $r[$colindex_SKU], '$var_custtype', '$var_custid', '$r[$colindex_STATUS]', 'COMPLETE')";
    }

    //insert into customeraction_asgntasks table
    $values = implode(',', $data);
    $columns_assign = 'idcustomeraction_asgntasks, customeraction_asgntasks_ASGNTSM, customeraction_asgntasks_TOTSM, customeraction_asgntasks_DATE, customeraction_asgntasks_GROUP, customeraction_asgntasks_ITEM, customeraction_asgntasks_CUSTGROUP, customeraction_asgntask_GROUPID, customeraction_asgntasks_COMMENT, customeraction_asgntasks_STATUS ';
    if (!empty($values)) {
        $sql = "INSERT INTO custaudit.customeraction_asgntasks ($columns_assign) VALUES $values";
        $query = $conn1->prepare($sql);
        $query->execute();
    }

    //update the auditcomplete with the just updatedassigned tasks table
    //will have to pull in fill rate info by customer id grouping
    $frbefore = $fr_array[0]['BEFFRMNT_EXCLDS'];
    $frafter = $fr_array[0]['AFTFRMNT_EXCLDS'];
    $shipacc = $fr_array[0]['SHIPACCMONTH'];
    $dmgacc = $fr_array[0]['DMGACCMONTH'];
    $addscacc = $fr_array[0]['ADDSCACCMONTH'];
    $osc = $fr_array[0]['OSCMONTH_EXCLDS'];
    $scoremnt = intval($fr_array[0]['SCOREMONTH']);
    $scoreqtr = intval($fr_array[0]['SCOREQUARTER']);
    $scorerol12 = intval($fr_array[0]['SCOREROLL12']);
    $complete_comment = 'Added through mass audit tool by ' . $var_userid;

    $data_auditcomplete[] = "(0,'$var_userid', '$var_custtype', '$var_custid', '$now', '$frbefore', '$frafter', '$shipacc', '$dmgacc', '$addscacc', '$osc', $scoremnt, $scoreqtr, $scorerol12, '$complete_comment', '$usergroup')";
    $values2 = implode(',', $data_auditcomplete);
    $columns_auditcomplete = 'auditcomplete_id, auditcomplete_user, auditcomplete_custtype, auditcomplete_custid, auditcomplete_date, auditcompletecol_FRBEF, auditcomplete_FRAFT, auditcomplete_SHIPACC, auditcomplete_DMG, auditcomplete_SCDESC, auditcomplete_OSC, auditcomplete_SCOREMNT, auditcomplete_SCOREQTR, auditcomplete_SCORER12, auditcomplete_COMMENT, auditcomplete_USERGROUP';
    if (!empty($values2)) {
        $sql2 = "INSERT INTO custaudit.auditcomplete ($columns_auditcomplete) VALUES $values2";
        $query2 = $conn1->prepare($sql2);
        $query2->execute();
    }
} else {
    echo SimpleXLSX::parse_error();
}

//insert upload data to table custaudit_massaudituploads
$columns = 'upload_custid, upload_custtype, upload_filename, upload_filetype, upload_date, upload_tsm';
$sql = "INSERT INTO custaudit.custaudit_massaudituploads ($columns) VALUES ('$var_custid', '$var_custtype', '$target_basename', '$imageFileType', '$today', '$var_userid');";
$query = $conn1->prepare($sql);
$query->execute();

//clear the group id and file ids
echo $cleargroupid . $clearfile;

//success
echo $successprefix . 'You have successfully audited ' . $var_custtype . ' ' . $var_custid;
