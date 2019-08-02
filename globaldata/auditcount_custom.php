<?php
include_once '../connection/connection_details.php';
$var_customnumber = intval($_POST['customnumber']);


$auditcountsql = $conn1->prepare("SELECT 
                                                                COUNT(*) as auditcount
                                                            FROM
                                                                custaudit.auditcomplete
                                                            WHERE
                                                                auditcomplete_custtype = 'CUSTOMGROUP'
                                                                    AND auditcomplete_custid = $var_customnumber
                                                                    AND auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY); ");
$auditcountsql->execute();
$auditcountarray = $auditcountsql->fetchAll(pdo::FETCH_ASSOC);

$auditcount = $auditcountarray[0]['auditcount'];

if ($auditcount > 0) {
    ?>
    <div class="row">
        <div  id="auditcompleterow">
            <div class=" col-md-12 col-lg-2">
                <button id="auditcomplete" type="button" class="btn btn-danger" onclick="showauditcompletemodal();" style="margin-bottom: 15px;"disabled=""><i class="fa fa-check" ></i> Recently Audited</button>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="alert alert-info "><h5><i class='fa fa-info-circle fa-lg'></i> This Sales Plan has been audited in the last 90 days.  <a href="audithistory.php?customgroup=<?php echo $var_customnumber; ?> " target="_blank"> Click to view history <i class='fa fa-external-link'></i>  </a> </h5></div>
            </div>
        </div>
    </div>

<?php } else {
    ?>
    <div class="row">
        <div  id="auditcompleterow">
            <div class=" col-md-12 col-lg-2">
                <button id="auditcomplete" type="button" class="btn btn-danger" onclick="showauditcompletemodal();" style="margin-bottom: 15px;"><i class="fa fa-check" ></i> Mark as Audited</button>
            </div>
        </div>
    </div>

    <?php
}


