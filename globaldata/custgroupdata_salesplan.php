<?php
include_once '../connection/connection_details.php';
$uppersearchterm = strtoupper($_POST['searchterm']);

$salesplan = $conn1->prepare("SELECT 
                                                                trim(SALESPLAN) as SALESPLAN,
                                                                trim(SALESPLAN_DESC) as SALESPLAN_DESC,
                                                                trim(S.BILLTONUM) as BILLTONUM,
                                                                trim(S.BILLTONAME) as BILLTONAME,
                                                                trim(S.SHIPTONUM) as SHIPTONUM,
                                                                trim(S.SHIPTONAME) as SHIPTONAME
                                                            FROM
                                                                custaudit.salesplan P
                                                                    JOIN
                                                                custaudit.customerscores_shipto S ON P.BILLTO = S.BILLTONUM and P.SHIPTO = S.SHIPTONUM
                                                            WHERE SALESPLAN = '$uppersearchterm'");
$salesplan->execute();
$salesplansearcharray = $salesplan->fetchAll(pdo::FETCH_ASSOC);

$count_salesplan = count($salesplansearcharray);

if ($count_salesplan <= 0) {
    echo 'No Matches';
} else { //show matches 
    ?>
<div class="row" style="padding-bottom: 15px;">
        <div class="col-lg-12 ">
            <div id="salesplan_addall">
                <button id="btn_salesplan_addall" class="bg-info" onclick="addall_salesplan()">Add All Customers </button>
                <button id="btn_salesplan_addselectedl" class="bg-info">Add Selected Customers </button>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-2 col-md-4">
            <div id="salesplan_selectall">
                <button id="btn_salesplan_selectall" class="bg-success"  onclick="selectall_salesplan()">Select All Customers </button>
            </div>
        </div>
        <div class="col-xl-2 col-md-4">
            <div id="salesplan_deselectall">
                <button id="btn_salesplan_selectall" class="bg-danger" onclick="deselectall_salesplan()">De-Select All Customers </button>
            </div>
        </div>
    </div>


    <div class="col-sm-12 col-xl-7">

        <div id="panelbody_salesplanadd" class="panel-body" >
            <!--start of div table-->
            <div class="" id="container_salesplanadd">
                <div  class='print-1wide'>
                    <div class='widget-content widget-table'  style="position: relative;">
                        <div class='divtable' id="addtable_salesplan">
                            <div class='divtableheader'>
                                <div class='divtabletitle width5' style="cursor: default">Add?</div>
                                <div class='divtabletitle width10' style="cursor: default">Sales Plan</div>
                                <div class='divtabletitle width20' style="cursor: default">Sales Plan Name</div>
                                <div class='divtabletitle width10' style="cursor: default">Bill To</div>
                                <div class='divtabletitle width20' style="cursor: default">Bill To Name</div>
                                <div class='divtabletitle width10' style="cursor: default">Ship To</div>
                                <div class='divtabletitle width20' style="cursor: default">Ship To Name</div>
                            </div>
                            <?php foreach ($salesplansearcharray as $key => $value) { ?>
                                <div class='divtablerow'>
                                    <div class='divtabledata width5' style="vertical-align: text-top; cursor: pointer"> <?php echo '<input type="checkbox" class="chkbox_salesplan" value="" checked>' ?> </div>
                                    <div class='divtabledata width10' style="vertical-align: text-top; cursor: pointer"> <?php echo trim($salesplansearcharray[$key]['SALESPLAN']); ?> </div>
                                    <div class='divtabledata width20' style="vertical-align: text-top; cursor: pointer"> <?php echo trim($salesplansearcharray[$key]['SALESPLAN_DESC']); ?> </div>
                                    <div class='divtabledata width10' style="vertical-align: text-top; cursor: pointer"> <?php echo trim($salesplansearcharray[$key]['BILLTONUM']); ?> </div>
                                    <div class='divtabledata width20' style="vertical-align: text-top; cursor: pointer"> <?php echo trim($salesplansearcharray[$key]['BILLTONAME']); ?> </div>
                                    <div class='divtabledata width10' style="vertical-align: text-top; cursor: pointer"> <?php echo trim($salesplansearcharray[$key]['SHIPTONUM']); ?> </div>
                                    <div class='divtabledata width20' style="vertical-align: text-top; cursor: pointer"> <?php echo trim($salesplansearcharray[$key]['SHIPTONAME']); ?> </div>
                                </div>

                                <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>    
            </div>    
        </div>

    </div>

    <?php
}




    