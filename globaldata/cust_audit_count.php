<?php
include_once 'connection/connection_details.php';
//include_once '../globalfunctions/custdbfunctions.php';

//top 3 salesplans score history increase/decrease
$sql_custauditcount = $conn1->prepare("SELECT 
                                            auditcomplete_custtype, COUNT(*) AS AUDIT_COUNT
                                        FROM
                                            custaudit.auditcomplete
                                        WHERE
                                            auditcomplete_date >= DATE_ADD(CURDATE(), INTERVAL - 90 DAY)
                                        GROUP BY auditcomplete_custtype");
$sql_custauditcount->execute();
$array_custauditcount = $sql_custauditcount->fetchAll(pdo::FETCH_ASSOC);

$sql_itemauditcount = $conn1->prepare("SELECT 
                                            COUNT(DISTINCT customeraction_asgntasks_ITEM) AS ITEM_COUNT
                                        FROM
                                            custaudit.customeraction_asgntasks
                                        WHERE
                                            customeraction_asgntasks_DATE >= DATE_ADD(CURDATE(), INTERVAL - 90 DAY)
                                                AND customeraction_asgntasks_STATUS = 'COMPLETE'");
$sql_itemauditcount->execute();
$array_itemauditcount = $sql_itemauditcount->fetchAll(pdo::FETCH_ASSOC);
?>
<div class="row">
    <?php foreach ($array_custauditcount as $key => $value) { ?>
        <div class="col-xs-3 text-center">
            <div class="ticket-counter">
                <h4><?php echo $array_custauditcount[$key]['AUDIT_COUNT'] ?></h4>
                <p class="label label-md label-info bold uppercase"><?php echo $array_custauditcount[$key]['auditcomplete_custtype'] ?></p>
            </div>
        </div> 
    <?php } ?>

    <div class="col-xs-3 text-center">
        <div class="ticket-counter">
            <h4><?php echo $array_itemauditcount[0]['ITEM_COUNT'] ?></h4>
            <p class="label label-md label-default bold uppercase ">ITEMS</p>
        </div>
    </div>
</div>
