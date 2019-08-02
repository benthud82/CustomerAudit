<?php
include_once '../globalincludes/usa_asys.php';

if ($var_numtype == 'salesplan') {
    $salesplanfilter = " and S.SALESPLAN = '$var_custnum' ";
    $itemcodefilter = ' ';
} elseif ($var_numtype == 'billto') {
    $salesplanfilter = " and R.BILLTONUM = '$var_custnum' ";
    $itemcodefilter = ' ';
} elseif ($var_numtype == 'shipto') {
    $salesplanfilter = " and R.SHIPTONUM = '$var_custnum' ";
    $itemcodefilter = ' ';
} else {
    $var_salesplan = $var_custnum;


    $sql_cfr_incl = "SELECT 
                                    group_SHIPTO
                                FROM
                                    custaudit.scorecard_groupingdetail
                                WHERE
                                    group_MASTERID = $var_salesplan;";
    $query_cfr_incl = $conn1->prepare($sql_cfr_incl);
    $query_cfr_incl->execute();
    $array_cfr_incl = $query_cfr_incl->fetchAll(pdo::FETCH_COLUMN);
    $array_cfr_incl_data = array();
    $counter = 0;
    $imp_cfr_include = "(" . implode(",", $array_cfr_incl) . ")";


    $salesplanfilter = " and R.SHIPTONUM in $imp_cfr_include ";
    $itemcodefilter = ' ';
}


$startdate = date('Y-m-d', strtotime('-90 days'));

$enddate = date('Y-m-d');

$datediff = abs(strtotime($startdate) - strtotime($enddate));
$days = intval(floor($datediff / (60 * 60 * 24)));





$custreturnsdata = $conn1->prepare("SELECT 
                                        ITEMCODE,
                                        sum(case
                                            when R.RETURNCODE = 'WISP' then 1
                                            else 0
                                        end) as WISP,
                                        sum(case
                                            when R.RETURNCODE = 'WQSP' then 1
                                            else 0
                                        end) as WQSP,
                                        sum(case
                                            when R.RETURNCODE = 'IBNS' then 1
                                            else 0
                                        end) as IBNS,
                                        sum(case
                                            when R.RETURNCODE = 'CRID' then 1
                                            else 0
                                        end) as CRID,
                                        sum(case
                                            when R.RETURNCODE = 'TDNR' then 1
                                            else 0
                                        end) as TDNR,
                                        sum(case
                                            when R.RETURNCODE = 'EXPR' then 1
                                            else 0
                                        end) as EXPR,
                                        sum(case
                                            when R.RETURNCODE = 'SDAT' then 1
                                            else 0
                                        end) as SDAT,
                                        sum(case
                                            when R.RETURNCODE = 'TEMP' then 1
                                            else 0
                                        end) as TEMP,
                                        sum(case
                                            when R.RETURNCODE = 'LITR' then 1
                                            else 0
                                        end) as LITR,
                                        sum(case
                                            when R.RETURNCODE = 'WIOD' then 1
                                            else 0
                                        end) as WIOD,
                                        sum(case
                                            when R.RETURNCODE = 'IBNO' then 1
                                            else 0
                                        end) as IBNO,
                                        sum(case
                                            when R.RETURNCODE = 'CNCL' then 1
                                            else 0
                                        end) as CNCL,
                                        sum(case
                                            when R.RETURNCODE = 'NRSP' then 1
                                            else 0
                                        end) as NRSP,
                                        sum(case
                                            when R.RETURNCODE = 'WQTY' then 1
                                            else 0
                                        end) as WQTY,
                                        sum(case
                                            when R.RETURNCODE = 'TPRX' then 1
                                            else 0
                                        end) as TPRX,
                                    count(*) as TOTALRETURNS
                                    FROM
                                        custaudit.custreturns R
                                            JOIN
                                        custaudit.salesplan S ON R.BILLTONUM = S.BILLTO
                                            and R.SHIPTONUM = S.SHIPTO
                                            JOIN
                                        custaudit.custreturnmetrics M ON R.RETURNCODE = M.RETURNCODE
                                    WHERE 
                                      ORD_RETURNDATE BETWEEN DATE_SUB(NOW(), INTERVAL $days DAY) AND NOW() $salesplanfilter $itemcodefilter
                                    GROUP BY ITEMCODE
                                    ORDER BY count(*) DESC
                                               ");
$custreturnsdata->execute();
$custreturnsarray = $custreturnsdata->fetchAll(pdo::FETCH_ASSOC);
?>
<table class="table m-b-none" style="font-size: 11px; padding: 0px; margin: 0px;"> 
    <thead> 
        <tr class="text-center print_nopadding"> 
            <th class="text-center print_nopadding">Item</th> 
            <th class="text-center print_nopadding">WISP</th> 
            <th class="text-center print_nopadding">WQSP</th> 
            <th class="text-center print_nopadding">IBNS</th> 
            <th class="text-center print_nopadding">CRID</th> 
            <th class="text-center print_nopadding">TDNR</th> 
            <th class="text-center print_nopadding">EXPR</th> 
            <th class="text-center print_nopadding">SDAT</th> 
            <th class="text-center print_nopadding">TEMP</th> 
            <th class="text-center print_nopadding">LITR</th> 
            <th class="text-center print_nopadding">WIOD</th> 
            <th class="text-center print_nopadding">IBNO</th> 
            <th class="text-center print_nopadding">CNCL</th> 
            <th class="text-center print_nopadding">NRSP</th> 
            <th class="text-center print_nopadding">WQTY</th> 
            <th class="text-center print_nopadding">TPRX</th> 
            <th class="text-center print_nopadding">Total Returns</th> 
        </tr> 
    </thead> 
    <tbody> 
        <?php
        foreach ($custreturnsarray as $key => $value) {
            if ($key > 9) {
                break;
            }
            ?>
            <tr class="text-center print_nopadding" >
                <td class="print_nopadding"><?php echo $custreturnsarray[$key]['ITEMCODE']; ?></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['WISP']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['WISP']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['WQSP']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['WQSP']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['IBNS']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['IBNS']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['CRID']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['CRID']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['TDNR']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['TDNR']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['EXPR']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['EXPR']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['SDAT']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['SDAT']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['TEMP']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['TEMP']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['LITR']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['LITR']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['WIOD']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['WIOD']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['IBNO']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['IBNO']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['CNCL']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['CNCL']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['NRSP']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['NRSP']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['WQTY']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['WQTY']; ?></span></td> 
                <td class="print_nopadding"><span  class="<?php echo intval($custreturnsarray[$key]['TPRX']) > 0 ? 'bg-inverse' : ''; ?>"><?php echo $custreturnsarray[$key]['TPRX']; ?></td> 
                <td class="print_nopadding"><?php echo $custreturnsarray[$key]['TOTALRETURNS']; ?></td> 

            </tr>
            <?php

        }
        ?>
    </tbody> 
</table>