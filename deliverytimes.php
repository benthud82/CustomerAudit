<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Box Delivery Times</title>
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
                                            <th style="min-width: 250px">Ship To Name</th>
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
                oTable4 = $('#dt_deldetail').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[5, "desc"]],
                    "scrollX": true,
                    'sAjaxSource': "globaldata/data_deliverytimes.php?salesplan=" + salesplan,
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


        </script>
    </body>
</html>
