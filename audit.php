<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Customer Audit</title>
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
                    <div class="col-md-4">
                        <label class="control-label" style=" float: left;">Include Recently <br>Audited Sales Plans?:</label>
                        <div class="switch-field"style="padding-left: 20px;">
                            <input type="radio" id="switch_left" name="switch_2" value="yes" />
                            <label for="switch_left" class="greenbackground" data-toggle="tooltip" data-title="Include salesplans audited in last 30 days?" data-placement="bottom">Yes</label>
                            <input type="radio" id="switch_right" name="switch_2" value="no" checked />
                            <label id="nolabel" for="switch_right" data-toggle="tooltip" data-title="Exclude salesplans audited in last 30 days?" data-placement="bottom">No</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label" style=" float: left;">Include Salesplans <br>Less than $500,000?:</label>
                        <div class="switch-field"style="padding-left: 20px;">
                            <input type="radio" id="switch_left2" name="switch_22" value="yes" />
                            <label for="switch_left2" class="greenbackground" >Yes</label>
                            <input type="radio" id="switch_right2" name="switch_22" value="no" checked />
                            <label id="nolabel2" for="switch_right2">No</label>
                        </div>
                    </div>
                    <div class="pull-left" style="margin-left: 15px" >
                        <button id="loaddata" type="button" class="btn btn-primary" onclick="gettable();" style="margin-bottom: 5px;">Load Data</button>
                    </div>
                </div>


                <div id="tablecontainer" class="hidden">
                    <table id="customertable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri; cursor: pointer;">
                        <thead>
                            <tr>
                                <th>Sales-Plan Num</th>
                                <th>Rolling Month Lines</th>
                                <th>Rolling Month Sales</th>
                                <th>Rolling Year Lines</th>
                                <th>Rolling Year Sales</th>
                                <th>Rolling Month Before FR</th>
                                <th>Rolling Year Before FR</th>
                                <th>Rolling Month After FR</th>
                                <th>Rolling Year After FR</th>
                                <th>Customer Score Month</th>
                                <th>30 Day Score Slope</th>
                                <th>Customer Score Quarter</th>
                                <th>90 Day Score Slope</th>
                                <th>Customer Score Year</th>
                                <th>Year Score Slope</th>
                                <th>30 Day BO</th>
                                <th>30 Day BO Slope</th>
                                <th>90 Day BO</th>
                                <th>90 Day BO Slope</th>
                                <th>30 Day Stk X-Ship</th>
                                <th>30 Day Stk X-Ship Slope</th>
                                <th>90 Day Stk X-Ship</th>
                                <th>90 Day Stk X-Ship Slope</th>
                                <th>30 Day NSI X-Ship</th>
                                <th>30 Day NSI X-Ship Slope</th>
                                <th>90 Day NSI X-Ship</th>
                                <th>90 Day NSI X-Ship Slope</th>
                                <th>30 Day NSI</th>
                                <th>30 Day NSI Slope</th>
                                <th>90 Day NSI</th>
                                <th>90 Day NSI Slope</th>
                                <th>30 Day Ship Acc.</th>
                                <th>30 Day Ship Acc. Slope</th>
                                <th>90 Day Ship Acc.</th>
                                <th>90 Day Ship Acc. Slope</th>
                                <th>30 Day Damage</th>
                                <th>30 Day Damage Slope</th>
                                <th>90 Day Damage</th>
                                <th>90 Day Damage Slope</th>
                                <th>30 Day Other SC</th>
                                <th>30 Day Other SC Slope</th>
                                <th>90 Day Other SC</th>
                                <th>90 Day Other SC Slope</th>
                                <th>30 Day OSC</th>
                                <th>30 Day OSC Slope</th>
                                <th>90 Day OSC</th>
                                <th>90 Day OSC Slope</th>

                            </tr>
                        </thead>
                    </table>
                </div>
            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});


            function gettable() { //table displaying all customer info
                if (document.getElementById('switch_left').checked) {
                    var includeaudit = 1;
                } else {
                    var includeaudit = 0;
                }
                if (document.getElementById('switch_left2').checked) {
                    var allsalesplans = 1;
                } else {
                    var allsalesplans = 0;
                }


                $('#tablecontainer').removeClass('hidden');
                var userid = $('#userid').text();
                var d = new Date();
                var year = d.getFullYear();
                var month = d.getMonth() + 1;
                var day = d.getDate();
                var exportTitle = userid + ' - ' + year + '-' + month + '-' + day;

                oTable = $('#customertable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "order": [[10, "asc"]],
                    "scrollX": true,
                    select: true,
                    'sAjaxSource': "globaldata/largecustomeraudit.php?includeaudit=" + includeaudit + "&allsalesplans=" + allsalesplans,
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            className: 'separatedbutton'
                        },
                        {
                            extend: 'excelHtml5',
                            className: 'separatedbutton',
                            title: exportTitle
                        },
                        {
                            text: 'Audit Selected Sales-Plan',
                            className: 'bg-info separatedbutton',
                            action: function () {
                                var selectedsalesplan = oTable.cell('.selected', 0).data();
                                var url = 'salesplancheck.php?salesplan=' + selectedsalesplan;
                                window.open(url, '_blank');
                            }
                        }
                    ]
                });
                $('#tablecontainer').removeClass('hidden');
            }


        </script>

        <script>$("#custlist").addClass('active');</script>

    </body>
</html>
