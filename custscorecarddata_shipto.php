
<?php
include '../../globalfunctions/custdbfunctions.php';
include_once '../connection/connection_details.php';
$var_cust = $_POST['shipto'];  //transfers over as bill to, but this is the salesplan

$result1 = $conn1->prepare("SELECT * FROM customerscores_shipto WHERE SHIPTONUM = $var_cust");
$result1->execute();

foreach ($result1 as $row) {
    //are all of these in the customerscores_salesplan table?
    $SHIPTO = $row['SHIPTONUM'];
    $TOTMONTHLINES = $row['TOTMONTHLINES'];
    $TOTMONTHCOGS = $row['TOTMONTHCOGS'];
    $TOTMONTHSALES = $row['TOTMONTHSALES'];
    $TOTQTRLINES = $row['TOTQTRLINES'];
    $TOTQTRCOGS = $row['TOTQTRCOGS'];
    $TOTQTRSALES = $row['TOTQTRSALES'];
    $TOTR12LINES = $row['TOTR12LINES'];
    $TOTR12COGS = $row['TOTR12COGS'];
    $TOTR12SALES = $row['TOTR12SALES'];
    $TOTMNTBO = $row['TOTMNTBO'];
    $TOTQTRBO = $row['TOTQTRBO'];
    $TOTR12BO = $row['TOTR12BO'];
    $TOTMNTBE = $row['TOTMNTBE'];
    $TOTQTRBE = $row['TOTQTRBE'];
    $TOTR12BE = $row['TOTR12BE'];
    $TOTMNTD = $row['TOTMNTD'];
    $TOTQTRD = $row['TOTQTRD'];
    $TOTR12D = $row['TOTR12D'];
    $TOTMNTXD = $row['TOTMNTXD'];
    $TOTQTRXD = $row['TOTQTRXD'];
    $TOTR12XD = $row['TOTR12XD'];
    $TOTMNTXE = $row['TOTMNTXE'];
    $TOTQTRXE = $row['TOTQTRXE'];
    $TOTR12XE = $row['TOTR12XE'];
    $TOTMNTXS = $row['TOTMNTXS'];
    $TOTQTRXS = $row['TOTQTRXS'];
    $TOTR12XS = $row['TOTR12XS'];
    $BEFFRMNT = number_format((float) $row['BEFFRMNT'] * 100, 2) . '%';
    $AFTFRMNT = number_format((float) $row['AFTFRMNT'] * 100, 2) . '%';
    $BEFFRQTR = number_format((float) $row['BEFFRQTR'] * 100, 2) . '%';
    $AFTFRQTR = number_format((float) $row['AFTFRQTR'] * 100, 2) . '%';
    $BEFFRR12 = number_format((float) $row['BEFFRR12'] * 100, 2) . '%';
    $AFTFRR12 = number_format((float) $row['AFTFRR12'] * 100, 2) . '%';
    $BEFFRMNT_EXCLDS = number_format((float) $row['BEFFRMNT_EXCLDS'] * 100, 2) . '%';
    $AFTFRMNT_EXCLDS = number_format((float) $row['AFTFRMNT_EXCLDS'] * 100, 2) . '%';
    $BEFFRQTR_EXCLDS = number_format((float) $row['BEFFRQTR_EXCLDS'] * 100, 2) . '%';
    $AFTFRQTR_EXCLDS = number_format((float) $row['AFTFRQTR_EXCLDS'] * 100, 2) . '%';
    $BEFFRR12_EXCLDS = number_format((float) $row['BEFFRR12_EXCLDS'] * 100, 2) . '%';
    $AFTFRR12_EXCLDS = number_format((float) $row['AFTFRR12_EXCLDS'] * 100, 2) . '%';
    $SHIPACCPERCMNT = number_format((float) $row['SHIPACCPERCMNT'] * 100, 2) . '%';
    $SHIPACCPERCQTR = number_format((float) $row['SHIPACCPERCQTR'] * 100, 2) . '%';
    $SHIPACCPERCR12 = number_format((float) $row['SHIPACCPERCR12'] * 100, 2) . '%';
    $DAMAGEACCPERCMNT = number_format((float) $row['DAMAGEACCPERCMNT'] * 100, 2) . '%';
    $DAMAGEACCPERCQTR = number_format((float) $row['DAMAGEACCPERCQTR'] * 100, 2) . '%';
    $DAMAGEACCPERCR12 = number_format((float) $row['DAMAGEACCPERCR12'] * 100, 2) . '%';
    $ADDSCACCPERCMNT = number_format((float) $row['ADDSCACCPERCMNT'] * 100, 2) . '%';
    $ADDSCACCPERCQTR = number_format((float) $row['ADDSCACCPERCQTR'] * 100, 2) . '%';
    $ADDSCACCPERCR12 = number_format((float) $row['ADDSCACCPERCR12'] * 100, 2) . '%';
    $MNTHOSC = number_format((float) $row['MNTHOSC'] * 100, 2) . '%';
    $QTROSC = number_format((float) $row['QTROSC'] * 100, 2) . '%';
    $R12OSC_EXCLDS = number_format((float) $row['R12OSC_EXCLDS'] * 100, 2) . '%';
    $MNTHOSC_EXCLDS = number_format((float) $row['MNTHOSC_EXCLDS'] * 100, 2) . '%';
    $QTROSC_EXCLDS = number_format((float) $row['QTROSC_EXCLDS'] * 100, 2) . '%';
    $R12OSC = number_format((float) $row['R12OSC'] * 100, 2) . '%';
    $CUSTSCOREMNT = number_format((float) $row['CUSTSCOREMNT'] * 100);
    $CUSTSCOREQTR = number_format((float) $row['CUSTSCOREQTR'] * 100);
    $CUSTSCORER12 = number_format((float) $row['CUSTSCORER12'] * 100);
    $CUSTSCOREMNT_EXCLDS = number_format((float) $row['CUSTSCOREMNT_EXCLDS'] * 100);
    $CUSTSCOREQTR_EXCLDS = number_format((float) $row['CUSTSCOREQTR_EXCLDS'] * 100);
    $CUSTSCORER12_EXCLDS = number_format((float) $row['CUSTSCORER12_EXCLDS'] * 100);
    $CUR_MNT_P_LINES = $row['CUR_MNT_P_LINES'];
    $CUR_QTR_P_LINES = $row['CUR_QTR_P_LINES'];
    $R12_P_LINES = $row['R12_P_LINES'];
    $CUR_MNT_P_FR = $row['CUR_MNT_P_FR'];
    $CUR_QTR_P_FR = $row['CUR_QTR_P_FR'];
    $R12_P_FR = $row['R12_P_FR'];
    $PBFRMNT = number_format((float) $row['PBFRMNT'] * 100, 2) . '%';
    $PBFRQTR = number_format((float) $row['PBFRQTR'] * 100, 2) . '%';
    $PBFRR12 = number_format((float) $row['PBFRR12'] * 100, 2) . '%';
}


