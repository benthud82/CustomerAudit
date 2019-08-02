<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>

        <title>Ship-To Check</title>
        <?php include_once 'headerincludes.php'; ?>
        <?php include_once 'globaldata/modal_loading.php'; ?>
        <link href="../jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="osscss/print.css" media="print">

        <style>
            .table>tbody>tr>td {white-space: nowrap}
            .fa{padding-left: 1px;}
        </style>
    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>


        <section id="content"> 
            <section class="main padder"> 

                <!--Enter shipto # and submit-->
                <div class="row" style="padding-bottom: 25px; padding-top: 20px;"> 
                    <div class="col-lg-3">
                        <div class="pull-left" style="margin-left: 15px" >
                            <label>Ship To:</label>
                            <input name='shipto' class='selectstyle' id='shipto'/>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pull-left" style="margin-left: 15px" >
                            <button id="loaddata" type="button" class="btn btn-primary" onclick="gettable();" style="margin-bottom: 5px;">Load Data</button>
                            <div class="btn-group">
                                <button id="printdata" type="button" class="btn btn-inverse hidden" onclick="printdata();" style="margin-bottom: 5px; margin-left: 10px;">Print Data</button>
                                <!--<button id="printdata" type="button" class="btn btn-inverse" onclick="printdata();" style="margin-bottom: 5px;">?</button>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div id="showclosesummary" class="hidden showhidden" style="cursor: pointer;">Show Summary</div>
                    </div>
                    <div class="col-lg-1">
                        <div id="showcloseshiptotable" class="hidden showhidden" style="cursor: pointer;">Show Ship-To's</div>
                    </div>
                    <div class="col-lg-1">
                        <div id="showclosetopfillrate" class="hidden showhidden" style="cursor: pointer;">Show Top Fill Rate</div>
                    </div>
                    <div class="col-lg-1">
                        <div id="showcloseoscimpacts" class="hidden showhidden" style="cursor: pointer;">Show OSC Impacts</div>
                    </div>
                </div>

                <div id="markcompletecontainer"></div>
                <div id="customernameinfo" class="hidden"></div>
                <div id="documentupload" class="hidden"></div>

                <!--Scorecard summary data by month/qtr/r12-->
                <div class="hidewrapper">
                    <section class="panel hidden" id="shiptowrapper" style="margin-bottom: 50px; margin-top: 20px;"> 
                        <header class="panel-heading bg bg-inverse h2">Scorecard Data<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="closesummary"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                        <div id="salesplansummary" class="panel-body" style="background: #efefef">
                            <!--populate from ajax call in getcustomerdata function-->
                            <div class="customersummary" id="customersummary"></div>
                        </div>
                    </section>
                </div>



                <!--Change start / end date-->
                <div class="row hidden" id="datechanger">
                    <div class="col-lg-12">
                        <div class="alert alert-success">                
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4 col-xl-3">
                                        <h4>
                                            Change Start Date:
                                            <input name="startfiscal_frimpacts" id="startfiscal_frimpacts" class="selectstyle" style="cursor: pointer; max-width: 120px;" value="<?php echo date('Y-m-d', strtotime('-30 days')); ?>"/>
                                        </h4>
                                    </div>
                                    <div class="col-lg-4 col-xl-3">
                                        <h4>
                                            Change End Date:
                                            <input name="startfiscal_frimpacts" id="endfiscal_frimpacts" class="selectstyle" style="cursor: pointer; max-width: 120px;" value="<?php echo date('Y-m-d'); ?>"/>
                                        </h4>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="pull-left" style="margin-left: 15px" >
                                            <button id="loaddata_datechange" type="button" class="btn btn-primary" onclick="gettable();" style="margin-bottom: 5px;">Load Data</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row hidden" id="fillrateandosc">
                    <!--Top fill rate impacts by item-->
                    <div class="hidewrapper">
                        <div class="col-lg-6">
                            <section class="panel" id="fillratewrapper" style="margin-bottom: 50px; margin-top: 20px;"> 
                                <header class="panel-heading bg bg-inverse h2">Fill Rate Impacts<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="closetopfillrate"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>

                                <div id="fillratepanelbody" class="panel-body">
                                    <!--Note about impacts for previous 30 days-->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="alert alert-info"><h5><i class='fa fa-info-circle fa-lg'></i> Defaults to previous <strong>30</strong> calendar days unless start date changed. </h5></div>
                                        </div>
                                    </div>
                                    <div id="fillratetablecontainer" class="">
                                        <table id="fillratetable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri; cursor: pointer;">
                                            <thead>
                                                <tr>
                                                    <th>Take Action</th>
                                                    <th>Item</th>
                                                    <th>Item Description</th>
                                                    <th>Non-Stock</th>
                                                    <th>Backorder</th>
                                                    <th>Stocking Cross Ship</th>
                                                    <th>NSI Cross Ship</th>
                                                    <th>Total Hits</th>
                                                    <th>Recent Audit</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </section>
                        </div>
                    </div>
                    <!--Order shipped complete analysis-->
                    <div class="hidewrapper">
                        <div class="col-lg-6">
                            <section class="panel" id="oscwrapper" style="margin-bottom: 50px; margin-top: 20px;"> 
                                <header class="panel-heading bg bg-inverse h2">Order Ship Complete Data<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="closeosc"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>

                                <div id="oscpanelbody" class="panel-body">
                                    <!--Note about impacts for previous 30 days-->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="alert alert-info"><h5><i class='fa fa-info-circle fa-lg'></i> Defaults to previous <strong>30</strong> calendar days unless start date changed. </h5></div>
                                        </div>
                                    </div>
                                    <div id="osctablecontainer" class="">
                                        <table id="osctable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri; cursor: pointer;">
                                            <thead>
                                                <tr>
                                                    <th>JDE Num</th>
                                                    <th>Bill To</th>
                                                    <th>Ship To</th>
                                                    <th>Order Date</th>
                                                    <th>Fill Rate Hits</th>
                                                    <th>Invoice Lines</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </section>
                        </div>
                    </div>
                </div>

                <div class="row hidden" id="custreturnstables">
                    <!--Top customer returns impacts by item-->
                    <div class="hidewrapper">
                        <div class="col-lg-6">
                            <section class="panel" id="custreturnsimpactwrapper" style="margin-bottom: 50px; margin-top: 20px;"> 
                                <header class="panel-heading bg bg-inverse h2">Customer Returns Impacts<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="closetopcustreturns"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>

                                <div id="custreturnsimpactbody" class="panel-body">
                                    <!--Note about impacts for previous 90 days-->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="alert alert-info"><h5><i class='fa fa-info-circle fa-lg'></i> Defaults to previous <strong>30</strong> calendar days unless start date changed. </h5></div>
                                        </div>
                                    </div>
                                    <div id="custreturnsimpactcontainer" class="">
                                        <table id="custreturnsimpacttable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri; cursor: pointer;">
                                            <thead>
                                                <tr>
                                                    <th>Take Action</th>
                                                    <th>Item</th>
                                                    <th data-toggle='tooltip' title='DC - WRONG ITEM SHIPPED' data-placement='top' data-container='body'>WISP</th>
                                                    <th data-toggle='tooltip' title='DC - WRONG QUANITITY SHIPPED' data-placement='top' data-container='body'>WQSP</th>
                                                    <th data-toggle='tooltip' title='ITEM INVOICED BUT NOT SHIPPED' data-placement='top' data-container='body'>IBNS</th>
                                                    <th data-toggle='tooltip' title='DAMAGED PRODUCT - DELIVERED' data-placement='top' data-container='body'>CRID</th>
                                                    <th data-toggle='tooltip' title='DAMAGED PRODUCT - NOT DELIVERED' data-placement='top' data-container='body'>TDRN</th>
                                                    <th data-toggle='tooltip' title='DC - SHIPPED EXPIRED PRODUCT' data-placement='top' data-container='body'>EXPR</th>
                                                    <th data-toggle='tooltip' title='SHORT DATED - NOT SATISFIED' data-placement='top' data-container='body'>SDAT</th>
                                                    <th data-toggle='tooltip' title='RECEIVED TOO HOT OR FROZEN' data-placement='top' data-container='body'>TEMP</th>
                                                    <th data-toggle='tooltip' title='LOST IN TRANSIT' data-placement='top' data-container='body'>LITR</th>
                                                    <th data-toggle='tooltip' title='SALES - WRONG ITEM ORDERED' data-placement='top' data-container='body'>WIOD</th>
                                                    <th data-toggle='tooltip' title='ITEM INVOICED BUT NOT ORDERED' data-placement='top' data-container='body'>IBNO</th>
                                                    <th data-toggle='tooltip' title='CUSTOMER CANCELLED / REFUSED' data-placement='top' data-container='body'>CNCL</th>
                                                    <th data-toggle='tooltip' title='NO REASON SPECIFIED' data-placement='top' data-container='body'>NRSP</th>
                                                    <th data-toggle='tooltip' title='SALES - WRONG QUANTITY ORDERED' data-placement='top' data-container='body'>WQTY</th>
                                                    <th data-toggle='tooltip' title='MANIFESTED' data-placement='top' data-container='body'>TPRX</th>
                                                    <th>Total Returns</th>
                                                    <th>Recent Audit</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </section>
                        </div>
                    </div>
                    <!--Order shipped complete analysis-->
                    <div class="hidewrapper">
                        <div class="col-lg-6">
                            <section class="panel" id="custreturnsdetailwrapper" style="margin-bottom: 50px; margin-top: 20px;"> 
                                <header class="panel-heading bg bg-inverse h2">Customer Returns Detail<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="closereturnsdetail"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>

                                <div id="custreturnsdetailpanelbody" class="panel-body">
                                    <!--Note about impacts for previous 90 days-->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="alert alert-info"><h5><i class='fa fa-info-circle fa-lg'></i> Defaults to previous <strong>30</strong> calendar days unless start date changed. </h5></div>
                                        </div>
                                    </div>
                                    <div id="returnsdetailtablecontainer" class="">
                                        <table id="returnsdetailtable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri; cursor: pointer;">
                                            <thead>
                                                <tr>
                                                    <th>Take Action</th>
                                                    <th>Item Code</th>
                                                    <th>Bill To</th>
                                                    <th>Ship To</th>
                                                    <th>WCS#</th>
                                                    <th>Work Ord #</th>
                                                    <th>Order#</th>
                                                    <th>Ship Date</th>
                                                    <th>Return Code</th>
                                                    <th>Return Date</th>
                                                    <th>Metric</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </section>
                        </div>
                    </div>
                </div>

                <!--Fill rate graph-->
                <div class="hidewrapper">
                    <section class="panel hidden" id="fillrategraphwrapper" style="margin-bottom: 50px; margin-top: 20px;"> 
                        <header class="panel-heading bg bg-inverse h2">Fill Rate Graph<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="closefillrategraph"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                        <div id="fillrategraph" class="panel-body" style="background: #efefef">


                            <div id="chartpage"  class="page-break" style="width: 100%">
                                <div id="charts padded">
                                    <div id="frcontainer" class="largecustchartstyle printrotate"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!--Customer Returns  graph-->
                <div class="hidewrapper">
                    <section class="panel hidden" id="custretgraphwrapper" style="margin-bottom: 50px; margin-top: 20px;"> 
                        <header class="panel-heading bg bg-inverse h2">Customer Returns Graph<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="closecustretgraph"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                        <div id="custretgraph" class="panel-body" style="background: #efefef">


                            <div id="chartpage_custret"  class="page-break" style="width: 100%">
                                <div id="charts_custret padded">
                                    <div id="container_custret" class="largecustchartstyle printrotate"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Add Comment Modal -->
                <div id="addcommentmodal" class="modal fade " role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Item Comment</h4>
                            </div>
                            <form class="form-horizontal" id="postitemaction">
                                <div class="modal-body">
                                    <div class="form-group hidden">
                                        <div class="col-md-9">
                                            <!--Fill the user group with 'billto' for tracking--> 
                                            <input type="text" name="usergroupmodal" id="usergroupmodal" class="form-control" />  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Ship To:</label>
                                        <div class="col-md-9">
                                            <input type="text" name="shiptomodal" id="shiptomodal" class="form-control" placeholder="Enter Ship To..." tabindex="1" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Item:</label>
                                        <div class="col-md-9">
                                            <input type="text" name="itemmodal" id="itemmodal" class="form-control" placeholder="Enter Item Code..." tabindex="2"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">TSM:</label>
                                        <div class="col-md-9">
                                            <input type="text" name="useridmodal" id="useridmodal" class="form-control" placeholder="Enter TSM ID..." tabindex="3"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="checkbox-inline"><input type="checkbox" value=""  id="checkboxim" class="checkboxtoggle">IM Opportunity</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="checkbox-inline"><input type="checkbox" value=""  id="checkboxdc" class="checkboxtoggle">DC Opportunity</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="checkbox-inline"><input type="checkbox" value=""  id="checkboxsc" class="checkboxtoggle">SC Opportunity</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="checkbox-inline"><input type="checkbox" value=""  id="checkboxother" class="checkboxtoggle">Other Opportunity</label>
                                        </div>
                                    </div>
                                    <!--hidden data for IM Opportunity-->
                                    <div class="hiddencheckboxdata hidden" id="hiddendatacheckboxim">
                                        <div class="formpadder">
                                            <h5 style="padding-bottom: 5px;" class="boldtext">Assign and enter comment for Inventory Management</h5>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Assigned IM TSM:</label>
                                                <div class="col-md-9">
                                                    <?php include 'globaldata/dropdown_userid_IM.php'; ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Comment for IM:</label>
                                                <div class="col-md-9">
                                                    <textarea rows="2" placeholder="Enter Comment for IM..." class="form-control" id="comment_im" name="comment_im" tabindex="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--hidden data for DC Opportunity-->
                                    <div class="hiddencheckboxdata hidden" id="hiddendatacheckboxdc">
                                        <div class="formpadder">
                                            <h5 style="padding-bottom: 5px;" class="boldtext">Assign and enter comment for the Distribution Center</h5>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Assigned DC TSM:</label>
                                                <div class="col-md-9">
                                                    <?php include 'globaldata/dropdown_userid_DC.php'; ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Comment for the DC:</label>
                                                <div class="col-md-9">
                                                    <textarea rows="2" placeholder="Enter Comment for the DC..." class="form-control" id="comment_dc" name="comment_dc" tabindex="7"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--hidden data for SC Opportunity-->
                                    <div class="hiddencheckboxdata hidden" id="hiddendatacheckboxsc">
                                        <div class="formpadder">
                                            <h5 style="padding-bottom: 5px;" class="boldtext">Assign and enter comment for Supply Chain</h5>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Assigned SC TSM:</label>
                                                <div class="col-md-9">
                                                    <?php include 'globaldata/dropdown_userid_SC.php'; ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Comment for SC:</label>
                                                <div class="col-md-9">
                                                    <textarea rows="2" placeholder="Enter Comment for SC..." class="form-control" id="comment_sc" name="comment_sc" tabindex="9"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--hidden data for Other Opportunity-->
                                    <div class="hiddencheckboxdata hidden" id="hiddendatacheckboxother">
                                        <div class="formpadder">
                                            <h5 style="padding-bottom: 5px;" class="boldtext">Assign and enter comment for Other Issue</h5>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Assigned Other TSM:</label>
                                                <div class="col-md-9">
                                                    <?php include 'globaldata/dropdown_userid_OTHER.php'; ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Comment for Other:</label>
                                                <div class="col-md-9">
                                                    <textarea rows="2" placeholder="Enter Comment for Other..." class="form-control" id="comment_other" name="comment_other" tabindex="11"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="modal-footer">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg pull-left" name="submititemaction" id="submititemaction">Add Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mark as Audited Modal -->
                <div id="markauditcompletemodal" class="modal fade " role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Mark Ship-to as Audited</h4>
                            </div>
                            <form class="form-horizontal" id="postbilltoaudited">
                                <div class="modal-body">


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Comment:</label>
                                        <div class="col-md-9">
                                            <textarea rows="3" placeholder="Enter Comment (optional)..." class="form-control" id="comment_audit" name="comment_audit" tabindex="1"></textarea>
                                        </div>
                                    </div>
                                </div>



                                <div class="modal-footer">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg pull-left" name="submitauditcomplete" id="submitauditcomplete">Mark as Audited</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </section>
        </section>

        <script>

            $('#startfiscal_frimpacts').datepicker({
                dateFormat: 'yy-mm-dd'
//                onSelect: function (selected, evnt) {
//                    gettable(selected);
//                }
            });

            $('#endfiscal_frimpacts').datepicker({
                dateFormat: 'yy-mm-dd'
//                onSelect: function (selected, evnt) {
//                    gettable(selected);
//            }
            });


            $(document).on("click", "#upload_submit", function (event) {
                event.preventDefault();
                var file = $('#fileToUpload').get(0).files[0];
                var formData = new FormData();
                formData.append('file', file);

                var upload_custtype = $('#upload_custtype').val();
                var upload_custid = $('#upload_custid').val();
                formData.append('upload_custtype', upload_custtype);
                formData.append('upload_custid', upload_custid);


                //ajax for uload document panel
                $.ajax({
                    url: 'upload.php',
                    type: 'POST',
                    data: formData,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success: function (data) {
                        console.log(data);
                        loaduploadmodule();
                        alert(data);
                    }
                });
            });

            function gettable() {
                
//                if (typeof (startdate) !== "undefined" && startdate !== null) {
//                    var selectedstartdate = startdate;
//                } else {
//                    selectedstartdate = 0;
//                }
                var startdate = $('#startfiscal_frimpacts').val();
                var enddate = $('#endfiscal_frimpacts').val();
                var shipto = $('#shipto').val();
                var numtype = 'shipto';


                //ajax for Mark as audited button and modal for recent audits
                $.ajax({
                    url: 'globaldata/auditcount_shipto.php',
                    data: {shipto: shipto}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#markcompletecontainer").html(ajaxresult);
                    }
                });


                //ajax for customer name info
                $.ajax({
                    url: 'globaldata/customerinfodata.php',
                    data: {shipto: shipto, numtype: numtype}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#customernameinfo").html(ajaxresult);
                    }
                });

                //shipto table ajax 
                $('#fillrategraphwrapper').removeClass('hidden');
                $('#fillrateandosc').removeClass('hidden');
                $('#custreturnstables').removeClass('hidden');
                $('#auditcompleterow').removeClass('hidden');
                $('#custretgraphwrapper').removeClass('hidden');
                $('#customernameinfo').removeClass('hidden');
                $("#clickedlinkdata").hide(); //hide any of the clicked detail links
                $('#chartpage').removeClass('hidden'); //show the chart as it is populating through ajax
                $('#datechanger').removeClass('hidden');

                $('#documentupload').removeClass('hidden');
                //ajax for #salesplansummary
                $.ajax({
                    url: 'globaldata/custscorecarddata_' + numtype + '.php', //url for the ajax.  Variable numtype is either salesplan, shipto, shipto
                    data: {shipto: shipto}, //pass salesplan, shipto, shipto all through shipto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#customersummary").html(ajaxresult);
                    }
                });
                $('#shiptowrapper').removeClass('hidden'); //show the summary salesplan data



                oTable2 = $('#fillratetable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
//                    dom: 'frltip',
                    destroy: true,
                    "rowCallback": function (row, data, index) {
                        if (data[8] !== " ") {
                            $(row).addClass('recentcomment');
                        }
                    },
                    "order": [[7, "desc"]],
                    "scrollX": true,
                    'sAjaxSource': "globaldata/fillrateissues.php?shipto=" + shipto + "&startdate=" + startdate + "&enddate=" + enddate,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(0)', nRow).append("<div class='text-center'><i class='fa fa-check commentclick' style='cursor: pointer;' data-toggle='tooltip' data-title='Add Task' data-placement='top' data-container='body' ></i> <i class='fa fa-cog clickitemcheck' style='cursor: pointer;' data-toggle='tooltip' data-title='Run Item Check' data-placement='top' data-container='body'></i></div>");
                    },
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });

                oTable3 = $('#osctable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
//                    dom: 'frltip',
                    destroy: true,
                    "order": [[0, "asc"]],
                    "scrollX": true,
                    'sAjaxSource': "globaldata/table_oscdata.php?shipto=" + shipto + "&startdate=" + startdate + "&enddate=" + enddate,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(7)', nRow).append("<div class='text-center'><i class='fa fa-envelope mailclick' style='cursor: pointer;' data-toggle='tooltip' data-title='Send Message' data-placement='top' data-container='body'></i> <i class='fa fa-comment commentclick' style='cursor: pointer;' data-toggle='tooltip' data-title='Comment' data-placement='top' data-container='body' ></i> <i class='fa fa-ban' style='cursor: pointer;' data-toggle='tooltip' data-title='Remove Item' data-placement='top' data-container='body'></i><i class='fa fa-cog clickitemcheck' style='cursor: pointer;' data-toggle='tooltip' data-title='Run Item Check' data-placement='top' data-container='body'></i></div>");
                    },
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });

                oTable4 = $('#custreturnsimpacttable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
//                    dom: 'frltip',
                    destroy: true,
                    "rowCallback": function (row, data, index) {
                        if (data[18] !== " ") {
                            $(row).addClass('recentcomment');
                        }
                        if (data[2] > 0) {
                            $('td', row).eq(2).addClass('cellshade_blue');
                        }
                        if (data[3] > 0) {
                            $('td', row).eq(3).addClass('cellshade_blue');
                        }
                        if (data[4] > 0) {
                            $('td', row).eq(4).addClass('cellshade_blue');
                        }
                        if (data[5] > 0) {
                            $('td', row).eq(5).addClass('cellshade_blue');
                        }
                        if (data[6] > 0) {
                            $('td', row).eq(6).addClass('cellshade_blue');
                        }
                        if (data[7] > 0) {
                            $('td', row).eq(7).addClass('cellshade_blue');
                        }
                        if (data[8] > 0) {
                            $('td', row).eq(8).addClass('cellshade_blue');
                        }
                        if (data[9] > 0) {
                            $('td', row).eq(9).addClass('cellshade_blue');
                        }
                        if (data[10] > 0) {
                            $('td', row).eq(10).addClass('cellshade_blue');
                        }
                        if (data[11] > 0) {
                            $('td', row).eq(11).addClass('cellshade_blue');
                        }
                        if (data[12] > 0) {
                            $('td', row).eq(12).addClass('cellshade_blue');
                        }
                        if (data[13] > 0) {
                            $('td', row).eq(13).addClass('cellshade_blue');
                        }
                        if (data[14] > 0) {
                            $('td', row).eq(14).addClass('cellshade_blue');
                        }
                        if (data[15] > 0) {
                            $('td', row).eq(15).addClass('cellshade_blue');
                        }
                        if (data[16] > 0) {
                            $('td', row).eq(16).addClass('cellshade_blue');
                        }
                    },
                    "order": [[17, "desc"]],
                    "scrollX": true,
                    'sAjaxSource': "globaldata/custreturnsissues.php?shipto=" + shipto + "&startdate=" + startdate + "&enddate=" + enddate,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(0)', nRow).append("<div class='text-center'><i class='fa fa-check commentclick' style='cursor: pointer;' data-toggle='tooltip' data-title='Add Task' data-placement='top' data-container='body' ></i> <i class='fa fa-cog clickitemcheck' style='cursor: pointer;' data-toggle='tooltip' data-title='Run Item Check' data-placement='top' data-container='body'></i></div>");
                    },
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });

                oTable5 = $('#returnsdetailtable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
//                    dom: 'frltip',
                    destroy: true,
                    "order": [[9, "desc"]],
                    "scrollX": true,
                    'sAjaxSource': "globaldata/custreturnsdetail.php?shipto=" + shipto + "&startdate=" + startdate + "&enddate=" + enddate,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(0)', nRow).append("<div class='text-center'><i class='fa fa-check commentclick' style='cursor: pointer;' data-toggle='tooltip' data-title='Add Task' data-placement='top' data-container='body' ></i> <i class='fa fa-cog clickitemcheck' style='cursor: pointer;' data-toggle='tooltip' data-title='Run Item Check' data-placement='top' data-container='body'></i></div>");
                    },
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });

                loadfillratehighchart_shipto(numtype, shipto);
                loadcustreturnsratehighchart_shipto(numtype, shipto);
                loaduploadmodule();
                 $('#printdata').removeClass('hidden');
            }

            function printdata() {
                $('#modal_loading').modal('toggle');
                var shipto = $('#shipto').val();
                var numtype = 'shipto';
                //ajax for print audit
                $.ajax({
                    url: 'auditprint.php',
                    data: {shipto: shipto, numtype: numtype}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (data) {
                        $('#modal_loading').modal('toggle');
                        var newWin = window.open();
                        newWin.document.write(data);
                        newWin.document.close();
                        setTimeout(function () {
                            newWin.focus();
                        }, 1000);
                        setTimeout(function () {
                            newWin.print();
                        }, 3000);
                    }
                });
            }


            function loaduploadmodule() {
                var shipto = $('#shipto').val();
                var numtype = 'shipto';
                //ajax for document upload module
                $.ajax({
                    url: 'globaldata/documentuploaddata.php',
                    data: {shipto: shipto, numtype: numtype}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#documentupload").html(ajaxresult);
                    }
                });
            }

            $(document).on("click", ".mailclick", function (e) {
//                debugger;
//                alert($(this).closest('tr').find('td:first').text() + ' - ' + $(this).closest('tr').find('td:eq(1)').text());
                alert('Not Active.  Please send email.');
            });

            $(document).on("click", ".clickitemcheck", function (e) {  //open new window for itemcheck.php with get variables for automatic loading
                var itemnum = $(this).closest('tr').find('td:eq(1)').text();
                var shipto = $('#shipto').val();
                var url = "itemcheck.php?itemnum=" + itemnum + "&shipto=" + shipto;
                window.open(url, '_blank');

            });

            //triggered when checkbox is clicked on comment modal.  Toggles additional information to enter for action tracking
            $(document).on("change", ".checkboxtoggle", function (e) {
//                debugger;
                var clickedid = (this.id);
                $('#hiddendata' + clickedid).toggleClass('hidden');

            });

            //jquery to show add comments modal and fill relevant fields with clicked info
            $(document).on("click", ".commentclick", function (e) {
                $('#addcommentmodal').modal('toggle');
                $('#itemmodal').val($(this).closest('tr').find('td:eq(1)').text());
                $('#shiptomodal').val($('#shipto').val());
                $('#useridmodal').val($('#userid').text());
                $('#usergroupmodal').val('shipto');
            });


            $(document).on("click", "#auditcomplete", function (e) {
                $('#markauditcompletemodal').modal('toggle');
            });


            $(document).on("click", "#submitauditcomplete", function (event) {
                event.preventDefault();
                var custalphanum = $('#shipto').val();
                var userid = $('#userid').text();
                var custtype = 'SHIPTO';

                var fillratebefore_month = $('#fillratebefore_month').html();
                var fillrateafter_month = $('#fillrateafter_month').html();
                var shipacc_month = $('#shipacc_month').html();
                var dmgacc_month = $('#dmgacc_month').html();
                var addscacc_month = $('#addscacc_month').html();
                var osc_month = $('#osc_month').html();
                var score_month = $('#score_month').html();
                var score_quarter = $('#score_quarter').html();
                var score_r12 = $('#score_r12').html();
                var comment = $('#comment_audit').val();




                var formData = 'custalphanum=' + custalphanum + '&userid=' + userid + '&fillratebefore_month=' + fillratebefore_month + '&fillrateafter_month=' + fillrateafter_month + '&shipacc_month=' + shipacc_month + '&dmgacc_month=' + dmgacc_month + '&addscacc_month=' + addscacc_month + '&osc_month=' + osc_month
                        + '&score_month=' + score_month + '&score_quarter=' + score_quarter + '&score_r12=' + score_r12 + '&comment=' + comment + '&custtype=' + custtype;
                $.ajax({
                    url: 'formpost/postcompleteaudit.php',
                    type: 'POST',
                    data: formData,
                    success: function (result) {
                        $('#markauditcompletemodal').modal('hide');
                    }
                });

            });



        </script>


        <script>
            function getsalesplandata(shiptonum) { //shiptopost comes from url

                if (typeof shiptonum !== 'undefined') {
                    var shipto = shiptonum;
                } else {
                    var shipto = $('#shipto').val();
                }
                fillsalesplanval(shipto); //fill the whse drop down
                cleanurl(); //clean the URL of post data

            }
        </script>

        <script>

            $(document).on("click", "#submititemaction", function (event) {
                event.preventDefault();
                var salesplan = $('#shiptomodal').val();
                var item = $('#itemmodal').val();
                var userid = $('#useridmodal').val();
                var custgroup = $('#usergroupmodal').val();
                if (document.getElementById('checkboxim').checked) {
                    var checkboxim = 1;
                } else {
                    var checkboxim = 0;
                }
                if (document.getElementById('checkboxdc').checked) {
                    var checkboxdc = 1;
                } else {
                    var checkboxdc = 0;
                }
                if (document.getElementById('checkboxsc').checked) {
                    var checkboxsc = 1;
                } else {
                    var checkboxsc = 0;
                }
                if (document.getElementById('checkboxother').checked) {
                    var checkboxother = 1;
                } else {
                    var checkboxother = 0;
                }

                var assignedtsm_im = $('#assignedtsm_im').val();
                var assignedtsm_dc = $('#assignedtsm_dc').val();
                var assignedtsm_sc = $('#assignedtsm_sc').val();
                var assignedtsm_other = $('#assignedtsm_other').val();
                var comment_im = $('#comment_im').val();
                var comment_dc = $('#comment_dc').val();
                var comment_sc = $('#comment_sc').val();
                var comment_other = $('#comment_other').val();

                var fillratebefore_month = $('#fillratebefore_month').html();
                var fillrateafter_month = $('#fillrateafter_month').html();
                var shipacc_month = $('#shipacc_month').html();
                var dmgacc_month = $('#dmgacc_month').html();

                var addscacc_month = $('#addscacc_month').html();
                var osc_month = $('#osc_month').html();
                var score_month = $('#score_month').html();
                var score_quarter = $('#score_quarter').html();
                var score_r12 = $('#score_r12').html();




                var formData = 'salesplan=' + salesplan + '&item=' + item + '&userid=' + userid + '&checkboxim=' + checkboxim + '&checkboxdc=' + checkboxdc + '&checkboxsc=' + checkboxsc + '&checkboxother=' + checkboxother
                        + '&assignedtsm_im=' + assignedtsm_im + '&assignedtsm_dc=' + assignedtsm_dc + '&assignedtsm_sc=' + assignedtsm_sc + '&assignedtsm_other=' + assignedtsm_other
                        + '&comment_im=' + comment_im + '&comment_dc=' + comment_dc + '&comment_sc=' + comment_sc + '&comment_other=' + comment_other
                        + '&fillratebefore_month=' + fillratebefore_month + '&fillrateafter_month=' + fillrateafter_month + '&shipacc_month=' + shipacc_month + '&dmgacc_month=' + dmgacc_month + '&addscacc_month=' + addscacc_month + '&osc_month=' + osc_month
                        + '&score_month=' + score_month + '&score_quarter=' + score_quarter + '&score_r12=' + score_r12 + '&custgroup=' + custgroup;
                $.ajax({
                    url: 'formpost/postitemaction.php',
                    type: 'POST',
                    data: formData,
                    success: function (result) {
                        $('#addcommentmodal').modal('hide');
                        gettable();
                    }
                });

            });

            function GetUrlValue(VarSearch) {  //parse URL to pull variable defined

                var SearchString = window.location.search.substring(1);
                var VariableArray = SearchString.split('&');
                for (var i = 0; i < VariableArray.length; i++) {
                    var KeyValuePair = VariableArray[i].split('=');
                    if (KeyValuePair[0] === VarSearch) {
                        return KeyValuePair[1];
                    }
                }
            }

            function fillsalesplanval(shiptonum) {  //fill item input text
                document.getElementById("shipto").value = shiptonum;
            }

            function cleanurl() { //clean the URL if called from another page
                var clean_uri = location.protocol + "//" + location.host + location.pathname;
                window.history.replaceState({}, document.title, clean_uri);
            }

            $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            $(document).ready(function () {
                debugger;
                if (window.location.href.indexOf("shipto=") > -1) {

                    //Place this in the document ready function to determine if there is search variables in the URL.  
                    //Must clean the URL after load to prevent looping
                    var shiptonum = GetUrlValue('shipto');
                    getsalesplandata(shiptonum); //pass the 
                    gettable(); //call gettable function to load data if called from another page.
                }
            });</script>

        <script>
            $("#reports").addClass('active'); //add active strip to audit on vertical nav

            //On close of action modal, clear all fields and toggle hidden
            $('.modal').on('hidden.bs.modal', function () {
//                debugger;
                $('#hiddendatacheckboxim').addClass('hidden');
                $('#hiddendatacheckboxdc').addClass('hidden');
                $('#hiddendatacheckboxsc').addClass('hidden');
                $('#hiddendatacheckboxother').addClass('hidden');
                $(this).find('form')[0].reset();
            });

        </script>


        <script>
            $('#showsummarydata').hide();
        </script>
    </body>
</html>
