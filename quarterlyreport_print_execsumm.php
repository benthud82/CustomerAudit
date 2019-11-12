<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>
    <head>
        <title>Large Customer Quarterly Report</title>

        <meta charset="utf-8">

        <script src="js/offsys_dash.js" type="text/javascript"></script>
        <script src="js/globalscripts.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.6/jq-2.2.3/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="shortcut icon" type="image/ico" href="../favicon.ico" />  
        <!--<link href="osscss/offsys_dash.css" rel="stylesheet" type="text/css"/>-->
        <script src="js/jszip.js" type="text/javascript"></script>
        <script src="https://code.highcharts.com/highcharts.src.js"></script>
        <script src="../highcharts-more.js" type="text/javascript"></script>
        <script src="../jquery-ui.js"></script>
        <script src="js/qtrreport_main.js" type="text/javascript"></script>
        <script src="js/qtrreport_widgets.js" type="text/javascript"></script>
        <script src="js/sparkline.js" type="text/javascript"></script>
        <?php
        include_once 'functions/customer_audit_functions.php';
        $startdate = date('M j, Y', strtotime("-90 days"));
        $curdate = date('M j, Y');
        ?>
        <link href="osscss/qtr_report.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="osscss/print.css" media="print">
        <link href="osscss/themify-icons/themify-icons.css" rel="stylesheet" type="text/css"/>
        <style>
            @media print {
                @page {size: portrait}
                -webkit-print-color-adjust: exact;
            </style>

        </head>

        <body>

            <div class="app-body">
                <main class="main">
                    <div class="container-fluid">
                        <div style="margin-top: 0px;">
                            <?php include 'globaldata/qtrreport_execsumm_pageheader.php'; ?>
                        </div>
                        <div class="h4">Large Customer Review</div>
                        <!--include blob from Ed/Mel?-->
                        <p>THIS is a test blob.  There would be a lot more writing here. THIS is a test blob.  There would be a lot more writing here.
                            THIS is a test blob.  There would be a lot more writing here.THIS is a test blob.  There would be a lot more writing here.
                            THIS is a test blob.  There would be a lot more writing here.THIS is a test blob.  There would be a lot more writing here.
                            THIS is a test blob.  There would be a lot more writing here.</p>
                        <p>THIS is a test blob.  There would be a lot more writing here. THIS is a test blob.  There would be a lot more writing here.
                            THIS is a test blob.  There would be a lot more writing here.THIS is a test blob.  There would be a lot more writing here.
                            THIS is a test blob.  There would be a lot more writing here.THIS is a test blob.  There would be a lot more writing here.
                            THIS is a test blob.  There would be a lot more writing here.</p>


                        <!--descriptive stats (what happened?)-->
                        <?php include 'globaldata/qtr_report_descriptive.php'; ?>
                        <div class="h4" style="margin-top: 20px;">Large Customer Score Summary</div>

                        <div>Total customers (salesplans) tracked by large customer team:<strong> <?php echo $custcount_array[0]['CUST_COUNT']; ?></strong></div>
                        <div> <?php echo 'Average quarterly score: <strong>' . intval($custcount_array[0]['AVG_SCORE'] * 100) . '</strong>'; ?> </div>
                        <div> <?php
                            $plusminus = ($totalscoretrend_m >= 0 ? '+' : '-');
                            echo 'Quarter over quarter average score trend: <strong>' . $plusminus . number_format($totalscoretrend_m * 100, 1) . '</strong>';
                            ?>
                        </div>





                        <?php
                        include 'globaldata/qtrreport_custcomplaints.php';
                        $tot_last = number_format($prevsum, 0, ".", ",");
                        $tot_this = number_format($currsum, 0, ".", ",");
                        $tot_incdec = ($tot_last > $tot_this ? 'decreased' : 'increased');
                        ?>
                        <div class="h4" style="margin-top: 20px;">Customer Complaints</div>

                        <div><strong>Total</strong> customer complaints have <strong><?php echo $tot_incdec; ?></strong> over the past quarter to <strong><?php echo $tot_this ?></strong> this quarter from <strong> <?php echo $tot_last ?></strong> last quarter.</div>
                        <?php
                        foreach ($array_custcomp as $key => $value) {
                            $metric = $array_custcomp[$key]['METRIC'];
                            $prevsum = number_format($array_custcomp[$key]['PREVQTR'], 0, ".", ",");
                            $currsum = number_format($array_custcomp[$key]['CURQTR'], 0, ".", ",");
                            $incdec = ($prevsum > $currsum ? 'decreased' : 'increased');

                            echo '<div><strong>' . $metric . ' </strong>have ' . $incdec . ' over the past quarter to <strong>' . $currsum . '</strong> this quarter from <strong>' . $prevsum . '</strong> last quarter.</div>';
                        }
                        ?>

                        <!--diagnostic stats (why did it happen / what did our team do?)-->
                        <div class="h4" style="margin-top: 20px;">Large Customer Team - Actions Taken</div>
                        <?php include 'globaldata/cust_audit_count.php'; ?>
                        <div>The Large Customer Team audited a total of <strong><?php echo $tot_audits ?></strong> customer entities for the previous quarter. </div>
                        <p>The following have been identified as high impact salesplans. </p>
                        <?php include 'globaldata/top3salesplans_execsumm.php'; ?>

                        <div class="h4" style="margin-top: 20px;">Fill Rate Summary - Top 10 Items</div>
                        <?php include 'algorithms/qtr_report_topfr.php'; ?>
                        <p>
                            Of the top 10 items causing fill rate hits during the last quarter, <strong><?php echo $atrisktotl ?></strong> items will continue to be issues going forward next quarter.
                            These items will cause an additional <strong><?php echo $totfrhits ?></strong> fill rate issues per day until resoloved.  These items currently represent <strong><?php echo $totunitsonbo ?></strong> customer orders on back order.
                        </p>


                    </div>
                </main>
            </div>



        </body>
    </html>