
<?php
include_once '../../globalincludes/usa_asys.php';
include_once '../functions/customer_audit_functions.php';
$jde_num = $_POST['jde_num'];

$sql_wcsinv = $aseriesconn->prepare("SELECT DISTINCT PBWCS# as WCSNUM, PBWKNO FROM HSIPCORDTA.NOTWPS WHERE PBDOCO = $jde_num ORDER BY PBWCS#, PBWKNO");
$sql_wcsinv->execute();
$array_wcsinv = $sql_wcsinv->fetchAll(pdo::FETCH_ASSOC);
?>

<?php
foreach ($array_wcsinv as $keyinv => $value) {
    $wcsnum = $array_wcsinv[$keyinv]['WCSNUM'];
    $womnum = $array_wcsinv[$keyinv]['PBWKNO'];

    //get box numbers
    $sql_wcsboxnum = $aseriesconn->prepare("SELECT PBBOX# as BOXNUM FROM HSIPCORDTA.NOTWPS WHERE PBWCS# = $wcsnum and PBWKNO = $womnum");
    $sql_wcsboxnum->execute();
    $array_wcsboxnum = $sql_wcsboxnum->fetchAll(pdo::FETCH_ASSOC);
    $boxcount = sizeof($array_wcsboxnum);
    ?>
    <section class="panel">
        <header class="panel-heading bg bg-inverse h5">WCS#:<?php echo ' ' . $wcsnum . '-' . $womnum; ?>  <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_scoreavg"></i><i class="fa fa-chevron-down pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>

        <?php
        //loop through box numbers to get box detail
        foreach ($array_wcsboxnum as $keyboxnum => $value) {
            $boxnum = $array_wcsboxnum[$keyboxnum]['BOXNUM'];
            $sql_wcsbox = $aseriesconn->prepare("SELECT PBWHSE, PBBOX# as PBBOX, PBCART, PBSHPC, PBRCJD, PBRCHM, PBPTJD, PBPTHM, PBRLJD, PBRLHM, PBBXSZ, PBLP9D, PBTRC# as TRACER, PBBOXL FROM HSIPCORDTA.NOTWPS WHERE PBWCS# = $wcsnum and PBWKNO = $womnum and PBBOX# = $boxnum");
            $sql_wcsbox->execute();
            $array_wcsbox = $sql_wcsbox->fetchAll(pdo::FETCH_ASSOC);


            $sql_wcsboxlines = $aseriesconn->prepare("SELECT PDPCKL, PDITEM, IMDESC, PDLOC#, PDPKGU, PDPCKS FROM HSIPCORDTA.NOTWPT JOIN HSIPCORDTA.NPFIMS on PDITEM = IMITEM WHERE PDWCS# = $wcsnum and PDWKNO = $womnum and PDBOX# = $boxnum");
            $sql_wcsboxlines->execute();
            $array_wcsboxlines = $sql_wcsboxlines->fetchAll(pdo::FETCH_ASSOC);



            foreach ($array_wcsbox as $keybox => $value) {
                ?>

                <div class="panel-body" style="">
                    <div class="well">
                        <h3>Box#: <?php echo $array_wcsbox[$keybox]['PBBOX'] . ' (of ' . $boxcount . ')'; ?></h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <h4>Box Level Data</h4>
                                <div class="line"></div>
                                <p>
                                    Whse:<strong> <?php echo $array_wcsbox[$keybox]['PBWHSE']; ?> </strong><br>
                                    Lines:<strong> <?php echo $array_wcsbox[$keybox]['PBBOXL']; ?></strong><br>
                                    Size:<strong> <?php echo $array_wcsbox[$keybox]['PBBXSZ']; ?></strong><br>
                                    LP#:<strong> <?php echo $array_wcsbox[$keybox]['PBLP9D']; ?></strong><br>
                                    Cart/Batch:<strong> <?php echo $array_wcsbox[$keybox]['PBCART']; ?></strong><br>
                                    Ship Class:<strong> <?php echo $array_wcsbox[$keybox]['PBSHPC']; ?></strong><br>
                                    Tracer#:<strong> <?php echo $array_wcsbox[$keybox]['TRACER']; ?></strong>

                                </p>
                            </div>
                            <div class="col-lg-6">
                                <h4>Box Touch Times</h4>
                                <div class="line"></div>
                                <p>
                                    Received Date:<strong> <?php echo _jdatetomysqldate($array_wcsbox[$keybox]['PBRCJD']); ?> </strong><br>
                                    Received Time:<strong> <?php echo (strlen($array_wcsbox[$keybox]['PBRCHM']) < 4 ? date('H:i', strtotime('0' . $array_wcsbox[$keybox]['PBRCHM'])) : date('H:i', strtotime($array_wcsbox[$keybox]['PBRCHM']))) ?> </strong><br>
                                    Print Date:<strong> <?php echo _jdatetomysqldate($array_wcsbox[$keybox]['PBPTJD']); ?> </strong><br>
                                    Print Time:<strong> <?php echo (strlen($array_wcsbox[$keybox]['PBPTHM']) < 4 ? date('H:i', strtotime('0' . $array_wcsbox[$keybox]['PBPTHM'])) : date('H:i', strtotime($array_wcsbox[$keybox]['PBPTHM']))) ?> </strong><br>
                                    Released Date:<strong> <?php echo _jdatetomysqldate($array_wcsbox[$keybox]['PBRLJD']); ?> </strong><br>
                                    Released Time:<strong> <?php echo (strlen($array_wcsbox[$keybox]['PBRLHM']) < 4 ? date('H:i', strtotime('0' . $array_wcsbox[$keybox]['PBRLHM'])) : date('H:i', strtotime($array_wcsbox[$keybox]['PBRLHM']))) ?> </strong><br>

                                </p>
                            </div>
                        </div>
                    </div>

                    <table class="table sticky-top" style=""> 
                        <thead> 
                            <tr> 
                                <th scope="col">PICK LINE#</th> 
                                <th scope="col">ITEM#</th> 
                                <th scope="col">DESCRIPTION</th> 
                                <th scope="col">PICK LOCATION</th> 
                                <th scope="col">PACKAGE UNIT</th> 
                                <th scope="col">PICK QTY</th> 

                            </tr> 
                        </thead> 
                        <tbody> 
                            <?php foreach ($array_wcsboxlines as $key => $value) { ?>
                                <tr> 
                                    <td><?php echo $array_wcsboxlines[$key]['PDPCKL']; ?></td> 
                                    <td><?php echo $array_wcsboxlines[$key]['PDITEM']; ?></td> 
                                    <td><?php echo $array_wcsboxlines[$key]['IMDESC']; ?></td> 
                                    <td><?php echo $array_wcsboxlines[$key]['PDLOC#']; ?></td> 
                                    <td><?php echo $array_wcsboxlines[$key]['PDPKGU']; ?></td> 
                                    <td><?php echo $array_wcsboxlines[$key]['PDPCKS']; ?></td> 
                                </tr> 
                            <?php } ?>
                        </tbody> 
                    </table> 

                </div>

            <?php } //array_wcsbox   ?>
        <?php } //boxnum array ?>
</section> 
    <?php } #End of invoice loop       ?>  


