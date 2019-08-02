
<?php
include_once '../connection/connection_details.php';
date_default_timezone_set('America/New_York');
$datetime = date('Y-m-d');
$var_userid = strtoupper($_POST['userid']);
$var_add_mastername =  trim($_POST['add_mastername']);
$var_count = intval($_POST['shiptocount']);
$var_shiptoarray = ($_POST['shiptoarray']);

//get masterid to for detail table
$masteridsql = "SELECT 
                                    mastergroupings_GROUPID
                                FROM
                                    custaudit.scorecard_mastergroupings
                                WHERE
                                    mastergroupings_NAME = '$var_add_mastername';";
$masteridquery = $conn1->prepare($masteridsql);
$masteridquery->execute();
$masteridquery_array = $masteridquery->fetchAll(pdo::FETCH_ASSOC);

$masterid = intval($masteridquery_array[0]['mastergroupings_GROUPID']);


$values = array();


$maxrange = 4999;
$counter = 0;
$rowcount = count($var_shiptoarray);

$columns = "group_ID, group_MASTERID, group_SALESPLAN, group_BILLTO, group_SHIPTO";

do {
    if ($maxrange > $rowcount) {  //prevent undefined offset
        $maxrange = $rowcount - 1;
    }

    $data = array();
    $values = array();
    while ($counter <= $maxrange) { //split into 10,000 lines segments to insert into merge table
        $salesplan = ($var_shiptoarray[$counter][0]);
        $billto = intval($var_shiptoarray[$counter][1]);
        $shipto = intval($var_shiptoarray[$counter][2]);



        $data[] = "(0, $masterid, '$salesplan', $billto,  $shipto)";
        $counter += 1;
    }
    $values = implode(',', $data);

    if (empty($values)) {
        break;
    }
    $sql = "INSERT IGNORE INTO custaudit.scorecard_groupingdetail ($columns) VALUES $values";
    $query = $conn1->prepare($sql);
    $query->execute();
    $maxrange += 5000;
} while ($counter <= $rowcount);


$detailinsertsuccess = 1;
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
            <div class="h4" style="text-align: center; padding-bottom: 30px">Successfully added <?php echo $rowcount . ' records to the ' . strtoupper($var_add_mastername) . ' custom group!'; ?> </div>
        </div>
    </div>
</div>
<script>
    $('#progressmodal_salesplanall').modal('toggle');
</script>