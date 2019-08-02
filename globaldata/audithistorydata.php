
<?php
ini_set('max_execution_time', 99999);

include_once '../connection/connection_details.php';

$groupsel = $_POST['groupsel'];
$groupid = $_POST['groupid'];

switch ($groupsel) {
    case 'salesplan':
        $var_sqlfilter = "SELECT 
                                            auditcomplete_user,
                                            date(auditcomplete_date) as auditcomplete_date,
                                            auditcomplete_custid,
                                            auditcomplete_SCOREMNT,
                                            CAST(SCOREMONTH_EXCLDS * 100 AS UNSIGNED) AS CURSCORE,
                                            ((SCOREMONTH_EXCLDS * 100) - auditcomplete_SCOREMNT) AS SCOREDIFF
                                        FROM
                                            custaudit.auditcomplete
                                                LEFT JOIN
                                            custaudit.scorecard_display_salesplan ON SALESPLAN = auditcomplete_custid
                                        WHERE
                                            auditcomplete_custid = '$groupid'
                                            AND auditcomplete_custtype = 'SALESPLAN'
                                                AND SCOREMONTH IS NOT NULL;";

        $var_sqlitem = "SELECT 
                                        customeraction_asgntasks_ASGNTSM,
                                        customeraction_asgntasks_TOTSM,
                                        date(customeraction_asgntasks_DATE) as customeraction_asgntasks_DATE,
                                        customeraction_asgntasks_ITEM,
                                        customeraction_asgntasks_COMMENT,
                                        customeraction_asgntasks_STATUS
                                    FROM
                                        custaudit.customeraction_asgntasks
                                    WHERE
                                        customeraction_asgntasks_CUSTGROUP = 'SALESPLAN'
                                            AND customeraction_asgntask_GROUPID = '$groupid';";
        break;

    case 'billto':
        $var_sqlfilter = "SELECT DISTINCT
                                        auditcomplete_user,
                                        date(auditcomplete_date) as auditcomplete_date,
                                        auditcomplete_custid,
                                        auditcomplete_SCOREMNT,
                                        CAST(SCOREMONTH_EXCLDS * 100 AS UNSIGNED) AS CURSCORE,
                                        ((SCOREMONTH_EXCLDS * 100) - auditcomplete_SCOREMNT) AS SCOREDIFF
                                    FROM
                                        custaudit.auditcomplete
                                            LEFT JOIN
                                        custaudit.scorecard_display_billto ON BILLTONUM = auditcomplete_custid
                                    WHERE
                                        auditcomplete_custid = '$groupid'
                                            AND auditcomplete_custtype = 'BILLTO'
                                            AND SCOREMONTH IS NOT NULL;";
        
        
        $var_sqlitem = "SELECT 
                                        customeraction_asgntasks_ASGNTSM,
                                        customeraction_asgntasks_TOTSM,
                                        date(customeraction_asgntasks_DATE) as customeraction_asgntasks_DATE,
                                        customeraction_asgntasks_ITEM,
                                        customeraction_asgntasks_COMMENT,
                                        customeraction_asgntasks_STATUS
                                    FROM
                                        custaudit.customeraction_asgntasks
                                    WHERE
                                        customeraction_asgntasks_CUSTGROUP = 'BILLTO'
                                            AND customeraction_asgntask_GROUPID = '$groupid';";
        
        break;

    case 'shipto':
        $var_sqlfilter = "SELECT  DISTINCT
                                            auditcomplete_user,
                                            date(auditcomplete_date) as auditcomplete_date,
                                            auditcomplete_custid,
                                            auditcomplete_SCOREMNT,
                                            CAST(SCOREMONTH_EXCLDS * 100 AS UNSIGNED) AS CURSCORE,
                                            ((SCOREMONTH_EXCLDS * 100) - auditcomplete_SCOREMNT) AS SCOREDIFF
                                        FROM
                                            custaudit.auditcomplete
                                                LEFT JOIN
                                            custaudit.scorecard_display_shipto ON SHIPTONUM = auditcomplete_custid
                                        WHERE
                                            auditcomplete_custid = '$groupid'
                                                AND auditcomplete_custtype = 'SHIPTO'
                                                AND SCOREMONTH IS NOT NULL;";
        
        
        $var_sqlitem = "SELECT 
                                        customeraction_asgntasks_ASGNTSM,
                                        customeraction_asgntasks_TOTSM,
                                        date(customeraction_asgntasks_DATE) as customeraction_asgntasks_DATE,
                                        customeraction_asgntasks_ITEM,
                                        customeraction_asgntasks_COMMENT,
                                        customeraction_asgntasks_STATUS
                                    FROM
                                        custaudit.customeraction_asgntasks
                                    WHERE
                                        customeraction_asgntasks_CUSTGROUP = 'SHIPTO'
                                            AND customeraction_asgntask_GROUPID = '$groupid';";
        
        break;

    default:
        break;
}


