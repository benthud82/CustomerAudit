
function loadfillratehighchart_salesplan(numtype, salesplan) {
    var numtype = numtype;
    var salesplan = salesplan;
    //options for fillrate highchart
    var options = {
        chart: {
            marginTop: 50,
            marginBottom: 115,
            renderTo: 'frcontainer',
            type: 'spline'
        }, credits: {
            enabled: false
        },
        plotOptions: {
            series: {
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    verticalAlign: 'top',
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function () {
                        return Highcharts.numberFormat(this.y, 2) + ' %';
                    }
                },
                point: {
                    events: {
                        click: function () {
                        }
                    }
                }
            }
        },
        title: {
            text: ' '
        },
        xAxis: {
            categories: [], labels: {
                rotation: -90,
                y: 25,
                align: 'right',
                step: 1,
                style: {
                    fontSize: '12px',
                    fontFamily: 'Verdana, sans-serif'
                }
            },
            legend: {
                y: "10",
                x: "5"
            }

        },
        yAxis: {
            max: 100,
            title: {
                text: 'Fill Rate Percentage'
            },
            plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }],
            opposite: true
        }, tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                        this.x + ': ' + Highcharts.numberFormat(this.y, 2) + ' %';
            }
        },
        series: []
    };
    $.ajax({
        url: 'globaldata/graphdata_' + numtype + '.php',
        data: {"salesplan": salesplan},
        type: 'GET',
        dataType: 'json',
        async: 'true',
        success: function (json) {
            options.xAxis.categories = json[0]['data'];
            options.series[0] = json[1];
            options.series[1] = json[2];
            chart = new Highcharts.Chart(options);
            series = chart.series;
        }
    });
}

function loadcustreturnsratehighchart_salesplan(numtype, salesplan) {
    var numtype = numtype;
    var salesplan = salesplan;
    //options for custreturns highchart
    var options2 = {
        chart: {
            marginTop: 50,
            marginBottom: 115,
            renderTo: 'container_custret',
            type: 'spline'
        }, credits: {
            enabled: false
        },
        plotOptions: {
            series: {
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    verticalAlign: 'top',
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function () {
                        return Highcharts.numberFormat(this.y, 2) + ' %';
                    }
                },
                point: {
                    events: {
                        click: function () {
                        }
                    }
                }
            }
        },
        title: {
            text: ' '
        },
        xAxis: {
            categories: [], labels: {
                rotation: -90,
                y: 25,
                align: 'right',
                step: 1,
                style: {
                    fontSize: '12px',
                    fontFamily: 'Verdana, sans-serif'
                }
            },
            legend: {
                y: "10",
                x: "5"
            }

        },
        yAxis: {
            max: 100,
            title: {
                text: 'Customer Returns Percentage'
            },
            plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }],
            opposite: true
        }, tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                        this.x + ': ' + Highcharts.numberFormat(this.y, 2) + ' %';
            }
        },
        series: []
    };
    $.ajax({
        url: 'globaldata/graphdata_custreturns.php',
        data: {"salesplan": salesplan, "custtype": 'salesplan'},
        type: 'GET',
        dataType: 'json',
        async: 'true',
        success: function (json) {
            options2.xAxis.categories = json[0]['data'];
            options2.series[0] = json[1];
            options2.series[1] = json[2];
            options2.series[2] = json[3];
            chart = new Highcharts.Chart(options2);
            series = chart.series;
        }
    });
}

function loadfillratehighchart_billto(numtype, salesplan) {
    var numtype = numtype;
    var billto = salesplan;
                //options for fillrate highchart
                var options = {
                    chart: {
                        marginTop: 50,
                        marginBottom: 115,
                        renderTo: 'frcontainer',
                        type: 'spline'
                    }, credits: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                verticalAlign: 'top',
                                color: '#000000',
                                connectorColor: '#000000',
                                formatter: function () {
                                    return Highcharts.numberFormat(this.y, 2) + ' %';
                                }
                            },
                            point: {
                                events: {
                                    click: function () {
                                    }
                                }
                            }
                        }
                    },
                    title: {
                        text: ' '
                    },
                    xAxis: {
                        categories: [], labels: {
                            rotation: -90,
                            y: 25,
                            align: 'right',
                            step: 1,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        },
                        legend: {
                            y: "10",
                            x: "5"
                        }

                    },
                    yAxis: {
                        max: 100,
                        title: {
                            text: 'Fill Rate Percentage'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }],
                        opposite: true
                    }, tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                    this.x + ': ' + Highcharts.numberFormat(this.y, 2) + ' %';
                        }
                    },
                    series: []
                };
                $.ajax({
                    url: 'globaldata/graphdata_' + numtype + '.php',
                    data: {"billto": billto},
                    type: 'GET',
                    dataType: 'json',
                    async: 'true',
                    success: function (json) {
                        options.xAxis.categories = json[0]['data'];
                        options.series[0] = json[1];
                        options.series[1] = json[2];
                        chart = new Highcharts.Chart(options);
                        series = chart.series;
                    }
                });

}

