<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Box Delivery Times</title>
        <?php include_once 'headerincludes.php'; ?>
        <style>
            /* Toggle switch styling */
            .switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 34px;
                vertical-align: middle;
                margin-bottom: 0;
            }
            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: .4s;
                border-radius: 34px;
            }
            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                transition: .4s;
                border-radius: 50%;
            }
            input:checked + .slider {
                background-color: #dc3545;
            }
            input:focus + .slider {
                box-shadow: 0 0 1px #dc3545;
            }
            input:checked + .slider:before {
                transform: translateX(26px);
            }
            .toggle-label {
                margin-left: 10px;
                font-weight: normal;
            }
        </style>
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
                        <div class="col-md-4 col-sm-4 col-xs-12 col-lg-4 col-xl-4 d-flex align-items-center" style="margin-top: 23px;">
                            <label class="switch">
                                <input type="checkbox" id="toggleLateOnly" checked>
                                <span class="slider"></span>
                            </label>
                            <span class="toggle-label">Show Late Shipments Only</span>
                        </div>
                    </div>
                </div>

                <div id="hidewrapper" class="hidden">
                <!--Header summary info-->
                <div class="row">
                    <div id="tntheader" class=""></div>
                </div>

                <!--TNT Datatable-->
                <div class="hidewrapper">
                    <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                        <header class="panel-heading bg-inverse"> Box Delivery Detail<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_deldetail"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                        <div class="panel-body">
                            <div id="container_deldetail" class="">
                                <table id="dt_deldetail" class="table table-bordered table-striped" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                                    <thead>
                                        <tr>
                                            <th>Sales Plan</th>
                                            <th>Bill To</th>
                                            <th>Ship To</th>
                                            <th>Whse</th>
                                            <th>WCS #</th>
                                            <th>WO #</th>
                                            <th>Box #</th>
                                            <th>Box Size</th>
                                            <th>Ship Zone</th>
                                            <th>Tracer #</th>
                                             <th style="min-width: 80px">Ship Date/Time</th>
                                             <th style="min-width: 80px">Deliver Date/Time</th>
                                            <th style="min-width: 125px">Carrier</th>
                                            <th>Should Days in Transit</th>
                                            <th>Actual Days in Transit</th>
                                            <th>Late?</th>
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
                $('#hidewrapper').addClass('hidden'); 
                //fill the tnt table
                var salesplan = $('#salesplan').val();
                var showLateOnly = $('#toggleLateOnly').is(':checked') ? 1 : 0;
                
                oTable4 = $('#dt_deldetail').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[5, "desc"]],
                    "scrollX": true,
                    'sAjaxSource': "globaldata/data_deliverytimes.php?salesplan=" + salesplan + "&late=" + showLateOnly,
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ],
                    "columnDefs": [
                        {
                            "targets": 9, // Tracer column index
                            "render": function (data, type, row) {
                                // For display and filter/search, render HTML as-is
                                if (type === 'display' || type === 'filter') {
                                    return data;
                                }
                                // For sorting/type detection, remove HTML
                                return data ? data.replace(/<[^>]*>/g, '') : data;
                            }
                        }
                    ],
                    "initComplete": function(settings, json) {
                        // Add hover effect for UPS tracking links - target all tracking links
                        $('#dt_deldetail').on('mouseenter', 'a[href*="ups.com/track"]', function() {
                            $(this).css({
                                'background-color': '#f0f0f0', 
                                'box-shadow': '0 1px 3px rgba(0,0,0,0.1)',
                                'transform': 'translateY(-1px)'
                            });
                        }).on('mouseleave', 'a[href*="ups.com/track"]', function() {
                            $(this).css({
                                'background-color': '#f8f8f8',
                                'box-shadow': 'none',
                                'transform': 'translateY(0)'
                            });
                        });
                    }
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
                
                // Add event listener for the toggle switch
                $('#toggleLateOnly').on('change', function() {
                    if ($('#salesplan').val()) {
                        gettable();
                    }
                });
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


        </script>
    </body>
</html>
