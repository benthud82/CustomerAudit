
<?php
include_once '../../globalincludes/usa_esys.php';
include_once '../connection/connection_details.php';

include '../functions/customer_audit_functions.php';
$jde_num = $_POST['jde_num'];


//Did the order pend?
$sql_pend = $eseriesconn->prepare("SELECT HOHCOD, HORDJ, HORDT, HORDB, HOCDT, HOTENT FROM HSIPDTA71.F4209H WHERE HODOCO = $jde_num ORDER BY HORDJ ASC, HORDT ASC");
$sql_pend->execute();
$array_pend = $sql_pend->fetchAll(pdo::FETCH_ASSOC);
?>
<section class="panel"> 
    <header class="panel-heading title bg bg-danger" style="font-size: 20px"> Order Pends </header> 
    <?php if (sizeof($array_pend) == 0) { ?>
        <div class="panel-body">
            <div class="media"> 
                <span class="pull-left thumb-small m-t-mini"> <i class="fa fa-check-square fa-lg text-default"></i>  </span> 


                <div><a href="#" class="h5">Order did not pend!</a></div> 

            </div> 
        </div>
    <?php } else { ?>


        <ul class="list-group"> 

            <?php
            foreach ($array_pend as $key => $value) {
                $pendcode = $array_pend[$key]['HOHCOD'];
                $reljdate = $array_pend[$key]['HORDJ'];
                $reldate = _1yydddtogregdate($reljdate);
                $reltime = $array_pend[$key]['HORDT'];
                $reltime_formatted = date('H:i:s', strtotime($reltime));
                $relTSM = $array_pend[$key]['HORDB'];
                $pendjdate = $array_pend[$key]['HOCDT'];
                if ($pendjdate == 0 && $key !== 0) {
                    $penddate = _1yydddtogregdate($array_pend[$key - 1]['HORDJ']);
                } else {
                    $penddate = _1yydddtogregdate($pendjdate);
                }
                $pendtime = $array_pend[$key]['HOTENT'];
                if (strlen($pendtime) < 6) {
                    $pendtime = ('0' . $pendtime);
                }
                $pendtime_formatted = date('H:i:s', strtotime($pendtime));
                //lookup pend code in table
                $sql_code = $conn1->prepare("SELECT code_description FROM custaudit.pend_codes WHERE code = '$pendcode'");
                $sql_code->execute();
                $array_code = $sql_code->fetchAll(pdo::FETCH_ASSOC);

                if (empty($array_code)) {
                    $pend_desc = 'N/A';
                } else {
                    $pend_desc = $array_code[0]['code_description'];
                }
                ?>
                <li class="list-group-item" data-toggle="" data-target="#todo-1"> 
                    <div class="media"> 
                        <span class="pull-left thumb-small m-t-mini"> <i class="fa fa-exclamation-triangle fa-lg text-default"></i> </span> 

                        <div class="media-body"> 
                            <div><a href="#" class="h5"><?php echo $pendcode . ' | ' . $pend_desc ?></a></div> 
                            <div><small class=""><?php echo 'Pend Date: ' . $penddate . ' | Pend Time: ' . $pendtime_formatted ?></small> </div>
                            <div> <small class=""><?php echo 'Released Date: ' . $reldate . ' | Released Time: ' . $reltime_formatted ?></small> </div>
                        </div> 
                    </div> 
                </li> 

            <?php } ?>

        </ul> 
    </section> 
<?php } ?>