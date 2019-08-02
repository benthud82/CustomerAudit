<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
//include '../globalincludes/usa_asys_session.php';
    ?>
    <head>

        <title>Item Check</title>

        <?php include_once 'headerincludes.php'; ?>

    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>


        <section id="content"> 
            <section class="main padder"> 

                <!--Breadcrumb is used to track how user got to itemcheck page.  Was it from salesplan, billto, shipto, etc-->
                <div id='breadcrumb' class="hidden"></div>

                <!--Enter item#, salesplan, whse and submit-->
                <div class="row" style="padding-bottom: 25px; padding-top: 20px;"> 
                    <div class="col-xs-1">
                        <div class="hidden" style="margin-left: 15px" >
                            <label>Plan:</label>
                            <input name='salesplan' class='selectstyle'  id='salesplan'/>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <div class="" style="margin-left: 15px" >
                            <label>Item:</label>
                            <input name='itemcode' class='selectstyle' id='itemcode'/>
                        </div>
                    </div>
                    <!--                    <div class="col-md-3 col-lg-2">
                                            <div class="" style="margin-left: 15px" >
                                                <label>Whse:</label>
                                                <select class="selectstyle" id="whse" name="whse">
                                                    <option value="0">ALL</option>
                                                    <option value="2">Indy</option>
                                                    <option value="3">Sparks</option>
                                                    <option value="6">Denver</option>
                                                    <option value="7">Dallas</option>
                                                    <option value="9">Jax</option>
                                                </select>
                                            </div>
                                        </div>-->
                    <div class="col-md-3 col-lg-2">
                        <div class="" style="margin-left: 15px" >
                            <button id="loaddata" type="button" class="btn btn-primary" onclick="gettable();" style="margin-bottom: 5px;">Load Data</button>
                        </div>
                    </div>
                </div>
                <!--Green info bar with item description, vendor, and buyer-->
                <div class="row">
                    <div class="col-lg-12 hidden" id="headerinfo">
                        <div class="alert alert-success" id="data_itemdescription"> </div>
                    </div>
                </div>

                <!--Item comment section - not tied to specific audit-->
                <div class="row">
                    <div class="col-lg-12 hidden" id="commentheader">
                        <div class="" id="data_headercomments"> </div>
                        <div class="" id="data_audithistory"> </div>
                    </div>
                </div>

                <div id="documentupload" class="hidden"></div>

                <!--Algorithm results panel-->
                <div class="row hidden" id="all_algortithm_results">
                    <div class="hidewrapper">
                        <div class="col-lg-12">
                            <section class="panel " id="section_algorithmresults" style="margin-bottom: 50px; margin-top: 20px;"> 
                                <header class="panel-heading bg bg-inverse h2">Algorithm Results<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_algorithmresults"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                                <div id="panel_algorithmresults" class="panel-body"style="background: #efefef">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-info " style="font-size: 100%;"> <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button> <i class="fa fa-info-circle fa-lg"></i><span> Click on algorithm result panel to assign algorithm recommendation as a task.</span></div>
                                        </div>
                                    </div>
                                    <!--Row of algorithm outcomes-->
                                    <div class="row">
                                        <!--E3 Order point analysis-->
                                        <div class="col-xs-12 col-md-6 col-lg-6"> 
                                            <section id="panel_e3orderpoint"class="panel text-center clickablepanel" style="cursor: pointer;"> 
                                                <div class="panel-body "> 
                                                    <i id="icon_e3orderpoint" class="fa fa-2x"></i><div class="h4">E3 Order Point</div>
                                                    <div class="line m-l m-r"></div> 
                                                    <!--Loading spinner div-->
                                                    <div id="loading_e3orderpoint" class="loading col-sm-12 hidden" style="margin: 0 auto;">
                                                        <img class="bootstrapcol-centered" src="../ajax-loader-big.gif"/>
                                                    </div>
                                                    <!--Result div-->
                                                    <ul>
                                                        <div id="algorithmresult_e3orderpoint" class="resultli"></div>
                                                    </ul>
                                                </div>
                                            </section> 
                                        </div>
                                        <!--SKU optimization analysis-->
                                        <div class="col-xs-12 col-md-6 col-lg-6"> 
                                            <section id="panel_skuopt"class="panel text-center clickablepanel"  style="cursor: pointer;"> 
                                                <div class="panel-body"> 
                                                    <i id="icon_skuopt" class="fa fa-2x"></i><div class="h4">Sku Optimization</div>
                                                    <div class="line m-l m-r"></div> 
                                                    <!--Loading spinner div-->
                                                    <div id="loading_skuopt" class="loading col-sm-12 hidden" style="margin: 0 auto;">
                                                        <img class="bootstrapcol-centered" src="../ajax-loader-big.gif"/>
                                                    </div>
                                                    <!--Result div-->
                                                    <ul>
                                                        <div id="algorithmresult_skuopt" class="resultli"></div>
                                                    </ul>
                                                </div>
                                            </section> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!--DC Shipping Accuracy-->
                                        <div class="col-xs-12 col-md-6 col-lg-6"> 
                                            <section id="panel_shipacc"class="panel text-center clickablepanel"  style="cursor: pointer;"> 
                                                <div class="panel-body"> 
                                                    <i id="icon_shipacc" class="fa fa-2x"></i><div class="h4">DC Shipping Accuracy</div>
                                                    <div class="line m-l m-r"></div> 
                                                    <!--Loading spinner div-->
                                                    <div id="loading_shipacc" class="loading col-sm-12 hidden" style="margin: 0 auto;">
                                                        <img class="bootstrapcol-centered" src="../ajax-loader-big.gif"/>
                                                    </div>
                                                    <!--Result div-->
                                                    <ul>
                                                        <div id="algorithmresult_shipacc" class="resultli"></div>
                                                    </ul>
                                                </div>
                                            </section> 
                                        </div>
                                        <!--Damages-->
                                        <div class="col-xs-12 col-md-6 col-lg-6"> 
                                            <section id="panel_dmgacc"class="panel text-center clickablepanel" style="cursor: pointer;"> 
                                                <div class="panel-body"> 
                                                    <i id="icon_dmgacc" class="fa fa-2x"></i><div class="h4">Damages</div>
                                                    <div class="line m-l m-r"></div> 
                                                    <!--Loading spinner div-->
                                                    <div id="loading_dmgacc" class="loading col-sm-12 hidden" style="margin: 0 auto;">
                                                        <img class="bootstrapcol-centered" src="../ajax-loader-big.gif"/>
                                                    </div>
                                                    <!--Result div-->
                                                    <ul>
                                                        <div id="algorithmresult_dmgacc" class="resultli"></div>
                                                    </ul>
                                                </div>
                                            </section> 
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>


                <div class="row hidden" id="dc_results">   
                    <!--Datatable for DC Stats-->
                    <div class="hidewrapper">
                        <div class="col-lg-6">
                            <section class="panel " id="tablewrapper_dcstats" style="margin-bottom: 50px; margin-top: 20px;"> 
                                <header class="panel-heading bg bg-inverse h2">DC Statistics - Rolling 30 Days<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_dcstatstable"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                                <div id="summary_dcstats" class="panel-body">
                                    <div id="tablecontainer_dcstats" class="">
                                        <table id="table_dcstats" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                                            <thead>
                                                <tr>
                                                    <th>Whse</th>
                                                    <th>NSI</th>
                                                    <th>BO</th>
                                                    <th>Stk XS</th>
                                                    <th>Non-Stk XS</th>
                                                    <th>Total FR Hits</th>
                                                    <th>Total Lines</th>
                                                    <th>Before FR</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <!--Datatable for E3 Stats-->
                    <div class="hidewrapper">
                        <div class="col-lg-6">
                            <section class="panel " id="tablewrapper_e3stats" style="margin-bottom: 50px; margin-top: 20px;"> 
                                <header class="panel-heading bg bg-inverse h2">E3 Statistics<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_e3statstable"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                                <div id="summary_e3stats" class="panel-body">
                                    <div id="tablecontainer_e3stats" class="">
                                        <table id="table_e3stats" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                                            <thead>
                                                <tr>
                                                    <th>Whse</th>
                                                    <th>Birthday</th>
                                                    <th>Min Qty</th>
                                                    <th>Buy Multiple</th>
                                                    <th>4-Week Dmd</th>
                                                    <th>Order Point</th>
                                                    <th>Order-up-to</th>
                                                    <th>Service Level Goal</th>
                                                    <th>Service Level</th>
                                                    <th>Lead Time Calc</th>
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
                                            <div class="alert alert-info"><h5><i class='fa fa-info-circle fa-lg'></i> Customer returns impacts for the previous <strong>90</strong> calendar days. </h5></div>
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
                    <!--Customer Returns Details-->
                    <div class="hidewrapper">
                        <div class="col-lg-6">
                            <section class="panel" id="custreturnsdetailwrapper" style="margin-bottom: 50px; margin-top: 20px;"> 
                                <header class="panel-heading bg bg-inverse h2">Customer Returns Detail<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="closereturnsdetail"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>

                                <div id="custreturnsdetailpanelbody" class="panel-body">
                                    <!--Note about impacts for previous 90 days-->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="alert alert-info"><h5><i class='fa fa-info-circle fa-lg'></i> Customer returns detail for the previous <strong>90</strong> calendar days. </h5></div>
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
                                                    <th>JDE#</th>
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

                <!--Inbound History-->
                <div class="row hidden" id="inbound_hist">
                    <div class="hidewrapper">
                        <div class="col-lg-12">
                            <section class="panel hidden" id="section_inboundhistory" style="margin-bottom: 50px; margin-top: 20px;"> 
                                <header class="panel-heading bg bg-inverse h2">Inbound History<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_inboundhistory"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                                <div id="panel_inboundhistory" class="panel-body" style="background: #efefef">
                                    <!--populate from ajax call in getcustomerdata function-->
                                    <div class="data_inboundhistory" id="data_inboundhistory">Recreate open PO history from customer visibility here...</div>
                                </div>
                            </section>
                        </div>
                    </div>
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

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Sales Plan:</label>
                                        <div class="col-md-9">
                                            <input type="text" name="salesplanmodal" id="salesplanmodal" class="form-control" placeholder="Enter Sales Plan..." tabindex="1" />
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



                <!--Add comment modal.  Be sure to include itemcomments.js-->
                <?php include_once 'globaldata/addcommentmodal.php'; ?>
            </section>
        </section>


        <script>
            function gettable() {
                var salesplan = $('#salesplan').val();
                var itemcode = $('#itemcode').val();
//                var whse = $('#whse').val();
                $('#headerinfo').removeClass('hidden');
                $('#all_algortithm_results').removeClass('hidden');
                $('#dc_results').removeClass('hidden');
                $('#inbound_hist').removeClass('hidden');
                $('#custreturnstables').removeClass('hidden');
                $('#commentheader').removeClass('hidden');
                $('#documentupload').removeClass('hidden');


                //ajax for E3 algorithm result.  Fills div id #algorithmresult_e3orderpoint
                $.ajax({
                    url: 'globaldata/algorithmresult_e3orderpoint.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {itemcode: itemcode}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    beforeSend: function () {
                        $('#algorithmresult_e3orderpoint').hide();
                        $('#icon_e3orderpoint').hide();
                        $('#loading_e3orderpoint').removeClass('hidden');
                        $('#panel_e3orderpoint').attr('class',
                                function (i, c) {
                                    return c.replace(/(^|\s)bg-\S+/g, '');
                                });
                        $('#icon_e3orderpoint').attr('class',
                                function (i, c) {
                                    return c.replace(/(^|\s)fa-\S+/g, '');
                                });
                    },
                    complete: function () {
                        $('#loading_e3orderpoint').addClass('hidden');
                        $('#algorithmresult_e3orderpoint').show();
                        $('#icon_e3orderpoint').show();
                    },
                    success: function (ajaxresult) {
                        $("#algorithmresult_e3orderpoint").html(ajaxresult);
                    }
                });

                //ajax for SKU Opt result.  Fills div id #algorithmresult_skuopt
                $.ajax({
                    url: 'globaldata/algorithmresult_skuopt.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {itemcode: itemcode}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    beforeSend: function () {
                        $('#algorithmresult_skuopt').hide();
                        $('#icon_skuopt').hide();
                        $('#loading_skuopt').removeClass('hidden');
                        $('#panel_skuopt').attr('class',
                                function (i, c) {
                                    return c.replace(/(^|\s)bg-\S+/g, '');
                                });
                        $('#icon_skuopt').attr('class',
                                function (i, c) {
                                    return c.replace(/(^|\s)fa-\S+/g, '');
                                });
                    },
                    complete: function () {
                        $('#loading_skuopt').addClass('hidden');
                        $('#algorithmresult_skuopt').show();
                        $('#icon_skuopt').show();
                    },
                    success: function (ajaxresult) {
                        $("#algorithmresult_skuopt").html(ajaxresult);
                    }
                });

                //ajax for shipping accuracy result.  Fills div id #algorithmresult_shipacc
                $.ajax({
                    url: 'globaldata/algorithmresult_shipacc.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {itemcode: itemcode}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    beforeSend: function () {
                        $('#algorithmresult_shipacc').hide();
                        $('#icon_shipacc').hide();
                        $('#loading_shipacc').removeClass('hidden');
                        $('#panel_shipacc').attr('class',
                                function (i, c) {
                                    return c.replace(/(^|\s)bg-\S+/g, '');
                                });
                        $('#icon_shipacc').attr('class',
                                function (i, c) {
                                    return c.replace(/(^|\s)fa-\S+/g, '');
                                });
                    },
                    complete: function () {
                        $('#loading_shipacc').addClass('hidden');
                        $('#algorithmresult_shipacc').show();
                        $('#icon_shipacc').show();
                    },
                    success: function (ajaxresult) {
                        $("#algorithmresult_shipacc").html(ajaxresult);
                    }
                });

                //ajax for damage accuracy result.  Fills div id #algorithmresult_dmgacc
                $.ajax({
                    url: 'globaldata/algorithmresult_dmgacc.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {itemcode: itemcode}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    beforeSend: function () {
                        $('#algorithmresult_dmgacc').hide();
                        $('#icon_dmgacc').hide();
                        $('#loading_dmgacc').removeClass('hidden');
                        $('#panel_dmgacc').attr('class',
                                function (i, c) {
                                    return c.replace(/(^|\s)bg-\S+/g, '');
                                });
                        $('#icon_dmgacc').attr('class',
                                function (i, c) {
                                    return c.replace(/(^|\s)fa-\S+/g, '');
                                });
                    },
                    complete: function () {
                        $('#loading_dmgacc').addClass('hidden');
                        $('#algorithmresult_dmgacc').show();
                        $('#icon_dmgacc').show();
                    },
                    success: function (ajaxresult) {
                        $("#algorithmresult_dmgacc").html(ajaxresult);
                    }
                });

                //ajax for item description header at top of page.  Fills div id #data_itemdescription
                $.ajax({
                    url: 'globaldata/itemdescription.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {salesplan: salesplan, itemcode: itemcode}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#data_itemdescription").html(ajaxresult);
                    }
                });
                //ajax for commentsheader at top of page.  Fills div id #data_headercomments.  Comments are not tied to specific audit
                $.ajax({
                    url: 'globaldata/itemcommentheader.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {itemcode: itemcode}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#data_headercomments").html(ajaxresult);
                    }
                });
                //ajax for audit header at top of page.  Fills div id #data_audithistory.  Comments are  tied to specific audit
                $.ajax({
                    url: 'globaldata/itemauditheader.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {itemcode: itemcode}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#data_audithistory").html(ajaxresult);
                    }
                });

                //ajax for DC stats table.  Fills div id #table_dcstats
                $('#table_dcstats').removeClass('hidden');
                oTable2 = $('#table_dcstats').DataTable({
                    dom: "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'>>",
//                    dom: 'frltip',
                    destroy: true,
                    "scrollX": true,
                    'sAjaxSource': "globaldata/table_dcstats.php?itemcode=" + itemcode
                });

                //ajax for E3 stats table.  Fills div id #table_e3stats
                $('#table_e3stats').removeClass('hidden');
                oTable3 = $('#table_e3stats').DataTable({
                    dom: "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'>>",
//                    dom: 'frltip',
                    destroy: true,
                    "scrollX": true,
                    'sAjaxSource': "globaldata/table_e3stats.php?itemcode=" + itemcode
                });

                //Customer returns table
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
                    'sAjaxSource': "globaldata/custreturnsissues.php?itemcode=" + itemcode,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(0)', nRow).append("<div class='text-center'><i class='fa fa-check commentclick' style='cursor: pointer;' data-toggle='tooltip' data-title='Add Task' data-placement='top' data-container='body' ></i> </div>");
                    },
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });

                //Customer returns detail table
                oTable5 = $('#returnsdetailtable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
//                    dom: 'frltip',
                    destroy: true,
                    "order": [[9, "desc"]],
                    "scrollX": true,
                    'sAjaxSource': "globaldata/custreturnsdetail.php?itemcode=" + itemcode,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(0)', nRow).append("<div class='text-center'><i class='fa fa-check commentclick' style='cursor: pointer;' data-toggle='tooltip' data-title='Add Task' data-placement='top' data-container='body' ></i> </div>");
                    },
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });
                loaduploadmodule();
            }
            
            
                        $(document).on("click", "#upload_submit", function (event) {
                debugger;
                event.preventDefault();
                var file = $('#fileToUpload').get(0).files[0];
                var formData = new FormData();
                formData.append('file', file);

                var upload_custtype = $('#upload_custtype').val();
                var upload_custid = $('#upload_custid').val();
                formData.append('upload_custtype', upload_custtype);
                formData.append('upload_custid', upload_custid);

                //ajax for Mark as audited button and modal for recent audits
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
            
            
        </script>

        <script>
            function getsalesplandata(salesplannum, itemnum) { //billtopost comes from url
                if (typeof salesplannum !== 'undefined') {
                    var salesplan = salesplannum;
                    var itemnum = itemnum;
                    var custgroup = 'salesplan';
                } else {
                    var salesplan = $('#salesplan').val();
                    var itemnum = $('#itemnum').val();
                }
                fillsalesplanval(salesplan, itemnum); //fill the whse drop down
                cleanurl(); //clean the URL of post data
            }



            function loaduploadmodule() {
                var itemcode = $('#itemcode').val();
                var numtype = 'itemcode';
                //ajax for document upload module
                $.ajax({
                    url: 'globaldata/documentuploaddata.php',
                    data: {itemcode: itemcode, numtype: numtype}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#documentupload").html(ajaxresult);
                    }
                });
            }

        </script>

        <script>
            //show action modal
            $(document).on("click", ".commentclick", function (e) {
                $('#addcommentmodal').modal('toggle');
                $('#itemmodal').val($('#itemcode').val());
                $('#salesplanmodal').val($('#salesplan').val());
                $('#useridmodal').val($('#userid').text());
            });


            //show action modal and fill with algorithm result from E3 Order Point
            $(document).on("click", ".clickablepanel", function (e) {
                $('#addcommentmodal').modal('toggle');
                $('#itemmodal').val($('#itemcode').val());
                $('#salesplanmodal').val($('#salesplan').val());
                $('#useridmodal').val($('#userid').text());
                clickedid = (this.id);

                //based off panel clicked, determine who to assign task
                if (clickedid === 'panel_e3orderpoint' || clickedid === 'panel_skuopt') {
                    $('#checkboxim').attr('checked', true); //toggle the checkbox
                    $('#hiddendatacheckboxim').toggleClass('hidden');  //unhide the panel
                    //fill the comment section with the recommended action
                    $("#" + clickedid + " li").each(function () {

                        $('#comment_im').append($(this).html());
                    });
                } else if (clickedid === 'panel_shipacc') {
                    $('#checkboxdc').attr('checked', true); //toggle the checkbox
                    $('#hiddendatacheckboxdc').toggleClass('hidden');  //unhide the panel
                    //fill the comment section with the recommended action
                    $("#" + clickedid + " li").each(function () {

                        $('#comment_dc').append($(this).html());
                    });
                } else if (clickedid === 'panel_skuopt') {
                    $('#checkboxim').attr('checked', true); //toggle the checkbox
                    $('#hiddendatacheckboxim').toggleClass('hidden');  //unhide the panel
                    //fill the comment section with the recommended action
                    $("#" + clickedid + " li").each(function () {

                        $('#comment_im').append($(this).html());
                    });
                } else if (clickedid === 'panel_dmgacc') {
                    $('#checkboxdc').attr('checked', true); //toggle the checkbox
                    $('#hiddendatacheckboxdc').toggleClass('hidden');  //unhide the panel
                    //fill the comment section with the recommended action
                    $("#" + clickedid + " li").each(function () {

                        $('#comment_dc').append($(this).html());
                    });
                }



            });

            //submit action from modal
            $(document).on("click", "#submititemaction", function (event) {
                event.preventDefault();
                var salesplan = $('#salesplanmodal').val();
                var item = $('#itemmodal').val();
                var userid = $('#useridmodal').val();
                debugger;
                var custgroup = $('#breadcrumb').html();
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
                    }
                });

            });

            //triggered when checkbox is clicked on comment modal.  Toggles additional information to enter for action tracking
            $(document).on("change", ".checkboxtoggle", function (e) {
//                debugger;
                var clickedid = (this.id);
                $('#hiddendata' + clickedid).toggleClass('hidden');

            });

            //On close of action modal, clear all fields and toggle hidden
            $('.modal').on('hidden.bs.modal', function () {
//                debugger;
                $('#hiddendatacheckboxim').addClass('hidden');
                $('#hiddendatacheckboxdc').addClass('hidden');
                $('#hiddendatacheckboxsc').addClass('hidden');
                $('#hiddendatacheckboxother').addClass('hidden');
                $('#checkboxdc').attr('checked', false); //toggle the checkbox
                $('#checkboxim').attr('checked', false); //toggle the checkbox
                $('#checkboxsc').attr('checked', false); //toggle the checkbox
                $('#checkboxother').attr('checked', false); //toggle the checkbox
                $('textarea').empty();
                $("#comment_im").empty();
                $('#comment_im').val("");
                $('#comment_dc').val("");
                $('#comment_sc').val("");
                $('#comment_other').val("");

                $(this).find('form')[0].reset();
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

            function fillsalesplanval(salesplannum, itemnum) {  //fill item input text
                document.getElementById("salesplan").value = salesplannum;
                document.getElementById("itemcode").value = itemnum;
            }

            function cleanurl() { //clean the URL if called from another page
                var clean_uri = location.protocol + "//" + location.host + location.pathname;
                window.history.replaceState({}, document.title, clean_uri);
            }

            $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            $(document).ready(function () {
                if (window.location.href.indexOf("salesplan") > -1) {

                    //Place this in the document ready function to determine if there is search variables in the URL.  
                    //Must clean the URL after load to prevent looping
                    var salesplannum = GetUrlValue('salesplan');
                    var itemnum = GetUrlValue('itemnum');
                    getsalesplandata(salesplannum, itemnum); //pass the 
                    $('#breadcrumb').html('salesplan');
                    gettable(); //call the gettable function if the salesplan and item are populated 
                } else if (window.location.href.indexOf("billto") > -1) {
                    var salesplannum = GetUrlValue('billto');
                    var itemnum = GetUrlValue('itemnum');
                    $('#breadcrumb').html('billto');
                    getsalesplandata(salesplannum, itemnum); //pass the 
                    gettable(); //call the gettable function if the salesplan and item are populated 
                } else if (window.location.href.indexOf("shipto") > -1) {
                    var salesplannum = GetUrlValue('shipto');
                    var itemnum = GetUrlValue('itemnum');
                    $('#breadcrumb').html('shipto');
                    getsalesplandata(salesplannum, itemnum); //pass the 
                    gettable(); //call the gettable function if the salesplan and item are populated 
                }
            });
        </script>

        <script>
            $("#itemcheck").addClass('active'); //add active strip to audit on vertical nav

            $(document).on("click", ".showhidden", function (e) {
                var clickedid = (this.id);
                var showid = clickedid.replace("show", "");
                $('#' + showid).closest('.hidewrapper').show("slow");
                $('#' + clickedid).hide("slow");
                $('#' + clickedid).addClass('hidden');
            });
        </script>

        <!--Personal Script for showing and completing item comments-->
        <script src="js/itemcomments.js" type="text/javascript"></script>

    </body>
</html>
