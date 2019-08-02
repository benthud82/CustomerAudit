<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>My Dashboard</title>
        <?php include_once 'headerincludes.php'; ?>
    </head>
    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>
        <?php
        include_once 'connection/connection_details.php';
        ?>

        <section id="content"> 
            <section class="main padder"> 

                <div class="col-sm-12">
                    <div class="hidewrapper">
                        <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                            <header class="panel-heading bg-info h3" style="margin: 0px"> SKU Opt Panel <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_skuoptpanel"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                            <div class="panel-body" >

                                <div class="row" style=" padding-top: 20px;">
                                    <!--Sku Opt Algorithm results listings-->
                                    <div class="col-xl-6 col-sm-12">
                                        <div class="hidewrapper">
                                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                                <header class="panel-heading bg-danger"> SKU Opt Recommendations <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_skuopttable"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                                <div class="panel-body">
                                                    <div id="skuopttablecontainer" class="">
                                                        <table id="skuopttable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Take Action</th>
                                                                    <th>ID</th>
                                                                    <th>Whse</th>
                                                                    <th>Item</th>
                                                                    <th>Item Desc.</th>
                                                                    <th>30 Day Picks</th>
                                                                    <th>365 Day Picks</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>

                                    <!--Sku Opt Tracking statistics-->
                                    <div class="col-xl-6 col-sm-12">
                                        <div class="hidewrapper">
                                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                                <header class="panel-heading bg-danger"> SKU Opt Statistics <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_skuopstats"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                                <div class="panel-body">
                                                    <div id="skuoptstatscontainer" class="">
                                                        <!--Results for skuopt goes here-->
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>

                                <!--Sku Opt Opportunity graph-->
                                <section class="panel hidewrapper" id="graph_skuoptrecs" style="margin-bottom: 50px;"> 
                                    <header class="panel-heading bg bg-danger">Historical Sku Opt Recommendations<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_skuoptgraph"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                                    <div id="panelbody_skuopt" class="panel-body" style="background: #efefef">
                                        <div id="chartpage_skuopt"  class="page-break" style="width: 100%">
                                            <div id="charts padded">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="alert alert-success" style="font-size: 100%;"> <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button> <i class="fa fa-arrow-down fa-lg"></i><span> Positive improvement indicated by <strong>downward</strong> trending graph. </span></div>
                                                    </div>
                                                </div>
                                                <div id="container_skuopt" class="dashboardstyle printrotate"></div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                            </div>
                        </section>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="hidewrapper">
                        <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                            <header class="panel-heading bg-info h3" style="margin: 0px"> Damage Panel <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_damagepanel"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                            <div class="panel-body">
                                <div class="row" style=" padding-top: 20px;">
                                    <!--Damage Algorithm results listings-->
                                    <div class="col-xl-6 col-sm-12">
                                        <div class="hidewrapper">
                                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                                <header class="panel-heading bg-danger"> Damage Recommendations <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_damagettable"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                                <div class="panel-body">
                                                    <div id="damagetablecontainer" class="">
                                                        <table id="damagetable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Take Action</th>
                                                                    <th>ID</th>
                                                                    <th>Whse</th>
                                                                    <th>Item</th>
                                                                    <th>Item Desc.</th>
                                                                    <th>30 Day Damage Acc.</th>
                                                                    <th>30 Day Damage Count</th>
                                                                    <th>90 Day Damage Acc.</th>
                                                                    <th>90 Day Damage Count</th>
                                                                    <th>365 Day Damage Acc.</th>
                                                                    <th>365 Day Damage Count.</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>

                                    <!--Damage Opt Tracking statistics-->
                                    <div class="col-xl-6 col-sm-12">
                                        <div class="hidewrapper">
                                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                                <header class="panel-heading bg-danger"> Damage Statistics <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_damagestats"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                                <div class="panel-body">
                                                    <div id="damagestatscontainer" class="">
                                                        <!--Results for skuopt goes here-->
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>


                                <!--Damage Opportunity graph-->
                                <section class="panel hidewrapper" id="graph_damagerecs" style="margin-bottom: 50px;"> 
                                    <header class="panel-heading bg bg-danger">Historical Damage Recommendations<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_damagegraph"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                                    <div id="panelbody_damage" class="panel-body" style="background: #efefef">
                                        <div id="chartpage_damage"  class="page-break" style="width: 100%">
                                            <div id="charts padded">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="alert alert-success" style="font-size: 100%;"> <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button> <i class="fa fa-arrow-down fa-lg"></i><span> Positive improvement indicated by <strong>downward</strong> trending graph. </span></div>
                                                    </div>
                                                </div>
                                                <div id="container_damages" class="dashboardstyle printrotate"></div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                            </div>
                        </section>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="hidewrapper">
                        <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                            <header class="panel-heading bg-info h3" style="margin: 0px"> Shipping Accuracy Panel <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_damagepanel"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                            <div class="panel-body">
                                <div class="row" style=" padding-top: 20px;">
                                    <!--Shipping Accuracy Algorithm results listings-->
                                    <div class="col-xl-6 col-sm-12">
                                        <div class="hidewrapper">
                                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                                <header class="panel-heading bg-danger"> Shipping Accuracy Recommendations <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_shipaccttable"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                                <div class="panel-body">
                                                    <div id="shipacctablecontainer" class="">
                                                        <table id="shipacctable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Take Action</th>
                                                                    <th>ID</th>
                                                                    <th>Whse</th>
                                                                    <th>Item</th>
                                                                    <th>Item Desc.</th>
                                                                    <th>30 Day Ship Acc.</th>
                                                                    <th>30 Day Ship Acc. Count.</th>
                                                                    <th>90 Day Ship Acc.</th>
                                                                     <th>90 Day Ship Acc. Count.</th>
                                                                    <th>365 Day Ship Acc.</th>
                                                                     <th>365 Day Ship Acc. Count.</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>

                                    <!--Ship Opt Tracking statistics-->
                                    <div class="col-xl-6 col-sm-12">
                                        <div class="hidewrapper">
                                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                                <header class="panel-heading bg-danger"> Shipping Accuracy  Statistics <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_shipaccstats"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                                <div class="panel-body">
                                                    <div id="shipaccstatscontainer" class="">
                                                        <!--Results for shipacc goes here-->
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>


                                <!--Ship Acc Opportunity graph-->
                                <section class="panel hidewrapper" id="graph_shipaccrecs" style="margin-bottom: 50px;"> 
                                    <header class="panel-heading bg bg-danger">Historical Shipping Accuracy Recommendations<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_shipaccgraph"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                                    <div id="panelbody_shipacc" class="panel-body" style="background: #efefef">
                                        <div id="chartpage_shipacc"  class="page-break" style="width: 100%">
                                            <div id="charts padded">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="alert alert-success" style="font-size: 100%;"> <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button> <i class="fa fa-arrow-down fa-lg"></i><span> Positive improvement indicated by <strong>downward</strong> trending graph. </span></div>
                                                    </div>
                                                </div>
                                                <div id="container_shipacc" class="dashboardstyle printrotate"></div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                            </div>
                        </section>
                    </div>
                </div>
                <!-- Take Action Modal -->
                <div id="takeaction" class="modal fade " role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Take Action</h4>
                            </div>
                            <form class="form-horizontal" id="postaction">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="col-md-3 hidden">
                                            <!--ID of the assigned comment to pass to post.php-->
                                            <input type="text" name="assidmodal" id="assidmodal" class="form-control" placeholder="" />
                                            <input type="text" name="algorithmmodal" id="algorithmmodal" class="form-control" placeholder="" />
                                            <input type="text" name="itemnummodal" id="itemnummodal" class="form-control" placeholder=""/>
                                            <input type="text" name="whsnummodal" id="whsnummodal" class="form-control" placeholder=""/>
                                            <input type="text" name="useridmodal" id="useridmodal" class="form-control" placeholder=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-3 control-label">Corrective Action Taken?</label>
                                            <div class="switch-field col-md-9">
                                                <input type="radio" id="switch_left" name="switch_2" value="yes" checked/>
                                                <label for="switch_left" class="greenbackground">Yes</label>
                                                <input type="radio" id="switch_right" name="switch_2" value="no" />
                                                <label id="nolabel" for="switch_right">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Comment:</label>
                                        <div class="col-md-9">
                                            <textarea rows="2" placeholder="Enter brief description of action taken..." class="form-control" id="comment_actiontaken" name="comment_actiontaken" tabindex="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg pull-left" name="submititemaction" id="submititemaction">Mark Item Complete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </section>
        </section>




        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            $("#dash").addClass('active');

            //Toggle take action modal SKUOPT
            $(document).on("click", ".skuoptclick", function (e) {
                var mytable = $("#skuopttable").DataTable();
                $('#takeaction').modal('toggle');
                debugger;
                //assign all variables to modal divs for posting
                $('#useridmodal').val($('#userid').text());
                $('#assidmodal').val($(this).attr("id"));

                var tr = $(this).closest("tr");
                var rowindex = tr.index();
                var itemnummodal = mytable.row(rowindex).data()[3];
                $('#itemnummodal').val(itemnummodal);

                var whsnummodal = mytable.row(rowindex).data()[2];
                $('#whsnummodal').val(whsnummodal);
                $('#algorithmmodal').val('SKUOPT');
            });

            //Toggle take action modal DAMAGE
            $(document).on("click", ".damageclick", function (e) {
                var mytable = $("#damagetable").DataTable();
                $('#takeaction').modal('toggle');
                debugger;
                //assign all variables to modal divs for posting
                $('#useridmodal').val($('#userid').text());
                $('#assidmodal').val($(this).attr("id"));

                var tr = $(this).closest("tr");
                var rowindex = tr.index();
                var itemnummodal = mytable.row(rowindex).data()[3];
                $('#itemnummodal').val(itemnummodal);

                var whsnummodal = mytable.row(rowindex).data()[2];
                $('#whsnummodal').val(whsnummodal);
                $('#algorithmmodal').val('DAMAGE');
            });

            //Toggle take action modal SHIPACC
            $(document).on("click", ".shipaccclick", function (e) {
                var mytable = $("#shipacctable").DataTable();
                $('#takeaction').modal('toggle');
                debugger;
                //assign all variables to modal divs for posting
                $('#useridmodal').val($('#userid').text());
                $('#assidmodal').val($(this).attr("id"));

                var tr = $(this).closest("tr");
                var rowindex = tr.index();
                var itemnummodal = mytable.row(rowindex).data()[3];
                $('#itemnummodal').val(itemnummodal);

                var whsnummodal = mytable.row(rowindex).data()[2];
                $('#whsnummodal').val(whsnummodal);
                $('#algorithmmodal').val('SHIPACC');
            });


            //post item action button clicked for SKUOPT
            $(document).on("click", "#submititemaction", function (event) {
                debugger;
                event.preventDefault();
                var algorithm = $('#algorithmmodal').val();
                var assigntask_id = $('#assidmodal').val();
                var comment = $('#comment_actiontaken').val();
                var useridmodal = $('#useridmodal').val();
                if (document.getElementById('switch_left').checked) {
                    var actiontaken = 1;
                } else {
                    var actiontaken = 0;
                }
                var whsemodal = $('#whsnummodal').val();
                var itemmodal = $('#itemnummodal').val();


                var formData = 'itemmodal=' + itemmodal + '&whsemodal=' + whsemodal + '&actiontaken=' + actiontaken + '&useridmodal=' + useridmodal + '&algorithm=' + algorithm + '&assigntask_id=' + assigntask_id + '&comment=' + comment;
                $.ajax({
                    url: 'formpost/postmassalgorithmaction.php',
                    type: 'POST',
                    data: formData,
                    success: function (result) {
                        $('#addcommentmodal').modal('hide');
                        location.reload();

                    }
                });
            });


            //On close of action modal, clear all fields and toggle hidden
            $('.modal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });


            //options for Sku Opt highchart
            var options3 = {
                chart: {
                    marginTop: 50,
                    marginBottom: 135,
                    renderTo: 'container_skuopt',
                    type: 'spline'
                }, credits: {
                    enabled: false
                },
                plotOptions: {
                    spline: {
                        marker: {
                            enabled: false
                        }
                    },
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
//                                        location.href = '7MovesDetail.php?date=' + this.category + '&type=' + this.series.name + '&formSubmit=Submit';
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
                        step: 5,
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
                    title: {
                        text: 'Sku Opt Recommendation Count'
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
                                this.x + ': ' + Highcharts.numberFormat(this.y, 0);
                    }
                },
                series: []
            };
            $.ajax({
                url: 'globaldata/dashboardgraph_skuopt.php',
                type: 'GET',
                dataType: 'json',
                async: 'true',
                success: function (json) {
                    options3.xAxis.categories = json[0]['data'];
                    options3.series[0] = json[1];


                    chart = new Highcharts.Chart(options3);
                    series = chart.series;
//                    $(window).resize();
                    $(window).trigger('resize');
                }
            });
            $(window).trigger('resize');
            
            //options for Damages highchart
            var options4 = {
                chart: {
                    marginTop: 50,
                    marginBottom: 135,
                    renderTo: 'container_damages',
                    type: 'spline'
                }, credits: {
                    enabled: false
                },
                plotOptions: {
                    spline: {
                        marker: {
                            enabled: false
                        }
                    },
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
//                                        location.href = '7MovesDetail.php?date=' + this.category + '&type=' + this.series.name + '&formSubmit=Submit';
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
                        step: 5,
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
                    title: {
                        text: 'Damage Recommendation Count'
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
                                this.x + ': ' + Highcharts.numberFormat(this.y, 0);
                    }
                },
                series: []
            };
            $.ajax({
                url: 'globaldata/dashboardgraph_damage.php',
                type: 'GET',
                dataType: 'json',
                async: 'true',
                success: function (json) {
                    options4.xAxis.categories = json[0]['data'];
                    options4.series[0] = json[1];


                    chart = new Highcharts.Chart(options4);
                    series = chart.series;
                    $(window).resize();
                }
            });

            //options for Ship Acc highchart
            var options5 = {
                chart: {
                    marginTop: 50,
                    marginBottom: 135,
                    renderTo: 'container_shipacc',
                    type: 'spline'
                }, credits: {
                    enabled: false
                },
                plotOptions: {
                    spline: {
                        marker: {
                            enabled: false
                        }
                    },
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
//                                        location.href = '7MovesDetail.php?date=' + this.category + '&type=' + this.series.name + '&formSubmit=Submit';
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
                        step: 5,
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
                    title: {
                        text: 'Ship Accuracy Recommendation Count'
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
                                this.x + ': ' + Highcharts.numberFormat(this.y, 0);
                    }
                },
                series: []
            };
            $.ajax({
                url: 'globaldata/dashboardgraph_shipacc.php',
                type: 'GET',
                dataType: 'json',
                async: 'true',
                success: function (json) {
                    options5.xAxis.categories = json[0]['data'];
                    options5.series[0] = json[1];


                    chart = new Highcharts.Chart(options5);
                    series = chart.series;
                    $(window).resize();
                }
            });

            $(document).ready(function () {
                //skuopt recs table population
                oTable = $('#skuopttable').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "order": [[6, "desc"]],
                    "scrollX": true,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(0)', nRow).append("<div class='text-center'><i id='" + aData[1] + "'   class='fa fa-check skuoptclick' style='cursor: pointer;     margin-right: 5px;' data-toggle='tooltip' data-title='Click to Take Action' data-placement='top' data-container='body' ></i> </div>");
                    },
                    "columnDefs": [
                        {
                            "targets": [1],
                            "visible": false,
                            "searchable": false,
                            "orderable": true
                        }
                    ],
                    'sAjaxSource': "globaldata/ma_skuopt_table.php",
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5'
                    ]
                });

                //damage recs table population
                oTable2 = $('#damagetable').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "order": [[10, "desc"]],
                    "scrollX": true,
                    "fnCreatedRow": function (nRow2, aData2, iDataIndex2) {
                        $('td:eq(0)', nRow2).append("<div class='text-center'><i id='" + aData2[1] + "'   class='fa fa-check damageclick' style='cursor: pointer;     margin-right: 5px;' data-toggle='tooltip' data-title='Click to Take Action' data-placement='top' data-container='body' ></i> </div>");
                    },
                    "columnDefs": [
                        {
                            "targets": [1],
                            "visible": false,
                            "searchable": false,
                            "orderable": true
                        }
                    ],
                    'sAjaxSource': "globaldata/ma_damage_table.php",
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5'
                    ]
                });

                //ship acc recs table population
                oTable3 = $('#shipacctable').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "order": [[10, "desc"]],
                    "scrollX": true,
                    "fnCreatedRow": function (nRow2, aData2, iDataIndex2) {
                        $('td:eq(0)', nRow2).append("<div class='text-center'><i id='" + aData2[1] + "'   class='fa fa-check shipaccclick' style='cursor: pointer;     margin-right: 5px;' data-toggle='tooltip' data-title='Click to Take Action' data-placement='top' data-container='body' ></i> </div>");
                    },
                    "columnDefs": [
                        {
                            "targets": [1],
                            "visible": false,
                            "searchable": false,
                            "orderable": true
                        }
                    ],
                    'sAjaxSource': "globaldata/ma_shipacc_table.php",
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5'
                    ]
                });

                //populate skuopt stats
                $.ajax({
                    url: 'globaldata/skuoptstats.php',
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#skuoptstatscontainer").html(ajaxresult);
                    }
                });

                //populate damage stats
                $.ajax({
                    url: 'globaldata/damagestats.php',
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#damagestatscontainer").html(ajaxresult);
                    }
                });

                //populate ship acc stats
                $.ajax({
                    url: 'globaldata/shipaccstats.php',
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#shipaccstatscontainer").html(ajaxresult);
                    }
                });
                
                $('.panel-body.container').css('display','none');

//                $(".clicktotoggle-chevron").click(function () {
//                    $(this).next().slideToggle("slow");
//                                       
//                    $(window).trigger('resize');
//                });

            });

        </script>
    </body>
</html>
