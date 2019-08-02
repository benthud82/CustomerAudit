
<?php
include_once '../connection/connection_details.php';
date_default_timezone_set('America/New_York');
$datetime = date('Y-m-d');
$var_userid = strtoupper($_POST['userid']);
$var_add_mastername = ($_POST['add_mastername']);
$var_add_masterdesc = ($_POST['add_masterdesc']);

//Determine if new custom group is in scorecard_mastergroupings table
$inmaster = $conn1->prepare("SELECT 
                                                            mastergroupings_GROUPID
                                                        FROM
                                                            custaudit.scorecard_mastergroupings
                                                        WHERE
                                                            mastergroupings_NAME = '$var_add_mastername';");
$inmaster->execute();
$inmaster_array = $inmaster->fetchAll(pdo::FETCH_ASSOC);
$inmaster_count = count($inmaster_array);
if ($inmaster_count > 0) {

    $masterinsertsuccess = 0;
} else {
    //add to scorecard_mastergroupings
    $insertmaster = "INSERT INTO custaudit.scorecard_mastergroupings (mastergroupings_GROUPID, mastergroupings_NAME, mastergroupings_DESCRIPTION, mastergroupings_TSM, mastergroupings_DATECREATED) VALUES (0,'$var_add_mastername', '$var_add_masterdesc','$var_userid', '$datetime' )";
    $queryinsert = $conn1->prepare($insertmaster);
    $queryinsert->execute();

    $masterinsertsuccess = 1;
}


if ($masterinsertsuccess == 1) {
    ?>
    <!-- Progress/Success Modal-->
    <div id="progressmodal_salesplanall" class="modal fade " role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <!--                                <h4 class="modal-title">Mark Salesplan as Audited</h4>-->
                </div>
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
                <div class="h4"  style="text-align: center">Successfully added <?php echo strtoupper($var_add_mastername); ?> as a custom group! </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div id="progressmodal_salesplanall" class="modal fade " role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <!--                                <h4 class="modal-title">Mark Salesplan as Audited</h4>-->
                </div>
                <div class="h4"  style="text-align: center">The group name <?php echo strtoupper($var_add_mastername); ?>has already been used! </div>
            </div>
        </div>
    </div>


    <?php } ?>
<script>  $('#progressmodal_salesplanall').modal('toggle');</script>
