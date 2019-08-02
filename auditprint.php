<!DOCTYPE html>
<html>
    <head>
        <?php include_once 'headerincludes.php'; ?>

    <img src="../henry-schein-7x4.jpg" style="width:350px;height:200px;">
</head>
<?php
$var_numtype = $_POST['numtype'];
if (isset($_POST['salesplan'])) {
    $var_custnum = $_POST['salesplan'];
} elseif (isset($_POST['billto'])) {
    $var_custnum = $_POST['billto'];
}elseif (isset($_POST['shipto'])) {
    $var_custnum = $_POST['shipto'];
}




//puts header info on the first page
include_once 'globaldata/customerinfodata.php';

//score panels for month, qtr, year
include_once 'globaldata/custscorecarddata_' . $var_numtype . '.php';

//top 10 fill rate issues
?>
<section class="panel" id="resultwrapper_salesplan" style="margin-bottom: 50px; margin-top: 50px; page-break-before: always;"> 
    <header class="panel-heading bg bg-inverse h3">Top 10 Fill Rate Issues</header>
    <div id="summary_salesplan" class="panel-body">
        <div id="resultcontainer_salesplan" class="table-striped">
            <?php include_once 'globaldata/fillrateissues_top10.php'; ?>
        </div>
    </div>
</section>



<input name='numtype' class='selectstyle hidden' id='numtype' value="<?php echo $var_numtype ?>"/>
<input name='custnum' class='selectstyle hidden' id='custnum' value="<?php echo $var_custnum ?>"/>

<div id="" style="width: 925px; margin-top: 100px;page-break-before: always">
    <h3>Fill Rate Graph:</h3>
    <div id="frcontainer" class="largecustchartstyle "></div>
</div>


<section class="panel" id="resultwrapper_salesplan" style="margin-bottom: 50px; margin-top: 50px; page-break-before: always;"> 
    <header class="panel-heading bg bg-inverse h3">Top 10 Customer Returns Issues</header>
    <div id="summary_salesplan" class="panel-body">
        <div id="resultcontainer_salesplan" class="table-striped">
            <?php include_once 'globaldata/custreturnsissues_top10.php'; ?>
        </div>
    </div>
</section>
<div id="" style="width: 925px; margin-top: 100px;page-break-before: always">
    <h3>Customer Returns Graph:</h3>
    <div id="container_custret" class="largecustchartstyle "></div>
</div>


<script>
    debugger;
    var numtype = $('#numtype').val();
    var custnum = $('#custnum').val();
    //which highchart script should be called, salesplan, billto, or shipto
    if (numtype === 'salesplan') {
        loadfillratehighchart_salesplan(numtype, custnum);
        loadcustreturnsratehighchart_salesplan(numtype, custnum);
    } else if (numtype === 'billto') {
        loadfillratehighchart_billto(numtype, custnum);
        loadcustreturnsratehighchart_billto(numtype, custnum);
    } else if (numtype === 'shipto') {
        loadfillratehighchart_shipto(numtype, custnum);
        loadcustreturnsratehighchart_shipto(numtype, custnum);
    }
</script>

</html>

