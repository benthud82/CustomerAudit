
<?php
include_once '../../globalincludes/usa_esys.php';
$jde_num = $_POST['jde_num'];
include_once '../functions/customer_audit_functions.php';

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

$sql_billto = $eseriesconn->prepare("SELECT DISTINCT
                                        A.ALEFTB,
                                        A.ALAN8 ,
                                        A.ALADD1,
                                        A.ALADD2,
                                        A.ALADD3,
                                        A.ALADD4,
                                        trim(CAST(A.ALADDZ AS CHAR(20) CCSID 37)) as ALADDZ,
                                        A.ALCTY1,
                                        A.ALCOUN,
                                        trim(CAST(A.ALADDS AS CHAR(20) CCSID 37)) as ALADDS,
                                        trim(CAST(SHASN AS CHAR(20) CCSID 37)) as SHASN
                                    FROM
                                        HSIPDTA71.F0116 A
                                        JOIN
                                            HSIPDTA71.F4201L5
                                            ON
                                                ALAN8 = SHAN8
                                    WHERE
                                        SHDOCO = $jde_num
                                        and ALEFTB =
                                        (
                                            SELECT
                                                max(ALEFTB)
                                            from
                                                HSIPDTA71.F0116 B
                                            WHERE
                                                A.ALAN8 = B.ALAN8
                                        )");
$sql_billto->execute();
$array_billto = $sql_billto->fetchAll(pdo::FETCH_ASSOC);

$test = $array_billto[0]['ALADD2'];

$sql_shipto = $eseriesconn->prepare("SELECT DISTINCT
                                        A.ALEFTB,
                                        A.ALAN8 ,
                                        A.ALADD1,
                                        A.ALADD2,
                                        A.ALADD3,
                                        A.ALADD4,
                                        trim(CAST(A.ALADDZ AS CHAR(20) CCSID 37)) as ALADDZ,
                                        A.ALCTY1,
                                        A.ALCOUN,
                                        trim(CAST(A.ALADDS AS CHAR(20) CCSID 37)) as ALADDS
                                    FROM
                                        HSIPDTA71.F0116 A
                                        JOIN
                                            HSIPDTA71.F4201L5
                                            ON
                                                ALAN8 = SHSHAN
                                    WHERE
                                        SHDOCO = $jde_num
                                        and ALEFTB =
                                        (
                                            SELECT
                                                max(ALEFTB)
                                            from
                                                HSIPDTA71.F0116 B
                                            WHERE
                                                A.ALAN8 = B.ALAN8
                                        )");
$sql_shipto->execute();
$array_shipto = $sql_shipto->fetchAll(pdo::FETCH_ASSOC);
?>


<div class="well"> 
    <div class="h4" style="margin: 0px 0px 15px 0px;">SALES PLAN: <?php echo $array_billto[0]['SHASN'] ?></div>
    <div class="row"> 
        <div class="col-md-4"> 
            <strong>BILL TO:</strong> 
            <h5><?php echo $array_billto[0]['ALADD1'] ?></h5> 
            <p> 
                <?php echo(trim($array_billto[0]['ALADD2']) == '' ? '' : $array_billto[0]['ALADD2'] . '<br>'); ?>
                <?php echo(trim($array_billto[0]['ALADD3']) == '' ? '' : $array_billto[0]['ALADD3'] . '<br>'); ?>
                <?php echo(trim($array_billto[0]['ALADD4']) == '' ? '' : $array_billto[0]['ALADD4'] . '<br>'); ?>
                <?php echo trim($array_billto[0]['ALCTY1']) . ', ' . $array_billto[0]['ALADDS'] . ' ' . substr($array_billto[0]['ALADDZ'], 0, 5); ?>


            </p> 
        </div> 
        <div class="col-md-4"> 
            <strong>SHIP TO:</strong> 
            <h5><?php echo $array_shipto[0]['ALADD1'] ?></h5> 
            <p>
                <?php echo(trim($array_shipto[0]['ALADD2']) == '' ? '' : $array_shipto[0]['ALADD2'] . '<br>'); ?>
                <?php echo(trim($array_shipto[0]['ALADD3']) == '' ? '' : $array_shipto[0]['ALADD3'] . '<br>'); ?>
                <?php echo(trim($array_shipto[0]['ALADD4']) == '' ? '' : $array_shipto[0]['ALADD4'] . '<br>'); ?>
                <?php echo trim($array_shipto[0]['ALCTY1']) . ', ' . $array_shipto[0]['ALADDS'] . ' ' . substr($array_shipto[0]['ALADDZ'], 0, 5); ?>
            </p> 
        </div> 
        <div class="col-md-4"> 
            <strong style="margin-bottom: 10px;">ORDER DATA:</strong> 
            <p style="margin-top: 10px;">
                Order Date: <strong><?php echo date('Y-m-d', strtotime(_1yydddtogregdate($array_orderentry[0]['ORDJDATE']))) ?> </strong><br> 
                Order Time: <strong><?php echo (strlen($array_orderentry[0]['ORDTIME']) < 6 ? date('H:i:s', strtotime('0' . $array_orderentry[0]['ORDTIME'])) : date('H:i:s', strtotime($array_orderentry[0]['ORDTIME']))) ?></strong><br> 
                Primary DC: <strong><?php echo substr($array_orderentry[0]['PRIMDC'], -2) ?></strong> <br>
                Entered By: <strong><?php echo $array_orderentry[0]['ENTEREDBY'] ?></strong> <br>
                Market Segment: <strong><?php echo $array_orderentry[0]['MARKETSEG'] ?></strong> <br>
                Market Division: <strong><?php echo $array_orderentry[0]['MARKETDIV'] ?></strong> <br>
                Market Practice: <strong><?php echo $array_orderentry[0]['MARKETPRACT'] ?></strong> <br>
            </p> 
        </div> 
    </div> 
</div> 


