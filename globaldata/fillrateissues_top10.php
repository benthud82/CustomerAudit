<?php
ini_set('max_execution_time', 99999);

include_once '../globalincludes/usa_asys.php';



if ($var_numtype == 'salesplan') {
    $filter = " and A.BILL_TO in (SELECT DISTINCT PHAN8 FROM HSIPCORDTA.NOTWPY WHERE PHASN = '$var_custnum') ";
} elseif ($var_numtype == 'billto') {
    $filter = " and A.BILL_TO = '$var_custnum' ";
} elseif ($var_numtype == 'shipto') {
    $filter = " and A.CUSTOMER = '$var_custnum' ";
} else {

    $sql_cfr_incl = "SELECT 
                                    group_SHIPTO
                                FROM
                                    custaudit.scorecard_groupingdetail
                                WHERE
                                    group_MASTERID = $var_custnum;";
    $query_cfr_incl = $conn1->prepare($sql_cfr_incl);
    $query_cfr_incl->execute();
    $array_cfr_incl = $query_cfr_incl->fetchAll(pdo::FETCH_COLUMN);
    $array_cfr_incl_data = array();
    $counter = 0;
    $imp_cfr_include = "('" . implode("','", $array_cfr_incl) . "')";


    $filter = " and A.CUSTOMER in $imp_cfr_include ";
}

$var_rollmonthjdate = _rollmonth1yyddd();  //default
$today = date("m/d/Y");
$var_rollmonthenddate = _gregdateto1yyddd($today);  //default


$fillratedata = $aseriesconn->prepare("SELECT DISTINCT 
                                            
                                            A.ITEM, 
                                            B.IMDESC, 
                                            sum(case when A.IP_FIL_TYP = 'XD' then 1 else 0 end) as NSI,
                                            sum(case when A.IP_FIL_TYP = 'BO' then 1 else 0 end) as BO,
                                            sum(case when A.IP_FIL_TYP = 'XS' then 1 else 0 end) as STK_XS,
                                            sum(case when A.IP_FIL_TYP = 'XE' then 1 else 0 end) as NSI_XS,
                                             sum(case when A.IP_FIL_TYP = 'XD' then 1 else 0 end) +
                                            sum(case when A.IP_FIL_TYP = 'BO' then 1 else 0 end) +
                                            sum(case when A.IP_FIL_TYP = 'XS' then 1 else 0 end) +
                                            sum(case when A.IP_FIL_TYP = 'XE' then 1 else 0 end) as TOTAL
                                            
                                            FROM HSIPCORDTA.IM0011 A
                                            JOIN HSIPCORDTA.NPFIMS B ON B.IMITEM = A.ITEM

                                            WHERE A.IP_FIL_TYP not in ('D', ' ') and A.OR_DATE >=  $var_rollmonthjdate and A.OR_DATE <=  $var_rollmonthenddate and A.IP_FIL_TYP <> ' ' $filter
                                            
                                            GROUP BY A.ITEM, B.IMDESC

                                            ORDER BY (sum(case when A.IP_FIL_TYP = 'XD' then 1 else 0 end) +
                                            sum(case when A.IP_FIL_TYP = 'BO' then 1 else 0 end) +
                                            sum(case when A.IP_FIL_TYP = 'XS' then 1 else 0 end) +
                                            sum(case when A.IP_FIL_TYP = 'XE' then 1 else 0 end))  DESC
                                                FETCH FIRST 10 ROWS ONLY");
$fillratedata->execute();
$fillratedataarray = $fillratedata->fetchAll(pdo::FETCH_ASSOC);
?>
<table class="table table-striped m-b-none text-small"> 
    <thead> 
        <tr class="text-center"> 
            <th class="text-center">Item</th> 
            <th class="text-center">Description</th> 
            <th class="text-center">NSI</th> 
            <th class="text-center">BO</th> 
            <th class="text-center">Stocking Cross-Ship</th> 
            <th class="text-center">Non-Stock Cross-Ship</th> 
            <th class="text-center">Total Fill Rate Hits</th> 
        </tr> 
    </thead> 
    <tbody> 
        <?php foreach ($fillratedataarray as $key => $value) {
            ?>
            <tr class="text-center" >
                <td><?php echo $fillratedataarray[$key]['ITEM']; ?></td> 
                <td><?php echo $fillratedataarray[$key]['IMDESC']; ?></td> 
                <td><?php echo $fillratedataarray[$key]['NSI']; ?></td> 
                <td><?php echo $fillratedataarray[$key]['BO']; ?></td> 
                <td><?php echo $fillratedataarray[$key]['STK_XS']; ?></td> 
                <td><?php echo $fillratedataarray[$key]['NSI_XS']; ?></td> 
                <td><?php echo $fillratedataarray[$key]['TOTAL']; ?></td> 

            </tr>
            <?php
        }
        ?>
           </tbody> 
</table>