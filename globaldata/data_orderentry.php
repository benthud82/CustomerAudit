
<?php
include_once '../../globalincludes/usa_esys.php';
include_once '../functions/customer_audit_functions.php';
$jde_num = $_POST['jde_num'];

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