$imapact = $conn1->prepare("$var_sqlfilter");
$imapact->execute();
$imapactarray = $imapact->fetchAll(pdo::FETCH_ASSOC);

$itemdata = $conn1->prepare("$var_sqlitem");
$itemdata->execute();
$itemdataarray = $itemdata->fetchAll(pdo::FETCH_ASSOC);
?>


<!--Audit History table-->
<div class="col-sm-12 col-xl-6">
    <section class="panel " id="salesplanwrapper" style="margin-bottom: 50px; margin-top: 20px;"> 
        <header class="panel-heading bg bg-inverse h2">Audit History<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="closesummary"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
        <div id="salesplansummary" class="panel-body" >
            <!--start of div table-->
            <div class="" id="divtablecontainer">
                <div  class='print-1wide'>
                    <div class='widget-content widget-table'  style="position: relative;">
                        <div class='divtable'>
                            <div class='divtableheader'>
                                <div class='divtabletitle width16_66' style="cursor: default">TSM</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Audit Date</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Customer ID</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Score at Audit</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Score Current</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Score Diff.</div>
                            </div>
                            <?php foreach ($imapactarray as $key => $value) { ?>
                                <div class='divtablerow itemdetailexpand'>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo $imapactarray[$key]['auditcomplete_user']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo $imapactarray[$key]['auditcomplete_date']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo $imapactarray[$key]['auditcomplete_custid']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo $imapactarray[$key]['auditcomplete_SCOREMNT']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo $imapactarray[$key]['CURSCORE']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo number_format($imapactarray[$key]['SCOREDIFF'], 2); ?> </div>
                                </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </section>
</div>


<!--Audit history by item for each customer group id table-->
<div class="col-sm-12 col-xl-6">
    <section class="panel " id="salesplanwrapper" style="margin-bottom: 50px; margin-top: 20px;"> 
        <header class="panel-heading bg bg-inverse h2">Item Audit History<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="closeitem"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
        <div id="itemsummary" class="panel-body" >
            <!--start of div table-->
            <div class="" id="divtablecontainer_item">
                <div  class='print-1wide'>
                    <div class='widget-content widget-table'  style="position: relative;">
                        <div class='divtable'>
                            <div class='divtableheader'>
                                <div class='divtabletitle width16_66' style="cursor: default">Assigned By</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Assigned To</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Assigned Date</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Item</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Comment</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Status</div>
                            </div>
                            <?php foreach ($itemdataarray as $key => $value) { ?>
                                <div class='divtablerow itemdetailexpand'>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo $itemdataarray[$key]['customeraction_asgntasks_ASGNTSM']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo $itemdataarray[$key]['customeraction_asgntasks_TOTSM']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo $itemdataarray[$key]['customeraction_asgntasks_DATE']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo $itemdataarray[$key]['customeraction_asgntasks_ITEM']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo $itemdataarray[$key]['customeraction_asgntasks_COMMENT']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo ($itemdataarray[$key]['customeraction_asgntasks_STATUS']); ?> </div>
                                </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </section>
</div>
