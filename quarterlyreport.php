<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Large Customer Quarterly Report</title>
        <?php include_once 'headerincludes.php'; ?>
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
                    <?php include 'globaldata/qtr_report_descriptive.php'; ?>
                    <div id="gauge_custtrend" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto"></div>
                    <div id="ctn_scorehistogram"></div>

                    <!--diagnostic stats (why did it happen?)-->

                    <!--predictive stats(what will happen next?)-->

                    <!--prescriptive stats(how can we make it happen?)-->
                </section>
            </section>


            <script>
                $("body").tooltip({selector: '[data-toggle="tooltip"]'});



            </script>



            <script>
                $("#modules").addClass('active');


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
                        text: 'Customer Score Trend'
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
                                plotOptions: {
                                    series: {
                                        dataLabels: {
                                            enabled: true
                                        }
                                    }
                                },
                                title: {
                                    text: ' '
                                },
                                xAxis: {
                                    categories: [],
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
                                        text: 'Slotting Moves Executed'
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