//determine class for panels
$panelclassmnt = _newcustomerscorecardpanelclass($CUSTSCOREMNT_EXCLDS);
$panelclassqtr = _newcustomerscorecardpanelclass($CUSTSCOREQTR_EXCLDS);
$panelclassr12 = _newcustomerscorecardpanelclass($CUSTSCORER12_EXCLDS);
$statclassr12 = _newcustomerscorecardstatclass($CUSTSCORER12_EXCLDS);
?>
<!--Top level summary data-->
<div class="row" style="padding-bottom: 20px; padding-top: 20px"> 
<!--    <div class="col-xs-12 col-sm-6 col-lg-3 "> 
        <section class="panel text-center bg-info"> 
            <div class="panel-body "> 
                <i class="fa fa-line-chart fa fa-2x text"></i><div class="h4">Rolling 12 Month Lines</div>
                <div class="line m-l m-r"></div> 
                <h4 class="text"><strong><?php // echo number_format($TOTR12LINES); ?> </strong></h4> 
            </div> 
        </section> 
    </div> -->
<!--    <div class="col-xs-12 col-sm-6 col-lg-3"> 
        <section class="panel text-center bg-info"> 
            <div class="panel-body"> 
                <i class="fa fa-dollar fa fa-2x text"></i><div class="h4">Rolling 12 Sales</div>
                <div class="line m-l m-r"></div> 
                <h4 class="text"><strong><?php // echo '$' . number_format($TOTR12SALES); ?>  </strong></h4> 
            </div> 
        </section> 
    </div> -->
<!--    <div class="col-xs-12 col-sm-6 col-lg-3"> 
        <section class="panel text-center bg-info"> 
            <div class="panel-body"> 
                <i class="fa fa-area-chart fa fa-2x text"></i><div class="h4">Rolling 12 Before Fill Rate</div>
                <div class="line m-l m-r"></div> 
                <h4 class="text"><strong><?php // echo $BEFFRR12_EXCLDS ?>  </strong></h4> 
            </div> 
        </section> 
    </div> -->
<!--    <div class="col-xs-12 col-sm-6 col-lg-3"> 
        <section class="panel text-center <?php // echo ($statclassr12); ?>"> 
            <div class="panel-body"> 
                <i class="fa fa-user fa fa-2x text"></i><div class="h4">Rolling 12 Score</div>
                <div class="line m-l m-r"></div> 
                <h4 class="text"><strong><?php // echo $CUSTSCORER12_EXCLDS ?>  </strong></h4> 
            </div> 
        </section> 
    </div> -->
</div>

