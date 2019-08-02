<?php
include_once '../connection/connection_details.php';
$groupid = strtoupper($_POST['groupid']);
$loaddata_searchterm = strtoupper($_POST['loaddata_searchterm']);
$var_userid = strtoupper($_POST['userid']);


switch ($groupid) {
    case 'SALESPLAN':
        $loaddatasql = $conn1->prepare("SELECT 
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
                                                            WHERE SALESPLAN = '$loaddata_searchterm'");
        break;

    case 'BILLTO':
        $loaddatasql = $conn1->prepare("SELECT 
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
                                                            WHERE BILLTO = '$loaddata_searchterm'");
        break;

    case 'SHIPTO':
        $loaddatasql = $conn1->prepare("SELECT 
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
                                                            WHERE SHIPTO = '$loaddata_searchterm'");
        break;

    case 'SEARCH':
        $loaddatasql = $conn1->prepare("SELECT 
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
                                                            WHERE SALESPLAN like '%$loaddata_searchterm%' or SALESPLAN_DESC  like '%$loaddata_searchterm%' or BILLTONUM  like '%$loaddata_searchterm%'  or BILLTONAME  like '%$loaddata_searchterm%'  or SHIPTONUM  like '%$loaddata_searchterm%'  or SHIPTONAME  like '%$loaddata_searchterm%'  ");
        break;

    default:
        break;
}



$loaddatasql->execute();
$loaddataarray = $loaddatasql->fetchAll(pdo::FETCH_ASSOC);

$count_loaddataarray = count($loaddataarray);


$customgroupsql = $conn1->prepare("SELECT DISTINCT
                                                                        mastergroupings_NAME
                                                                    FROM
                                                                        custaudit.scorecard_mastergroupings
                                                                    WHERE
                                                                        UPPER(mastergroupings_TSM) = '$var_userid' ORDER BY mastergroupings_NAME asc;");
$customgroupsql->execute();
$customgrouparray = $customgroupsql->fetchAll(pdo::FETCH_ASSOC);


if ($count_loaddataarray <= 0) {
    echo 'No Matches';
} else { //show matches 
    ?>

        <div class="row" style="padding-bottom: 15px;">
            <div class="col-lg-12 ">
                <div class="pull-left">
                    <label>Custom  Group</label>

                    <select class="selectstyle" id="groupsel" name="groupsel" style="width: 175px;padding: 5px; margin-right: 10px;">
                        <?php foreach ($customgrouparray as $key => $value) {
                            ?>  <option value="<?= $customgrouparray[$key]['mastergroupings_NAME']; ?>"><?php echo $customgrouparray[$key]['mastergroupings_NAME']; ?></option>
                        <?php } ?>

                    </select>





                </div>
                <div id="salesplan_addall">
                    <button id="btn_salesplan_addselectedl" class="btn btn-inverse">Add Selected Customers </button>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <button id="btn_salesplan_selectall" class="bg-success"  onclick="selectall_salesplan()">Select All Customers </button>
                <button id="btn_salesplan_selectall" class="bg-danger" onclick="deselectall_salesplan()">De-Select All Customers </button>
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
                                <?php foreach ($loaddataarray as $key => $value) { ?>
                                    <div class='divtablerow'>
                                        <div  id="<?php echo trim($loaddataarray[$key]['SHIPTONUM']); ?>"class='divtabledata width5' style="vertical-align: text-top; cursor: pointer"> <input type="checkbox" class="chkbox_salesplan" name="checkbox"  id="<?php echo trim($loaddataarray[$key]['SHIPTONUM']); ?>"/></div>
                                        <div class='divtabledata width10 checked_salesplan' style="vertical-align: text-top; cursor: pointer"> <?php echo trim($loaddataarray[$key]['SALESPLAN']); ?> </div>
                                        <div class='divtabledata width20' style="vertical-align: text-top; cursor: pointer"> <?php echo trim($loaddataarray[$key]['SALESPLAN_DESC']); ?> </div>
                                        <div class='divtabledata width10 checked_billto' style="vertical-align: text-top; cursor: pointer"> <?php echo trim($loaddataarray[$key]['BILLTONUM']); ?> </div>
                                        <div class='divtabledata width20' style="vertical-align: text-top; cursor: pointer"> <?php echo trim($loaddataarray[$key]['BILLTONAME']); ?> </div>
                                        <div class='divtabledata width10 checked_shipto' style="vertical-align: text-top; cursor: pointer"> <?php echo trim($loaddataarray[$key]['SHIPTONUM']); ?> </div>
                                        <div class='divtabledata width20' style="vertical-align: text-top; cursor: pointer"> <?php echo trim($loaddataarray[$key]['SHIPTONAME']); ?> </div>
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




    