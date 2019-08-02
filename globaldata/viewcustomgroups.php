
<?php
ini_set('max_execution_time', 99999);

include_once '../connection/connection_details.php';

$userid = strtoupper($_POST['userid']);


$var_sqlmygroups = "SELECT mastergroupings_GROUPID, mastergroupings_NAME, mastergroupings_DESCRIPTION, mastergroupings_TSM, mastergroupings_DATECREATED FROM custaudit.scorecard_mastergroupings WHERE UPPER(mastergroupings_TSM) = '$userid' ORDER BY mastergroupings_DATECREATED DESC";

$mygroups = $conn1->prepare("$var_sqlmygroups");
$mygroups->execute();
$mygroups_array = $mygroups->fetchAll(pdo::FETCH_ASSOC);


$var_sqlothergroups = "SELECT mastergroupings_NAME, mastergroupings_DESCRIPTION, mastergroupings_TSM, mastergroupings_DATECREATED FROM custaudit.scorecard_mastergroupings WHERE UPPER(mastergroupings_TSM) <> '$userid' ORDER BY mastergroupings_DATECREATED DESC";

$othergroups = $conn1->prepare("$var_sqlothergroups");
$othergroups->execute();
$othergroups_array = $othergroups->fetchAll(pdo::FETCH_ASSOC);
?>


<!--My Groups  Table-->
<div class="col-sm-12 col-xl-6">
    <section class="panel " id="section_mygroups" style="margin-bottom: 50px; margin-top: 20px;"> 
        <header class="panel-heading bg bg-inverse h2">My Custom Groups</header>
        <div id="panelbody_mygroups" class="panel-body" >
            <!--start of div table-->
            <div class="" id="container_mygroups">
                <div  class='print-1wide'>
                    <div class='widget-content widget-table'  style="position: relative;">
                        <div class='divtable'>
                            <div class='divtableheader'>
                                <div class='divtabletitle width16_66' style="cursor: default">Group Name</div>
                                <div class='divtabletitle width50' style="cursor: default">Group Description</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Created TSM</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Created Date</div>
                            </div>
                            <?php foreach ($mygroups_array as $key => $value) { ?>
                                <div class='divtablerow'>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top; cursor: pointer"> <?php echo $mygroups_array[$key]['mastergroupings_NAME']; ?> </div>
                                    <div class='divtabledata width50' style="vertical-align: text-top;  cursor: pointer"> <?php echo $mygroups_array[$key]['mastergroupings_DESCRIPTION']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;  cursor: pointer"> <?php echo $mygroups_array[$key]['mastergroupings_TSM']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;  cursor: pointer"> <?php echo $mygroups_array[$key]['mastergroupings_DATECREATED']; ?> </div>

                                </div>
                                <?php
                                //pull in detail for given customer ID
                                $masterid = intval($mygroups_array[$key]['mastergroupings_GROUPID']);
                                $var_sqlmygroupdetail = "SELECT 
                                                                                group_SALESPLAN,
                                                                                SALESPLAN_DESC,
                                                                                BILLTO,
                                                                                S.BILLTONAME,
                                                                                S.SHIPTONUM,
                                                                                S.SHIPTONAME
                                                                            FROM
                                                                                custaudit.scorecard_groupingdetail
                                                                                    JOIN
                                                                                custaudit.salesplan ON SALESPLAN = group_SALESPLAN
                                                                                    AND BILLTO = group_BILLTO
                                                                                    AND SHIPTO = group_SHIPTO
                                                                                    JOIN
                                                                                custaudit.customerscores_shipto S ON S.SHIPTONUM = group_SHIPTO
                                                                            WHERE group_MASTERID = $masterid";

                                $mygroupsdetail = $conn1->prepare("$var_sqlmygroupdetail");
                                $mygroupsdetail->execute();
                                $mygroupsdetailarray = $mygroupsdetail->fetchAll(pdo::FETCH_ASSOC);
                                ?>


                                <!--hidden data, slide toggle to view-->
                                <div class="divtablehidden"  style='display: none; cursor: default'>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="pull-left" style="margin-left: 15px" >
                                                <button id="<?php echo $mygroups_array[$key]['mastergroupings_GROUPID'] ?>" type="button" class="btn btn-danger deletecustomgroup" style="margin: 25px;">Delete Custom Group</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='divtableheader'>
                                        <div class='divtabletitle width10' style="cursor: default">Sales Plan</div>
                                        <div class='divtabletitle width23_33' style="cursor: default">Sales Plan Name</div>
                                        <div class='divtabletitle width10' style="cursor: default">Bill To</div>
                                        <div class='divtabletitle width23_33' style="cursor: default">Bill To Name</div>
                                        <div class='divtabletitle width10' style="cursor: default">Ship To</div>
                                        <div class='divtabletitle width23_33' style="cursor: default">Ship To Name</div>
                                    </div>
                                    <?php
                                    foreach ($mygroupsdetailarray as $key2 => $value) {
                                        ?>




                                        <div class='divtablerow '>
                                            <div class='divtabledata width10' style="vertical-align: text-top; "> <?php echo $mygroupsdetailarray[$key2]['group_SALESPLAN']; ?> </div>
                                            <div class='divtabledata width23_33' style="vertical-align: text-top;"> <?php echo $mygroupsdetailarray[$key2]['SALESPLAN_DESC']; ?> </div>
                                            <div class='divtabledata width10' style="vertical-align: text-top; "> <?php echo $mygroupsdetailarray[$key2]['BILLTO']; ?> </div>
                                            <div class='divtabledata width23_33' style="vertical-align: text-top;"> <?php echo $mygroupsdetailarray[$key2]['BILLTONAME']; ?> </div>
                                            <div class='divtabledata width10' style="vertical-align: text-top; "> <?php echo $mygroupsdetailarray[$key2]['SHIPTONUM']; ?> </div>
                                            <div class='divtabledata width23_33' style="vertical-align: text-top; "> <?php echo $mygroupsdetailarray[$key2]['SHIPTONAME']; ?> </div>
                                        </div>
                                    <?php } ?>
                                </div> 
                                <!--end of hidden data-->

                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </section>
</div>

<!--Other Groups  Table-->
<div class="col-sm-12 col-xl-6">
    <section class="panel " id="section_othergroups" style="margin-bottom: 50px; margin-top: 20px;"> 
        <header class="panel-heading bg bg-inverse h2">Other Custom Groups</header>
        <div id="panelbody_othergroups" class="panel-body" >
            <!--start of div table-->
            <div class="" id="container_othergroups">
                <div  class='print-1wide'>
                    <div class='widget-content widget-table'  style="position: relative;">
                        <div class='divtable'>
                            <div class='divtableheader'>
                                <div class='divtabletitle width16_66' style="cursor: default">Group Name</div>
                                <div class='divtabletitle width50' style="cursor: default">Group Description</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Created TSM</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Created Date</div>
                            </div>
                            <?php foreach ($othergroups_array as $key => $value) { ?>
                                <div class='divtablerow itemdetailexpand'>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;  cursor: pointer"> <?php echo $othergroups_array[$key]['mastergroupings_NAME']; ?> </div>
                                    <div class='divtabledata width50' style="vertical-align: text-top;  cursor: pointer"> <?php echo $othergroups_array[$key]['mastergroupings_DESCRIPTION']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;  cursor: pointer"> <?php echo $othergroups_array[$key]['mastergroupings_TSM']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;  cursor: pointer"> <?php echo $othergroups_array[$key]['mastergroupings_DATECREATED']; ?> </div>

                                </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </section>
</div>