<div class="row" style="padding-bottom: 10px; padding-top: 10px;">
    <!--Customer Scorecard Panels for month/quarter/rolling 12-->
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12  panel-no-page-break">
        <!-- Current Month Panel -->            
        <section class="panel">
            <header class="panel-heading bg  h3 text-center <?php echo ($panelclassmnt); ?>">Rolling Month </header>
            <div class="panel-body  text-center" style="border-bottom: 3px solid #ccc;">
                <div class="widget-content-blue-wrapper changed-up">
                    <div class="widget-content-blue-inner padded">
                        <div class="h4"><i class="fa fa-user"></i> Customer Score</div>
                        <div class="line m-l m-r"></div> 
                        <div class="value-block">
                            <!--Monthly Customer Score-->
                            <div class="h2" id="score_month"><?php echo $CUSTSCOREMNT_EXCLDS ?></div> 
                            <div class="text">Rolling Month</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- List group -->
            <div class="list-group">
                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo number_format($TOTMONTHLINES); ?></strong></span> 
                    Invoice Lines 
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong  id="fillratebefore_month"><?php echo $BEFFRMNT_EXCLDS ?></strong></span> 
                    Fill Rate Before 
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong  id="fillrateafter_month"><?php echo $AFTFRMNT_EXCLDS ?></strong></span> 
                    Fill Rate After 
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong id="shipacc_month"><?php echo ($SHIPACCPERCMNT); ?></strong></span> 
                    Shipping Accuracy
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong id="dmgacc_month"><?php echo ($DAMAGEACCPERCMNT); ?></strong></span> 
                    Damages
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong id="addscacc_month"><?php echo ($ADDSCACCPERCMNT); ?></strong></span> 
                    SC Discrepancies
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong>--</strong></span> 
                    Time in Transit
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong id="osc_month"><?php echo $MNTHOSC_EXCLDS ?></strong></span> 
                    Orders Shipped Complete
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo number_format($CUR_MNT_P_LINES); ?></strong></span> 
                    Private Brand Lines
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo $PBFRMNT ?></strong></span> 
                    Private Brand Fill Rate
                </div>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12  panel-no-page-break">
        <!-- Current Quarter Panel -->            
        <section class="panel"> 
            <header class="panel-heading bg h3 text-center <?php echo ($panelclassqtr); ?>">Rolling Quarter </header>
            <div class="panel-body  text-center" style="border-bottom: 3px solid #ccc;">
                <div class="widget-content-blue-wrapper changed-up">
                    <div class="widget-content-blue-inner padded">
                        <div class="h4"><i class="fa fa-user"></i> Customer Score</div>
                        <div class="line m-l m-r"></div> 
                        <div class="value-block">
                            <!--Monthly Customer Score-->
                            <div class="h2" id="score_quarter"><?php echo $CUSTSCOREQTR_EXCLDS ?></div> 
                            <div class="text">Rolling Quarter</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- List group -->
            <div class="list-group">
                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo number_format($TOTQTRLINES); ?></strong></span> 
                    Invoice Lines 
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo $BEFFRQTR_EXCLDS ?></strong></span> 
                    Fill Rate Before 
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo $AFTFRQTR_EXCLDS ?></strong></span> 
                    Fill Rate After 
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo ($SHIPACCPERCQTR); ?></strong></span> 
                    Shipping Accuracy
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo ($DAMAGEACCPERCQTR); ?></strong></span> 
                    Damages
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo ($ADDSCACCPERCQTR); ?></strong></span> 
                    SC Discrepancies
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong>--</strong></span> 
                    Time in Transit
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo $QTROSC_EXCLDS ?></strong></span> 
                    Orders Shipped Complete
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo number_format($CUR_QTR_P_LINES); ?></strong></span> 
                    Private Brand Lines
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo $PBFRQTR ?></strong></span> 
                    Private Brand Fill Rate
                </div>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12  panel-no-page-break">
        <!-- Current R12 Panel -->            
        <section class="panel"> 
            <header class="panel-heading bg h3 text-center <?php echo ($panelclassr12); ?>">Rolling 12 Months </header>
            <div class="panel-body  text-center" style="border-bottom: 3px solid #ccc;">
                <div class="widget-content-blue-wrapper changed-up">
                    <div class="widget-content-blue-inner padded">
                        <div class="h4"><i class="fa fa-user"></i> Customer Score</div>
                        <div class="line m-l m-r"></div> 
                        <div class="value-block">
                            <!--Monthly Customer Score-->
                            <div class="h2" id="score_r12"><?php echo $CUSTSCORER12_EXCLDS ?></div> 
                            <div class="text">Rolling 12 Months</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- List group -->
            <div class="list-group">
                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo number_format($TOTR12LINES); ?></strong></span> 
                    Invoice Lines 
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo $BEFFRR12_EXCLDS ?></strong></span> 
                    Fill Rate Before 
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo $AFTFRR12_EXCLDS ?></strong></span> 
                    Fill Rate After 
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo ($SHIPACCPERCR12); ?></strong></span> 
                    Shipping Accuracy
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo ($DAMAGEACCPERCR12); ?></strong></span> 
                    Damages
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo ($ADDSCACCPERCR12); ?></strong></span> 
                    SC Discrepancies
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong>--</strong></span> 
                    Time in Transit
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo $R12OSC_EXCLDS ?></strong></span> 
                    Orders Shipped Complete
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo number_format($R12_P_LINES); ?></strong></span> 
                    Private Brand Lines
                </div>

                <div class="list-group-item"> 
                    <span class="pull-right"><strong><?php echo $PBFRR12 ?></strong></span> 
                    Private Brand Fill Rate
                </div>
            </div>
        </section>
    </div>
</div>





