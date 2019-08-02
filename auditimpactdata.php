
<?php
ini_set('max_execution_time', 99999);

include_once '../connection/connection_details.php';

//$var_userid = $_POST['userid'];
$var_userid = strtoupper($_POST['userid']);

//find group
$mygroup = $conn1->prepare("SELECT customeraudit_users_GROUP
                            FROM custaudit.customeraudit_users
                            WHERE UPPER(customeraudit_users_ID = '$var_userid')");
$mygroup->execute();
$mygrouparray = $mygroup->fetchAll(pdo::FETCH_ASSOC);
$mygroupdata = $mygrouparray[0]['customeraudit_users_GROUP'];

$var_clickedid = $_POST['clickedid'];

switch ($var_clickedid) {
    case 'help_sp_me':
        $var_sqlfilter = "SELECT 
                            auditcomplete_user,
                            auditcomplete_date,
                            auditcomplete_custid,
                            auditcomplete_SCOREMNT,
                            cast(SCOREMONTH * 100 as UNSIGNED) as CURSCORE,
                            ((SCOREMONTH * 100) - auditcomplete_SCOREMNT) as SCOREDIFF
                        FROM
                            custaudit.auditcomplete
                                LEFT JOIN
                            custaudit.scorecard_display_salesplan ON SALESPLAN = auditcomplete_custid
                        WHERE
                            auditcomplete_custtype = 'SALESPLAN'
                                and auditcomplete_user = '$var_userid'
                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY)
                                and SCOREMONTH is not NULL;";
        break;
    case 'help_bt_me':
        $var_sqlfilter = "SELECT 
                            auditcomplete_user,
                            auditcomplete_date,
                            auditcomplete_custid,
                            auditcomplete_SCOREMNT,
                            cast(SCOREMONTH * 100 as UNSIGNED) as CURSCORE,
                            ((SCOREMONTH * 100) - auditcomplete_SCOREMNT) as SCOREDIFF
                        FROM
                            custaudit.auditcomplete
                                LEFT JOIN
                            custaudit.scorecard_display_billto ON BILLTONUM = auditcomplete_custid
                        WHERE
                            auditcomplete_custtype = 'BILLTO'
                                and auditcomplete_user = '$var_userid'
                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY)
                                and SCOREMONTH is not NULL;";
        break;
    case 'help_st_me':
        $var_sqlfilter = "SELECT 
                            auditcomplete_user,
                            auditcomplete_date,
                            auditcomplete_custid,
                            auditcomplete_SCOREMNT,
                            cast(SCOREMONTH * 100 as UNSIGNED) as CURSCORE,
                            ((SCOREMONTH * 100) - auditcomplete_SCOREMNT) as SCOREDIFF
                        FROM
                            custaudit.auditcomplete
                                LEFT JOIN
                            custaudit.scorecard_display_shipto ON SHIPTONUM = auditcomplete_custid
                        WHERE
                            auditcomplete_custtype = 'SHIPTO'
                                and auditcomplete_user = '$var_userid'
                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY)
                                and SCOREMONTH is not NULL;";
        break;
    case 'help_sp_group':
        $var_sqlfilter = "SELECT 
                            auditcomplete_user,
                            auditcomplete_date,
                            auditcomplete_custid,
                            auditcomplete_SCOREMNT,
                            cast(SCOREMONTH * 100 as UNSIGNED) as CURSCORE,
                            ((SCOREMONTH * 100) - auditcomplete_SCOREMNT) as SCOREDIFF
                        FROM
                            custaudit.auditcomplete
                                LEFT JOIN
                            custaudit.scorecard_display_salesplan ON SALESPLAN = auditcomplete_custid
                        WHERE
                            auditcomplete_custtype = 'SALESPLAN'
                                and auditcomplete_USERGROUP = '$mygroupdata'
                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY)
                                and SCOREMONTH is not NULL;";
        break;
    case 'help_bt_group':
        $var_sqlfilter = "SELECT 
                            auditcomplete_user,
                            auditcomplete_date,
                            auditcomplete_custid,
                            auditcomplete_SCOREMNT,
                            cast(SCOREMONTH * 100 as UNSIGNED) as CURSCORE,
                            ((SCOREMONTH * 100) - auditcomplete_SCOREMNT) as SCOREDIFF
                        FROM
                            custaudit.auditcomplete
                                LEFT JOIN
                            custaudit.scorecard_display_billto ON BILLTONUM = auditcomplete_custid
                        WHERE
                            auditcomplete_custtype = 'BILLTO'
                                and auditcomplete_USERGROUP = '$mygroupdata'
                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY)
                                and SCOREMONTH is not NULL;";
        break;
    case 'help_st_group':
        $var_sqlfilter = "SELECT 
                            auditcomplete_user,
                            auditcomplete_date,
                            auditcomplete_custid,
                            auditcomplete_SCOREMNT,
                            cast(SCOREMONTH * 100 as UNSIGNED) as CURSCORE,
                            ((SCOREMONTH * 100) - auditcomplete_SCOREMNT) as SCOREDIFF
                        FROM
                            custaudit.auditcomplete
                                LEFT JOIN
                            custaudit.scorecard_display_shipto ON SHIPTONUM = auditcomplete_custid
                        WHERE
                            auditcomplete_custtype = 'SHIPTO'
                                and auditcomplete_USERGROUP = '$mygroupdata'
                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY)
                                and SCOREMONTH is not NULL;";
        break;
    case 'help_sp_all':
        $var_sqlfilter = "SELECT 
                            auditcomplete_user,
                            auditcomplete_date,
                            auditcomplete_custid,
                            auditcomplete_SCOREMNT,
                            cast(SCOREMONTH * 100 as UNSIGNED) as CURSCORE,
                            ((SCOREMONTH * 100) - auditcomplete_SCOREMNT) as SCOREDIFF
                        FROM
                            custaudit.auditcomplete
                                LEFT JOIN
                            custaudit.scorecard_display_salesplan ON SALESPLAN = auditcomplete_custid
                        WHERE
                            auditcomplete_custtype = 'SALESPLAN'
                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY)
                                and SCOREMONTH is not NULL;";
        break;
    case 'help_bt_all':
        $var_sqlfilter = "SELECT 
                            auditcomplete_user,
                            auditcomplete_date,
                            auditcomplete_custid,
                            auditcomplete_SCOREMNT,
                            cast(SCOREMONTH * 100 as UNSIGNED) as CURSCORE,
                            ((SCOREMONTH * 100) - auditcomplete_SCOREMNT) as SCOREDIFF
                        FROM
                            custaudit.auditcomplete
                                LEFT JOIN
                            custaudit.scorecard_display_billto ON BILLTONUM = auditcomplete_custid
                        WHERE
                            auditcomplete_custtype = 'BILLTO'
                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY)
                                and SCOREMONTH is not NULL;";
        break;
    case 'help_st_all':
        $var_sqlfilter = "SELECT 
                            auditcomplete_user,
                            auditcomplete_date,
                            auditcomplete_custid,
                            auditcomplete_SCOREMNT,
                            cast(SCOREMONTH * 100 as UNSIGNED) as CURSCORE,
                            ((SCOREMONTH * 100) - auditcomplete_SCOREMNT) as SCOREDIFF
                        FROM
                            custaudit.auditcomplete
                                LEFT JOIN
                            custaudit.scorecard_display_shipto ON SHIPTONUM = auditcomplete_custid
                        WHERE
                            auditcomplete_custtype = 'SHIPTO'
                                and auditcomplete_date >= DATE_SUB(NOW(), INTERVAL 90 DAY)
                                and SCOREMONTH is not NULL;";
        break;
    default:
        break;
}


$imapact = $conn1->prepare("$var_sqlfilter");
$imapact->execute();
$imapactarray = $imapact->fetchAll(pdo::FETCH_ASSOC);
?>


<!--start of div table-->
<div class="" id="divtablecontainer">
    <div  class='col-sm-12 col-md-12 col-lg-12 print-1wide'  style="float: none;">

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
                        <div class='divtabledata width16_66'> <?php echo $imapactarray[$key]['auditcomplete_user']; ?> </div>
                        <div class='divtabledata width16_66'> <?php echo $imapactarray[$key]['auditcomplete_date']; ?> </div>
                        <div class='divtabledata width16_66'> <?php echo $imapactarray[$key]['auditcomplete_custid']; ?> </div>
                        <div class='divtabledata width16_66'> <?php echo $imapactarray[$key]['auditcomplete_SCOREMNT']; ?> </div>
                        <div class='divtabledata width16_66'> <?php echo $imapactarray[$key]['CURSCORE']; ?> </div>
                        <div class='divtabledata width16_66'> <?php echo intval($imapactarray[$key]['SCOREDIFF']); ?> </div>
                    </div>

                <?php } ?>
            </div>
        </div>

    </div>    
</div>    

