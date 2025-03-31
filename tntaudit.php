<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Time-in-Transit Audit</title>
        <?php include_once 'headerincludes.php'; ?>
    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>


        <section id="content"> 
            <section class="main padder" style="padding-top: 100px"> 

                <!--Options to select customer type and input customer number/name-->
                <div class="" style="padding-bottom: 25px; padding-top: 20px;">
                    <div class="row" style="padding-bottom: 25px;"> 
                        <div class="col-md-4 col-sm-4 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <label>Enter Salesplan</label>
                            <input type="text" name="salesplan" id="salesplan" class="form-control" placeholder="" tabindex="0"/>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <button id="loaddata" type="button" class="btn btn-primary" onclick="gettable();" style="margin: 23px 0px 0px 0px;" tabindex="0">Load Data</button>
                        </div>
                    </div>
                </div>

                <!--Header summary info-->
                <div class="row">
                    <div id="tntheader" class=""></div>
                </div>

                <div id="hidewrapper" class="hidden">
                    <!--TNT Datatable-->
                    <div class="hidewrapper">
                        <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                            <header class="panel-heading bg-inverse"> Time in Transit - Ship to<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_comptasks"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                            <div class="panel-body">
                                <div id="container_dtshipto" class="">
                                    <table id="dt_tntontime" class="table table-bordered table-striped" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                                        <thead>
                                            <tr>
                                                <th>Bill To</th>
                                                <th>Ship To</th>
                                                <th style="min-width: 250px">Ship to Name</th>
                                                <th>Avg Days in Transit</th>
                                                <th>Late Deliveries</th>
                                                <th>Total Deliveries</th>
                                                <th>Percent On-Time</th>
                                                <th>View Detailed Report</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!--Order Frequency datatable-->
                    <div class="hidewrapper">
                        <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                            <header class="panel-heading bg-inverse"> Order Frequency - Ship to<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_ordfreq"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                            <div class="panel-body">
                                <div id="container_dtordfreq" class="">
                                    <table id="dt_ordfreq" class="table table-bordered table-striped " cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                                        <thead>
                                            <tr>
                                                <th>Bill To</th>
                                                <th>Ship To</th>
                                                <th style="min-width: 250px">Ship to Name</th>
                                                <th>Total Orders Month</th>
                                                <th>Weekly Avg Orders - Month</th>
                                                <th>Total Orders Quarter</th>
                                                <th>Weekly Avg Orders - Qtr</th>
                                                <th>Total Orders Year</th>
                                                <th>Weekly Avg Orders - Year</th>
                                                <th data-toggle='tooltip' title='Positive number indicates increased order frequency.' data-placement='top' data-container='body'>Avg Order Increase - Year to Month Comparison</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            $("#modules").addClass('active');
            function gettable() {
                //fill the tnt table
                $('#hidewrapper').addClass('hidden');
                var salesplan = $('#salesplan').val();
                oTable4 = $('#dt_tntontime').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[5, "desc"]],
                    "scrollX": true,
                    'sAjaxSource': "globaldata/data_tntshipto.php?salesplan=" + salesplan,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(7)', nRow).append("<div class='text-center'><i class='fa fa-external-link extlink_deliveryreport' style='cursor: pointer;' data-toggle='tooltip' data-title='View detailed delivery data' data-placement='top' data-container='body'></i></div>");
                    },
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });

                //fill the order frequency table
                oTable5 = $('#dt_ordfreq').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "rowCallback": function (row, data, index) {
                        if (data[9] > 0) {
                            $('td', row).eq(9).addClass('recentcomment');
                        }
                    },

                    "order": [[4, "desc"]],
                    "scrollX": true,
                    'sAjaxSource': "globaldata/data_ordfreq.php?salesplan=" + salesplan,
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });

                $('#hidewrapper').removeClass('hidden');
            }

            function ajax_tntheader(salesplan) {
                //Trend calc and current score average info box
                $.ajax({
                    url: 'globaldata/data_tntheader.php',
                    type: 'POST',
                    dataType: 'html',
                    data: {salesplan: salesplan},
                    success: function (result) {
                        $("#tntheader").html(result);
                    }
                });
            }

            //Place this in the document ready function to determine if there is search variables in the URL.  
            //Must clean the URL after load to prevent looping
            $(document).ready(function () {
                if (window.location.href.indexOf("salesplan") > -1) {
                    var salesplannum = GetUrlValue('salesplan');
                    getsalesplandata(salesplannum); //pass the 
                    gettable(); //call the gettable function if the salesplan and item are populated 
                }
            });

            //parse URL to pull variable defined
            function GetUrlValue(VarSearch) {
                var SearchString = window.location.search.substring(1);
                var VariableArray = SearchString.split('&');
                for (var i = 0; i < VariableArray.length; i++) {
                    var KeyValuePair = VariableArray[i].split('=');
                    if (KeyValuePair[0] === VarSearch) {
                        return KeyValuePair[1];
                    }
                }
            }

            //billtopost comes from url
            function getsalesplandata(salesplannum) {
                if (typeof salesplannum !== 'undefined') {
                    var salesplan = salesplannum;
                } else {
                    var salesplan = $('#salesplan').val();
                }
                fillsalesplanval(salesplan); //fill the whse drop down
                cleanurl(); //clean the URL of post data
            }

            //fill item input text
            function fillsalesplanval(salesplannum) {
                document.getElementById("salesplan").value = salesplannum;
            }

            //clean the URL if called from another page
            function cleanurl() {
                var clean_uri = location.protocol + "//" + location.host + location.pathname;
                window.history.replaceState({}, document.title, clean_uri);
            }

            //external link clicked for tnt audit report
            $(document).on("click", ".extlink_deliveryreport", function (e) {
                var salesplan = $('#salesplan').val();
                getsalesplan(salesplan);
            });

            function getsalesplan(salesplan) {
                var url = "deliverytimes.php?salesplan=" + salesplan;
                
                // Get the date range from the current page if available
                if (typeof $('#startdate').val() !== 'undefined' && typeof $('#enddate').val() !== 'undefined') {
                    url += "&start_date=" + $('#startdate').val() + "&end_date=" + $('#enddate').val();
                }
                
                window.open(url, '_blank');
            }

        </script>
    </body>
</html>
