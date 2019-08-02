<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Search</title>
        <?php include_once 'headerincludes.php'; ?>
    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>


        <section id="content"> 
            <section class="main padder"> 

                <div class="row" style="padding-bottom: 25px; padding-top: 20px;">
                    <div class="col-lg-3">
                        <div class="pull-left" style="margin-left: 15px" >
                            <label>Enter Search Term:</label>
                            <input name='searchterm' class='selectstyle' id='searchterm'/>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pull-left" style="margin-left: 15px" >
                            <button id="loaddata" type="button" class="btn btn-primary" onclick="getsearchdata();" style="margin-bottom: 5px;">Load Data</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!--Sales Plan listing results-->
                    <div class="hidewrapper">
                        <div class="col-md-12 col-lg-6">
                            <section class="panel hidden" id="resultwrapper_salesplan" style="margin-bottom: 50px; margin-top: 20px;"> 
                                <header class="panel-heading bg bg-inverse h5">Sales Plan Results<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="salesplanresults_close"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                                <div id="summary_salesplan" class="panel-body">
                                    <div id="resultcontainer_salesplan" class="table-striped">
                                        <!--Result from ajax goes here-->
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <!--Ship Plan listing results-->
                    <div class="hidewrapper">
                        <div class="col-md-12 col-lg-6">
                            <section class="panel hidden" id="resultwrapper_shipto" style="margin-bottom: 50px; margin-top: 20px;"> 
                                <header class="panel-heading bg bg-inverse h5">Ship To Results<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="shiptoresults_close"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                                <div id="summary_shipto" class="panel-body">
                                    <div id="resultcontainer_shipto" class="table-striped">
                                        <!--Result from ajax goes here-->
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            $('body').tooltip({
                selector: '[rel=tooltip]'
            });
            $("#modules").addClass('active'); //add active strip to audit on vertical nav

            function getsearchdata() {
                var searchterm = $('#searchterm').val();

                //search bill to table and 
                $('#resultwrapper_salesplan').removeClass('hidden');
                $('#resultwrapper_shipto').removeClass('hidden');
                $.ajax({
                    url: 'globaldata/search_billto.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {searchterm: searchterm}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#resultcontainer_salesplan").html(ajaxresult);
                    }
                });

                $.ajax({
                    url: 'globaldata/search_shipto.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {searchterm: searchterm}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#resultcontainer_shipto").html(ajaxresult);
                    }
                });
            }

        </script>

    </body>
</html>


