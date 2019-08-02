<?php
include_once '../connection/connection_details.php';
$var_itemcode = ($_POST['itemcode']);
//Pull in item comments
//pull in item comments from mysql
$itemauditsql = $conn1->prepare("SELECT 
    customeraction_asgntasks_ASGNTSM,
    customeraction_asgntasks_TOTSM,
    DATE(customeraction_asgntasks_DATE) AS customeraction_asgntasks_DATE,
    customeraction_asgntasks_ITEM,
    customeraction_asgntasks_COMMENT,
    customeraction_asgntasks_STATUS,
    customeraction_comptasks_COMPDATE,
    customeraction_comptasks_COMMENT
FROM
    custaudit.customeraction_asgntasks
        LEFT JOIN
    custaudit.customeraction_comptasks ON assign_task_ID = idcustomeraction_asgntasks
    WHERE customeraction_asgntasks_ITEM = $var_itemcode
        ORDER BY (customeraction_asgntasks_DATE) DESC");
$itemauditsql->execute();
$itemauditsqlarray = $itemauditsql->fetchAll(pdo::FETCH_ASSOC);
$auditcount = count($itemauditsqlarray);
?>
  <div class="hidewrapper">
<!--Audit history by item for each customer group id table-->
<div class="row">
    <div class="col-sm-12 col-xl-12">
        <section class="panel " id="salesplanwrapper" style="margin-bottom: 50px; margin-top: 20px;"> 
            <header class="panel-heading bg bg-inverse h2">Item Audit History<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="closeitem"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
            <div id="itemsummary" class="panel-body" >
                <?php
                if ($auditcount == 0) {
                    echo 'No audits...';
                } else {
                    ?>

                    <!--start of div table-->
                    <div class="" id="divtablecontainer_item">
                        <div  class='print-1wide'>
                            <div class='widget-content widget-table'  style="position: relative;">
                                <div class='divtable'>
                                    <div class='divtableheader'>
                                        <div class='divtabletitle width12_5' style="cursor: default">Assigned By</div>
                                        <div class='divtabletitle width12_5' style="cursor: default">Assigned To</div>
                                        <div class='divtabletitle width12_5' style="cursor: default">Assigned Date</div>
                                        <div class='divtabletitle width12_5' style="cursor: default">Item</div>
                                        <div class='divtabletitle width12_5' style="cursor: default">Comment</div>
                                        <div class='divtabletitle width12_5' style="cursor: default">Status</div>
                                        <div class='divtabletitle width12_5' style="cursor: default">Complete Date</div>
                                        <div class='divtabletitle width12_5' style="cursor: default">Complete Comment</div>
                                    </div>
                                    <?php foreach ($itemauditsqlarray as $key => $value) { ?>
                                        <div class='divtablerow itemdetailexpand'>
                                            <div class='divtabledata width12_5' style="vertical-align: text-top;"> <?php echo $itemauditsqlarray[$key]['customeraction_asgntasks_ASGNTSM']; ?> </div>
                                            <div class='divtabledata width12_5' style="vertical-align: text-top;"> <?php echo $itemauditsqlarray[$key]['customeraction_asgntasks_TOTSM']; ?> </div>
                                            <div class='divtabledata width12_5' style="vertical-align: text-top;"> <?php echo $itemauditsqlarray[$key]['customeraction_asgntasks_DATE']; ?> </div>
                                            <div class='divtabledata width12_5' style="vertical-align: text-top;"> <?php echo $itemauditsqlarray[$key]['customeraction_asgntasks_ITEM']; ?> </div>
                                            <div class='divtabledata width12_5' style="vertical-align: text-top;"> <?php echo $itemauditsqlarray[$key]['customeraction_asgntasks_COMMENT']; ?> </div>
                                            <div class='divtabledata width12_5' style="vertical-align: text-top;"> <?php echo ($itemauditsqlarray[$key]['customeraction_asgntasks_STATUS']); ?> </div>
                                            <div class='divtabledata width12_5' style="vertical-align: text-top;"> <?php echo ($itemauditsqlarray[$key]['customeraction_comptasks_COMPDATE']); ?> </div>
                                            <div class='divtabledata width12_5' style="vertical-align: text-top;"> <?php echo ($itemauditsqlarray[$key]['customeraction_comptasks_COMMENT']); ?> </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>    
                    </div>    



                    <?php
                }
                ?>
            </div>
        </section>
    </div>
    </div>
</div>