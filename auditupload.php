<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Mass Audit Upload</title>
        <?php include_once 'headerincludes.php'; ?>
    </head>

    <style media="screen" type="text/css">
        td {

            white-space: nowrap;
            text-overflow: ellipsis;
            cursor: pointer;
        }
    </style>
    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>


        <section id="content"> 
            <section class="main padder"> 

                <div class="" style="padding-bottom: 25px; padding-top: 20px;">
                    <div class="row" style="padding-bottom: 25px;"> 

                        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <label>Group Type:</label>
                            <select name = 'grouptype' class = "form-control" id = 'grouptype'>
                                <option value="SALESPLAN">Sales Plan</option>
                                <option value="SHIPTO">Ship To</option>
                                <option value="BILLTO">Bill To</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <label>Group ID:</label>
                            <input type="text" name="groupid" id="groupid" class="form-control" placeholder="salesplan name, bill to #, or ship to #" tabindex="3"/>
                        </div>
                    </div>


                    <div id="salesplansummary" class="panel-body" style="background: #efefef">
                        <div class="col-lg-4">
                            <form action="" method="post" enctype="multipart/form-data" target="_blank" id="uploadform" style="display: -webkit-inline-box;">
                                Select File to Upload:
                                <input type="file" name="fileToUpload" id="fileToUpload">
                                <input type="button" class="btn btn-success" id="auditupload_submit" name="" value="Upload" />
                            </form>
                        </div>
                    </div>
                </div>

                <div id="modal_uploadstatus" class="modal fade " role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Upload Status</h4>
                            </div>

                            <div class="modal-body">
                                <div id="ajaxresult"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="pull-left" style="margin-left: 15px" >
                        <button id="loaddata" type="button" class="btn btn-info" onclick="gettable();" style="margin-bottom: 5px;">Load Recently Uploaded Files</button>
                    </div>
                </div>

                <div class="row" style="margin-top: 20px">
                    <div class="col-sm-12">
                        <div id="tablecontainer" class="hidden">
                            <table id="tbl_massaudituploads" class="table table-bordered" cellspacing="0" style="font-size: 14px; font-family: Calibri;">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>Customer Type</th>
                                        <th>Customer ID</th>
                                        <th>Upload Date</th>
                                        <th>Upload TSM</th>
                                    </tr>
                                </thead>
                            </table>
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


            //ajax logic to parse the file and insert into audit table customeraction_asgntasks
            $(document).on("click", "#auditupload_submit", function (event) {
//                debugger;
                $('#modal_uploadstatus').modal('toggle');

                event.preventDefault();
                var file = $('#fileToUpload').get(0).files[0];
                var formData = new FormData();
                formData.append('file', file);
                var grouptype = $('#grouptype').val();
                var groupid = $('#groupid').val();
                formData.append('grouptype', grouptype);
                formData.append('groupid', groupid);
                //ajax for upload document panel
                $.ajax({
                    url: 'globaldata/upload_massaudit.php',
                    type: 'POST',
                    data: formData,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success: function (data) {
                        $('#tablecontainer').addClass('hidden');
                        $("#ajaxresult").html(data);
                        //clear the file from upload

                    }
                });
            });


            function gettable() { //table displaying all customer info

                $('#tablecontainer').removeClass('hidden');

                oTable = $('#tbl_massaudituploads').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "order": [[4, "desc"]],
                    "scrollX": true,
                    'sAjaxSource': "globaldata/massaudit_uploadedfiles.php",
                    "aoColumnDefs": [
                        {
                            "aTargets": [0], // Column to target
                            "mRender": function (data, type, full) {
                                // 'full' is the row's data object, and 'data' is this column's data
                                // e.g. 'full[0]' is the comic id, and 'data' is the comic title

                                return '<a href="uploads_massaudit/' + full[0] + '" target="_blank">' + data + '</a>';
                            }
                        }
                    ]
                });
                $('#tablecontainer').removeClass('hidden');
            }


        </script>

    </body>
</html>


