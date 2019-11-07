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

                        <?php include 'globaldata/qtrreport_pageheader.php'; ?>
                        <!--descriptive stats (what happened?)-->
                        <div class="row">
                            <?php include 'globaldata/qtr_report_descriptive.php'; ?>
                            <div class="col-xs-6">
                                <div id="gauge_custtrend" style="min-width: 310px; max-width: 300px; height: 225px; margin: 0 auto"></div>
                            </div>
                        </div>
                        <div class="" id="ctn_scorehistogram" style="width: 930px; height: 540px;border: 1px solid #c8ced3;border-radius: 5px; margin-bottom: 20px"></div>
                        <div class="" id="ctn_custcomplaints" >
                            <?php include 'globaldata/qtrreport_custcomplaints.php'; ?>
                        </div>

                        <!--diagnostic stats (why did it happen / what did our team do?)-->
                        <div class="pagebreak_before"></div>
                        <?php include 'globaldata/qtrreport_pageheader.php'; ?>
                        <div class="card">

                            <div id="ctn_custauditcount">
                                <div class="card-header h2">Large Customer Team Performance</div>
                                <div class="col-sm-5" style="padding-top: 15px">
                                    <h4 class="card-title mb-0">Audits Completed</h4>
                                    <div class="small text-muted"><?php echo $startdate . ' thru ' . $curdate ?></div>
                                </div>
                                <?php include 'globaldata/cust_audit_count.php'; ?>
                            </div>
                            <div id="ctn_top3salesplans" class=" ">
                                <div class="col-sm-5" style="padding-top: 15px">
                                    <h4 class="card-title mb-0">High Impact Salesplan Performance</h4>
                                </div>
                                <div class="row"style="margin: 15px">
                                    <?php include 'globaldata/top3salesplans.php'; ?>
                                </div>
                            </div>

                        </div>



                        <!--predictive stats(what will happen next?)-->
                        <div class="pagebreak_before"></div>
                        <?php include 'globaldata/qtrreport_pageheader.php'; ?>
                        <div class="card">

                            <div class="card-header h2">Top 10 Fill Rate Opportunities</div>
                            <?php include 'algorithms/qtr_report_topfr.php'; ?>

                            <div class="card-body">
                                <div class="row">
                                    <!--Count of items still at risk-->
                                    <div class="col-xs-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="stat-widget-four">
                                                    <div class="stat-icon dib">
                                                        <i class="ti-alert text-danger border-danger"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <div class="text-left dib">
                                                            <div class="stat-heading"><strong><?php echo $atrisktotl ?> </strong>of 10</div>
                                                            <div class="stat-text">Items At Risk</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Potential fill rate hits per day until corrected-->
                                    <div class="col-xs-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="stat-widget-four">
                                                    <div class="stat-icon dib">
                                                        <i class="ti-alert text-danger border-danger"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <div class="text-left dib">
                                                            <div class="stat-heading"><strong><?php echo $totfrhits ?> </strong></div>
                                                            <div class="stat-text">Est. Daily Fill Rate Hits</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Total orders currently on BO-->
                                    <div class="col-xs-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="stat-widget-four">
                                                    <div class="stat-icon dib">
                                                        <i class="ti-alert text-danger border-danger"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <div class="text-left dib">
                                                            <div class="stat-heading"><strong><?php echo $totunitsonbo ?> </strong></div>
                                                            <div class="stat-text">Total BOs</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-responsive-sm table-hover table-outline mb-0">
                                    <tbody>
                                        <?php foreach ($array_to_pfr as $key => $value) { ?>
                                            <tr class="<?php echo $array_to_pfr[$key]['table_class']; ?>" style="margin-bottom: 10px;">
                                                <td class="spaceUnder">
                                                    <div><strong><?php echo $array_to_pfr[$key]['ITEM']; ?></strong></div>
                                                    <div class="small">
                                                        <div><?php echo $array_to_pfr[$key]['ITEM_DESC']; ?></div>
                                                        <div>Whse: <?php echo $array_to_pfr[$key]['whse_string']; ?></div> 
                                                    </div>
                                                </td>
                                                <td class="spaceUnder">
                                                    <div><strong>Units on Backorder: <?php echo $array_to_pfr[$key]['inv_boq']; ?></strong></div>
                                                    <div class="small">Units Available: <?php echo $array_to_pfr[$key]['inv_onhand']; ?> </div>
                                                    <div class="small">Units on Order: <?php echo $array_to_pfr[$key]['inv_onorder']; ?></div>
                                                </td>
                                                <td class="spaceUnder">
                                                    <div class="clearfix">
                                                        <div class="float-left">
                                                            <strong><?php echo $array_to_pfr[$key]['perc_remain'] ?>%</strong>
                                                        </div>
                                                        <div class="float-right">
                                                            <small class="text-muted"><?php echo ($array_to_pfr[$key]['DATE_EXPECTED'] == 'N/A' ? 'N/A' : date('M j, Y', strtotime($array_to_pfr[$key]['DATE_EXPECTED']))) . ' - ' . ($array_to_pfr[$key]['DATE_LATEST'] == 'N/A' ? 'N/A' : date('M j, Y', strtotime($array_to_pfr[$key]['DATE_LATEST']))); ?></small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar <?php echo $array_to_pfr[$key]['color_prgbar'] ?>" role="progressbar" style="width: <?php echo $array_to_pfr[$key]['perc_remain'] ?>%" aria-valuenow="<?php echo $array_to_pfr[$key]['perc_remain'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="spaceUnder">
                                                    <div><strong><?php echo $array_to_pfr[$key]['atrisk']; ?></strong></div>
                                                    <div class="small"><?php echo $array_to_pfr[$key]['atrisk_desc']; ?></div>
                                                    <div class="small"><?php echo $array_to_pfr[$key]['atrisk_desc2']; ?></div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </main>
            </div>


            <!--prescriptive stats(how can we make it happen?)-->


            <script>
                $('#sparkline0').sparkline('html', {
                    width: '300px',
                    height: 70,
                    lineColor: '#0083CD',
                    fillColor: false,
                    tooltip: false
                });
                $('#sparkline1').sparkline('html', {
                    width: '300px',
                    height: 70,
                    lineColor: '#0083CD',
                    fillColor: false,
                    tooltip: false
                });
                $('#sparkline2').sparkline('html', {
                    width: '300px',
                    height: 70,
                    lineColor: '#0083CD',
                    fillColor: false,
                    tooltip: false
                });
                $('#sparkline3').sparkline('html', {
                    width: '300px',
                    height: 70,
                    lineColor: '#0083CD',
                    fillColor: false,
                    tooltip: false
                });

                $(window).resize(function (e) {
                    $('#sparkline0').css('width', '50%');
                });

                Highcharts.chart('gauge_custtrend', {

                    chart: {
                        type: 'gauge',
                        plotBackgroundColor: null,
                        plotBackgroundImage: null,
                        plotBorderWidth: 0,
                        plotShadow: false
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: ' '
                    },

                    pane: {
                        startAngle: -90,
                        endAngle: 90,
                        background: [{
                                backgroundColor: {
                                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                    stops: [
                                        [0, '#FFF'],
                                        [1, '#333']
                                    ]
                                },
                                borderWidth: 0,
                                outerRadius: '109%'
                            }, {
                                backgroundColor: {
                                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                    stops: [
                                        [0, '#333'],
                                        [1, '#FFF']
                                    ]
                                },
                                borderWidth: 1,
                                outerRadius: '107%'
                            }, {
                                // default background
                            }, {
                                backgroundColor: '#DDD',
                                borderWidth: 0,
                                outerRadius: '105%',
                                innerRadius: '103%'
                            }]
                    },

                    // the value axis
                    yAxis: {
                        min: -20,
                        max: 20,

                        minorTickInterval: 'auto',
                        minorTickWidth: 1,
                        minorTickLength: 10,
                        minorTickPosition: 'inside',
                        minorTickColor: '#666',

                        tickPixelInterval: 30,
                        tickWidth: 2,
                        tickPosition: 'inside',
                        tickLength: 10,
                        tickColor: '#666',
                        labels: {
                            step: 2,
                            rotation: 'auto'
                        },

                        plotBands: [{
                                from: -20,
                                to: -5,
                                color: '#DF5353' // green
                            }, {
                                from: -5,
                                to: 5,
                                color: '#DDDF0D' // yellow
                            }, {
                                from: 5,
                                to: 20,
                                color: '#55BF3B' // red
                            }]
                    },

                    series: [{
                            name: 'Speed',
                            data: [<?php echo intval($totalscoretrend_m * 100) ?>]
                        }]

                },
                        // Add some life
                                function (chart) {
                                    if (!chart.renderer.forExport) {
                                        setInterval(function () {
                                            var point = chart.series[0].points[0],
                                                    newVal,
                                                    inc = Math.round((Math.random() - 0.5) * 20);

                                            newVal = point.y + inc;
                                            if (newVal < 0 || newVal > 200) {
                                                newVal = point.y - inc;
                                            }
                                            var newVal = <?php echo intval($totalscoretrend_m * 100) ?>;
                                            point.update(newVal);

                                        }, 3000);
                                    }
                                });

                        //Chart options and ajax for labor hours by hour
                        function highchartoptions() {
                            //Highchart variables for total hours not printed history
                            var options = {
                                chart: {
                                    marginTop: 50,
                                    marginBottom: 130,
                                    renderTo: 'ctn_scorehistogram',
                                    type: 'column',
                                    zoomType: 'x',
                                    height: 600
                                },
                                credits: {
                                    enabled: false
                                },
                                legend: {
                                    enabled: false
                                },
                                plotOptions: {
                                    series: {
                                        dataLabels: {
                                            enabled: true
                                        }
                                    }
                                },
                                title: {
                                    text: 'Large Customer Scores - Histogram'
                                },
                                xAxis: {
                                    categories: [],
                                    title: {
                                        text: 'Customer Score Range'
                                    },
                                    labels: {
                                        rotation: -90,
                                        y: 25,
                                        align: 'right',
                                        style: {
                                            fontSize: '12px',
                                            fontFamily: 'Verdana, sans-serif'
                                        }
                                    },
                                    minTickInterval: 1,
                                    legend: {
                                        y: "10",
                                        x: "5"
                                    }

                                },
                                yAxis: {
                                    opposite: true,
                                    min: 0,
                                    title: {
                                        text: 'Count of Customers'
                                    },
                                    labels: {
                                        formatter: function () {
                                            return this.value;
                                        }
                                    }
                                },

                                tooltip: {
                                    formatter: function () {
                                        return '<b>' + this.series.name + ': </b>' + this.y;
                                    }
                                },
                                series: []
                            };
                            $.ajax({
                                url: 'globaldata/graphdata_scorehistogram.php',
                                type: 'GET',
                                dataType: 'json',
                                async: 'true',
                                success: function (json) {
                                    options.xAxis.categories = json[0]['data'];
                                    options.series[0] = json[1];

                                    chart = new Highcharts.Chart(options);
                                    series = chart.series;
                                    $(window).resize();
                                }
                            });
                        }

                        $(document).ready(function () {
                            highchartoptions();
                        });

            </script>

        </body>
    </html>