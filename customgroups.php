<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Custom Groups</title>
        <?php include_once 'headerincludes.php'; ?>
    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>


        <section id="content"> 
            <section class="main padder"> 
                <!--Top Actions fixed header-->
                <div id="topactions" class="topactions">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-body">
                                <div class="row"    >
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="top_viewgroup">
                                        <div class="alert alert-info danger-block hoverpointer"> <div  class="fullopacity"> <i class="fa  fa-eye "></i> View Groups</div></div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="top_addgroup">
                                        <div class="alert alert-success danger-block hoverpointer"><div  class="fullopacity"> <i class="fa fa-plus-square "></i>  Add Groups</div></div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="top_searchgroup">
                                        <div class="alert alert-danger danger-block hoverpointer"><div  class="fullopacity"><i class="fa  fa-search "></i>  Search Groups</div></div>
                                    </div>
                                    <!--                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="top_modifygroup">
                                                                            <div class="alert bg-inverse danger-block hoverpointer"> <div  class="fullopacity"><i class="fa  fa-pencil-square "></i>  Modify Groups</div></div>
                                                                        </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 thecontent">
                        <!--View Groups Div  Filled through Ajax call-->
                        <div id="viewgroups"></div>

                        <!--Add Groups Div-->
                        <div id="addgroups" class="hidden">
                            <!--Toggle add new master group button-->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="pull-left" style="margin-left: 15px; padding-bottom: 20px" >
                                        <button id="toggle_newmastergroup" type="button" class="btn btn-info" onclick="newmastergrouptoggle();" style="margin-bottom: 5px;">Add New Custom Group</button>
                                    </div>
                                </div>
                            </div>

                            <!--Select data-->
                            <div class="row" style="padding-bottom: 25px;"> 
                                <div class="col-md-4 col-lg-3 col-xl-2">
                                    <div class="pull-left" style="margin-left: 15px" >
                                        <label>Select Group: </label>
                                        <select class="selectstyle" id="loaddata_groupsel" name="loaddata_groupsel" style="width: 150px;">
                                            <option value="salesplan">Sales Plan</option>
                                            <option value="billto">Bill To</option>
                                            <option value="shipto">Ship To</option>
                                            <option value="search">Search Term</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xl-2">
                                    <div class="pull-left" style="margin-left: 15px" >
                                        <label>Enter ID:</label>
                                        <input name='loaddata_searchterm' class='selectstyle' id='loaddata_searchterm'/>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12 col-lg-2 col-xl-2">
                                    <div class="pull-left" style="margin-left: 15px" >
                                        <button id="loaddata" type="button" class="btn btn-primary" onclick="getaddgroupdata();">Load Data</button>
                                    </div>
                                </div>
                            </div>
                            <!--Display resultset-->
                            <div id="salesplandata"></div>
                        </div>



                        <!--Search Groups Div-->
                        <div id="searchgroups"></div>

                        <!--Modify Groups Div-->
                        <div id="modifygroups"></div>

                    </div>
                </div>


                <!-- Add master group modal -->
                <div id="mastergroupmodal" class="modal fade " role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add a New Group</h4>
                            </div>
                            <form class="form-horizontal" id="postmastergroup">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Name:</label>
                                        <div class="col-md-9">
                                            <input type="text" name="custgroup_shortname" id="custgroup_shortname" class="form-control" tabindex="1" placeholder="Enter Short Name (i.e. BCA_ALL)" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Description:</label>
                                        <div class="col-md-9">
                                            <textarea rows="2" placeholder="Enter brief description of group (i.e. All BCA Salesplans)" class="form-control" id="custgroup_desc" name="custgroup_desc" tabindex="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg pull-left" name="submit_addcustomgroup" id="submit_addcustomgroup">Create Group</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                <!--Shows user if post to table was a success.-->
                <div id="postsuccess"></div>

            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});

            //slide toggle detail data for custom group master in the view group module
            $(document).on("click touchstart", ".divtablerow", function (e) {
                $(this).next('.divtablehidden').slideToggle('');
            });

            //view custom group module
            $(document).on("click touchstart", "#top_viewgroup", function (e) {
                viewgroups(); //call view groups function
            });

            //Function to view groups
            function viewgroups() {
                $('#viewgroups').addClass('hidden');
                $('#addgroups').addClass('hidden');
                $('#searchgroups').addClass('hidden');
                $('#modifygroups').addClass('hidden');
                var userid = $('#userid').text();
                $.ajax({
                    url: 'globaldata/viewcustomgroups.php',
                    data: {userid: userid},
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $('#viewgroups').removeClass('hidden');
                        $("#viewgroups").hide().html(ajaxresult).fadeIn('slow');
                    }
                });
            }

            //add custom group module
            $(document).on("click touchstart", "#top_addgroup", function (e) {
                $('#viewgroups').addClass('hidden');
                $('#addgroups').removeClass('hidden');
                $("#addgroups").hide().fadeIn('slow');
                $('#searchgroups').addClass('hidden');
                $('#modifygroups').addClass('hidden');

            });

            //add custom group module
            $(document).on("click touchstart", ".deletecustomgroup", function (e) {

                var mastergroupid = $.trim($(this).attr('id'));
                $.ajax({
                    url: 'formpost/deletecustomgroup.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {mastergroupid: mastergroupid}, //pass master group id to delete
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                       viewgroups(); //call view groups function

                    }
                });

            });

            //load data to add to new custom group
            function getaddgroupdata() {
                var userid = $('#userid').text();
                var groupid = $('#loaddata_groupsel').val();
                var loaddata_searchterm = $('#loaddata_searchterm').val();
                $.ajax({
                    url: 'globaldata/addgroup_loaddata.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {groupid: groupid, loaddata_searchterm: loaddata_searchterm, userid: userid}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#salesplandata").html(ajaxresult);

                    }
                });
            }


            //toggle the modal to load a new master group
            function newmastergrouptoggle() {
                $('#mastergroupmodal').modal('toggle');
            }

            //function to select all checkboxes
            function selectall_salesplan() {
                $('#addtable_salesplan .chkbox_salesplan').prop('checked', true);
            }

            //function to de-select all checkboxes
            function deselectall_salesplan() {
                $('#addtable_salesplan .chkbox_salesplan').prop('checked', false);
            }


            //function to add selected customers to customer group
            $(document).on("click", "#btn_salesplan_addselectedl", function (e) {
                var add_mastername = $('#groupsel').val();
                var userid = $('#userid').text();
                var shiptoarray = [];
                var arraycount = 0;
                $('input.chkbox_salesplan').each(function () {
                    if ($(this).is(':checked')) {
                        var salesplan = $.trim($(this).closest('.divtablerow').find('.checked_salesplan').html());
                        var billto = $.trim($(this).closest('.divtablerow').find('.checked_billto').html());
                        var shipto = $.trim($(this).attr('id'));
                        shiptoarray[arraycount] = [salesplan, billto, shipto];
                        arraycount += 1;
                    }
                });
                var shiptocount = (shiptoarray.length);
                $.ajax({
                    url: 'formpost/customgroup_addselection.php',
                    type: 'post',
                    data: {shiptoarray: shiptoarray, add_mastername: add_mastername, userid: userid, shiptocount: shiptocount},
                    success: function (ajaxresult) {
                        $("#postsuccess").html(ajaxresult);
                    }
                });
            });

            //function to post new master custom group from modal
            $(document).on("click", "#submit_addcustomgroup", function (e) {
                e.preventDefault();
                var add_mastername = $('#custgroup_shortname').val();
                var add_masterdesc = $('#custgroup_desc').val();
                var userid = $('#userid').text();
                $.ajax({
                    url: 'formpost/customgroup_addmastergroup.php',
                    data: {userid: userid, add_mastername: add_mastername, add_masterdesc: add_masterdesc},
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#postsuccess").html(ajaxresult);
                        $('#mastergroupmodal').modal('hide');
                        cleanurl();

                    }
                });
            });

            function cleanurl() { //clean the URL if called from another page
                var clean_uri = location.protocol + "//" + location.host + location.pathname;
                window.history.replaceState({}, document.title, clean_uri);
            }

            $('.modal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });

        </script>



        <script>$("#modules").addClass('active');</script>

    </body>
</html>
