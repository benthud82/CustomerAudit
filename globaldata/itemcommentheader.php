<?php
include_once '../connection/connection_details.php';
$var_itemcode = ($_POST['itemcode']);
//Pull in item comments
//pull in item comments from mysql
$itemcommentssql = $conn1->prepare("SELECT 
                                        *
                                    FROM
                                        custaudit.custaudit_itemcomments
                                    JOIN custaudit.customeraudit_users on customeraudit_users_ID = itemcomments_tsm
                                    WHERE
                                        itemcomments_item = $var_itemcode
                                    ORDER BY itemcomments_date DESC;");
$itemcommentssql->execute();
$itemcommentsarray = $itemcommentssql->fetchAll(pdo::FETCH_ASSOC);
$opencount = count($itemcommentsarray);
?>

<!--Comment display panel.  Shows both audit history and item comments-->
<div class="row">
    <!--item comment history-->
    <div class = "col-xl-12 col-lg-12" >
        <!--<section class = "panel portlet-item" style = "opacity: 1;">-->
        <section class="panel " id="section_algorithmresults" style="margin-bottom: 50px; margin-top: 20px;"> 
            <header class = "panel-heading bg-info" style="font-size: 24px;" > Item Comments  <span class="pull-right" style="cursor: pointer; font-size: 16px;" id="addcomment">Add Comment <i class="fa fa-plus-circle"></i></span> </header>
            <section class = "panel-body">

                <?php
                if ($opencount == 0) {
                    echo 'No comments...';
                } else {

                    foreach ($itemcommentsarray as $key => $value) {
                        ?>
                        <article class="media"> 

                                                                                                                                                                                    <!--<span class="btn btn-white btn-xs pull-left"><?php // echo $itemcommentsarray[$key]['itemcomments_tsm'] . " | " . $itemcommentsarray[$key]['slottingDB_users_FIRSTNAME'] . " " . $itemcommentsarray[$key]['slottingDB_users_LASTNAME']                    ?>  </span>--> 
                            <div class="pull-left media-mini text-center text-muted"> 
                                <strong class="h4"><?php echo $itemcommentsarray[$key]['itemcomments_tsm'] . " | " . $itemcommentsarray[$key]['customeraudit_users_FIRSTNAME'] . " " . $itemcommentsarray[$key]['customeraudit_users_LASTNAME'] ?></strong><br> 
                                <small class="label bg-light">Comment TSM</small> 
                            </div> 

                            <div class="media-body"> 
                                <div class="pull-right media-mini text-center text-muted"> 
                                    <strong class="h4"><?php echo $itemcommentsarray[$key]['itemcomments_date']; ?></strong><br> 
                                    <small class="label bg-light">Comment Date</small> 
                                </div> 
                                <a href="#" class="h4"><?php echo $itemcommentsarray[$key]['itemcomments_header']; ?></a> 
                                <small class="block"><?php echo $itemcommentsarray[$key]['itemcomments_comment']; ?></small> 
                            </div> 
                        </article> 
                        <?php if ($key + 1 <> $opencount) { ?>
                            <div class="line pull-in"></div> 
                        <?php } ?>

                        <?php
                    }
                }
                ?>

            </section> 
        </section>
    </div>
    
    <!--Item audit history-->
    
    
</div>