function loadcustreturnsratehighchart_billto(numtype, salesplan) {

    var billto = salesplan;
                //options for custreturns highchart
                var options2 = {
                    chart: {
                        marginTop: 50,
                        marginBottom: 115,
                        renderTo: 'container_custret',
                        type: 'spline'
                    }, credits: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                verticalAlign: 'top',
                                color: '#000000',
                                connectorColor: '#000000',
                                formatter: function () {
                                    return Highcharts.numberFormat(this.y, 2) + ' %';
                                }
                            },
                            point: {
                                events: {
                                    click: function () {
                                    }
                                }
                            }
                        }
                    },
                    title: {
                        text: ' '
                    },
                    xAxis: {
                        categories: [], labels: {
                            rotation: -90,
                            y: 25,
                            align: 'right',
                            step: 1,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        },
                        legend: {
                            y: "10",
                            x: "5"
                        }

                    },
                    yAxis: {
                        max: 100,
                        title: {
                            text: 'Customer Returns Percentage'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }],
                        opposite: true
                    }, tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                    this.x + ': ' + Highcharts.numberFormat(this.y, 2) + ' %';
                        }
                    },
                    series: []
                };
                $.ajax({
                    url: 'globaldata/graphdata_custreturns.php',
                    data: {"salesplan": billto, "custtype": 'billto'},
                    type: 'GET',
                    dataType: 'json',
                    async: 'true',
                    success: function (json) {
                        options2.xAxis.categories = json[0]['data'];
                        options2.series[0] = json[1];
                        options2.series[1] = json[2];
                        options2.series[2] = json[3];
                        chart = new Highcharts.Chart(options2);
                        series = chart.series;
                    }
                });
}

function loadfillratehighchart_shipto(numtype, salesplan) {
    var numtype = numtype;
    var shipto = salesplan;
                //options for fillrate highchart
                var options = {
                    chart: {
                        marginTop: 50,
                        marginBottom: 115,
                        renderTo: 'frcontainer',
                        type: 'spline'
                    }, credits: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                verticalAlign: 'top',
                                color: '#000000',
                                connectorColor: '#000000',
                                formatter: function () {
                                    return Highcharts.numberFormat(this.y, 2) + ' %';
                                }
                            },
                            point: {
                                events: {
                                    click: function () {
                                    }
                                }
                            }
                        }
                    },
                    title: {
                        text: ' '
                    },
                    xAxis: {
                        categories: [], labels: {
                            rotation: -90,
                            y: 25,
                            align: 'right',
                            step: 1,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        },
                        legend: {
                            y: "10",
                            x: "5"
                        }

                    },
                    yAxis: {
                        max: 100,
                        title: {
                            text: 'Fill Rate Percentage'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }],
                        opposite: true
                    }, tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                    this.x + ': ' + Highcharts.numberFormat(this.y, 2) + ' %';
                        }
                    },
                    series: []
                };
                $.ajax({
                    url: 'globaldata/graphdata_' + numtype + '.php',
                    data: {"shipto": shipto},
                    type: 'GET',
                    dataType: 'json',
                    async: 'true',
                    success: function (json) {
                        options.xAxis.categories = json[0]['data'];
                        options.series[0] = json[1];
                        options.series[1] = json[2];
                        chart = new Highcharts.Chart(options);
                        series = chart.series;
                    }
                });



}

function loadcustreturnsratehighchart_shipto(numtype, salesplan) {
    var shipto = salesplan;
                //options for custreturns highchart
                var options2 = {
                    chart: {
                        marginTop: 50,
                        marginBottom: 115,
                        renderTo: 'container_custret',
                        type: 'spline'
                    }, credits: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                verticalAlign: 'top',
                                color: '#000000',
                                connectorColor: '#000000',
                                formatter: function () {
                                    return Highcharts.numberFormat(this.y, 2) + ' %';
                                }
                            },
                            point: {
                                events: {
                                    click: function () {
                                    }
                                }
                            }
                        }
                    },
                    title: {
                        text: ' '
                    },
                    xAxis: {
                        categories: [], labels: {
                            rotation: -90,
                            y: 25,
                            align: 'right',
                            step: 1,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        },
                        legend: {
                            y: "10",
                            x: "5"
                        }

                    },
                    yAxis: {
                        max: 100,
                        title: {
                            text: 'Customer Returns Percentage'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }],
                        opposite: true
                    }, tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                    this.x + ': ' + Highcharts.numberFormat(this.y, 2) + ' %';
                        }
                    },
                    series: []
                };
                $.ajax({
                    url: 'globaldata/graphdata_custreturns.php',
                    data: {"salesplan": shipto, "custtype": 'shipto'},
                    type: 'GET',
                    dataType: 'json',
                    async: 'true',
                    success: function (json) {
                        options2.xAxis.categories = json[0]['data'];
                        options2.series[0] = json[1];
                        options2.series[1] = json[2];
                        options2.series[2] = json[3];
                        chart = new Highcharts.Chart(options2);
                        series = chart.series;
                    }
                });
}