<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Large Customer Quarterly Report</title>

        <meta charset="utf-8">

        <script src="js/offsys_dash.js" type="text/javascript"></script>
        <script src="js/globalscripts.js" type="text/javascript"></script>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <!--<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">-->


        <script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.6/jq-2.2.3/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
        <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.6/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.css"/>-->

<!--<script src="../highcharts.js" type="text/javascript"></script>-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="shortcut icon" type="image/ico" href="../favicon.ico" />  
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">-->
        <link href="osscss/offsys_dash.css" rel="stylesheet" type="text/css"/>
        <!--<link href="osscss/offsys_personal.css" rel="stylesheet" type="text/css"/>-->
        <script src="js/jszip.js" type="text/javascript"></script>
        <!--<style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>-->
        <!--<link href="../BootstrapXL.css" rel="stylesheet" type="text/css"/>-->
        <script src="https://code.highcharts.com/highcharts.src.js"></script>
        <script src="../highcharts-more.js" type="text/javascript"></script>
        <script src="../jquery-ui.js"></script>

        <!--        <link rel="stylesheet" type="text/css" href="osscss/print.css" media="print">-->

        <?php include_once 'functions/customer_audit_functions.php'; ?>
        <link rel="stylesheet" type="text/css" href="osscss/print.css" media="print">
        <style>
            @media print {
                @page {size: portrait}
                -webkit-print-color-adjust: exact;
            </style>

        </head>

        <body style="">

            <img src="../henry-schein-7x4 cropped.jpg" style="width:333px;height:42px;">

            <section id="content"> 
                <section class="main padder"> 

                    <!--descriptive stats (what happened?)-->
                    <div class="row">
                        <?php include 'globaldata/qtr_report_descriptive.php'; ?>
                        <div class="col-xs-6">
                            <div id="gauge_custtrend" style="min-width: 310px; max-width: 300px; height: 225px; margin: 0 auto"></div>
                        </div>
                    </div>
                    <div class="" id="ctn_scorehistogram" style="width: 800px; height: 600px;"></div>


                    <!--diagnostic stats (why did it happen / what did our team do?)-->
                    <div id="ctn_custauditcount" class="pagebreak_before">
                        <div class="h2" style="margin-left: 50px;">Audits Performed</div>
                        <?php include 'globaldata/cust_audit_count.php'; ?>
                    </div>
                    <div id="ctn_top3salesplans" class=" ">
                        <div class="h2" style="margin-left: 50px;">High Impact Salesplan Performance</div>
                        <?php include 'globaldata/top3salesplans.php'; ?>
                    </div>
                    <!--predictive stats(what will happen next?)-->
                    <div class="pagebreak_before" >

                        <div class="progress-group">
                            <div class="progress-group-header">
                                <i class="icon-user progress-group-icon"></i>
                                <div>Male</div>
                                <div class="ml-auto font-weight-bold">43%</div>
                            </div>
                            <div class="progress-group-bars">
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <div id="pred_top_fr">
                            <div class="h2" style="margin-left: 50px;">Top 10 Fill Rate Opportunities</div>
                            <?php include 'algorithms/qtr_report_topfr.php'; ?>
                        </div>

                        <table class="table" style="">
                            <tbody>

                                <?php foreach ($array_to_pfr as $key => $value) { ?>
                                    <tr>
                                        <td>
                                            <div><strong><?php echo $array_to_pfr[$key]['ITEM']; ?></strong></div>
                                            <div class="small text-muted"><?php echo $array_to_pfr[$key]['ITEM_DESC']; ?></div>
                                            <div class="small text-muted">Whse: <?php echo $array_to_pfr[$key]['whse_string']; ?></div>
                                        </td>
                                        <td class="text-small">
                                            <div>Units Available: <strong><?php echo $array_to_pfr[$key]['inv_onhand']; ?></strong></div>
                                            <div>Units on Order: <strong><?php echo $array_to_pfr[$key]['inv_onorder']; ?></strong></div>
                                            <div>Units on Backorder: <strong><?php echo $array_to_pfr[$key]['inv_boq']; ?></strong></div>
                                        </td>

                                        <td class="">
                                            <div><strong><?php echo $array_to_pfr[$key]['atrisk']; ?></strong><?php echo $array_to_pfr[$key]['atrisk_desc']; ?></div>
                                            <div>Estimated Fill Rate Hits: Between <strong><?php echo $array_to_pfr[$key]['frhits_expected'] . ' and ' . $array_to_pfr[$key]['frhits_max']; ?></strong></div>
                                        </td>
                                    </tr>
                                    <tr class="<?php echo $array_to_pfr[$key]['table_class']; ?>" style="margin-bottom: 25px;">
                                        <td colspan="3">    
                                            <div class="">
                                                <div class="">
                                                    <strong>Oldest PO Date: <?php echo ($array_to_pfr[$key]['PODATE'] == 'N/A' ? 'N/A' : date('M j, Y', strtotime($array_to_pfr[$key]['PODATE']))); ?></strong>
                                                </div>
                                                <div class="">
                                                    <small class="text-muted">Projected Due Date: <strong><?php echo ($array_to_pfr[$key]['DATE_EXPECTED'] == 'N/A' ? 'N/A' : date('M j, Y', strtotime($array_to_pfr[$key]['DATE_EXPECTED']))) . ' - ' . ($array_to_pfr[$key]['DATE_LATEST'] == 'N/A' ? 'N/A' : date('M j, Y', strtotime($array_to_pfr[$key]['DATE_LATEST']))); ?></strong></small>
                                                </div>
                                            </div>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar <?php echo $array_to_pfr[$key]['color_prgbar'] ?>" role="progressbar" style="width: <?php echo $array_to_pfr[$key]['perc_remain'] ?>%" aria-valuenow="<?php echo $array_to_pfr[$key]['perc_remain'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!--prescriptive stats(how can we make it happen?)-->
                </section>
            </section>

            <script>
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
                                        x: "5",
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