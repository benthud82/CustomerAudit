
<?php
include_once '../../globalincludes/usa_esys.php';
include_once '../functions/customer_audit_functions.php';
$jde_num = $_POST['jde_num'];
$selectclause = 'QCTRDJ as ORDJDATE,
                QCCRTM as ORDTIME,
                QCENTB as ENTEREDBY,
                QC$LWS as LOWSTAT,
                QC$HGS as HIGHSTAT,
                QC$DC as PRIMDC,
                QCAC08 as MARKETSEG,
                QCAC10 as MARKETDIV,
                QCAC04 as MARKETPRACT';

$sql_orderentry = $eseriesconn->prepare("SELECT $selectclause FROM HSIPDTA71.F5501 WHERE QCDOCO  = $jde_num");
$sql_orderentry->execute();
$array_orderentry = $sql_orderentry->fetchAll(pdo::FETCH_ASSOC);

$sql_linedetail = $eseriesconn->prepare("SELECT
                                            SDLNID as LINENUM    ,
                                            trim(CAST(SDLITM AS CHAR(20) CCSID 37)) ITEMNUM,
                                            SDDSC1 as DESCRIPTION,
                                            SDUORG as ORDQTY     ,
                                            SDSOQS as QTYSHIP    ,
                                            SDSOBK as QTYBO      ,
                                            SDSOCN as QTYCNCL    ,
                                            SDAEXP as EXTPRICE
                                        FROM
                                            HSIPDTA71.F4211
                                        WHERE
                                            SDDOCO = $jde_num");
$sql_linedetail->execute();
$array_linedetail = $sql_linedetail->fetchAll(pdo::FETCH_ASSOC);
?>
<section class="panel">
    <header class="panel-heading title " style="font-size: 20px"> JDE Invoice </header> 
    <div class="panel-body">
        <p class="m-t m-b well col-lg-3 col-md-6">
            Order Date: <strong><?php echo date('Y-m-d', strtotime(_1yydddtogregdate($array_orderentry[0]['ORDJDATE']))) ?> </strong><br> 
            Order Time: <strong><?php echo  (strlen($array_orderentry[0]['ORDTIME']) < 6 ? date('H:i:s', strtotime('0'.$array_orderentry[0]['ORDTIME'])) : date('H:i:s', strtotime($array_orderentry[0]['ORDTIME']))) ?></strong><br> 
            Primary DC: <strong><?php echo substr($array_orderentry[0]['PRIMDC'], -2) ?></strong> <br>
            Entered By: <strong><?php echo $array_orderentry[0]['ENTEREDBY'] ?></strong> <br>
            Market Segment: <strong><?php echo $array_orderentry[0]['MARKETSEG'] ?></strong> <br>
            Market Division: <strong><?php echo $array_orderentry[0]['MARKETDIV'] ?></strong> <br>
            Market Practice: <strong><?php echo $array_orderentry[0]['MARKETPRACT'] ?></strong> <br>
        </p> 
 
        <table class="table sticky-top" style=""> 
            <thead> 
                <tr> 
                    <th scope="col">LINE#</th> 
                    <th scope="col">ITEM#</th> 
                    <th scope="col">DESCRIPTION</th> 
                    <th scope="col">ORDER QTY</th> 
                    <th scope="col">SHIP QTY</th> 
                    <th scope="col">BO QTY</th> 
                    <th scope="col">CANCEL QTY</th> 
                    <th scope="col">UNIT PRICE</th> 
                    <th scope="col">EXTENDED PRICE</th> 

                </tr> 
            </thead> 
            <tbody> 
                <?php foreach ($array_linedetail as $key => $value) { ?>
                    <tr> 
                        <td><?php echo $array_linedetail[$key]['LINENUM']; ?></td> 
                        <td><?php echo $array_linedetail[$key]['ITEMNUM']; ?></td> 
                        <td><?php echo $array_linedetail[$key]['DESCRIPTION']; ?></td> 
                        <td><?php echo $array_linedetail[$key]['ORDQTY']; ?></td> 
                        <td><?php echo $array_linedetail[$key]['QTYSHIP']; ?></td> 
                        <td><?php echo $array_linedetail[$key]['QTYBO']; ?></td> 
                        <td><?php echo $array_linedetail[$key]['QTYCNCL']; ?></td> 
                        <td><?php echo '$' . number_format($array_linedetail[$key]['EXTPRICE'] / 100 / $array_linedetail[$key]['ORDQTY'], 2); ?></td> 
                        <td><?php echo '$' . number_format($array_linedetail[$key]['EXTPRICE'] / 100, 2); ?></td> 
                    </tr> 
                <?php } ?>
            </tbody> 
        </table> 
    </div>
</section>