<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Audit History</title>
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


                <div class="row" style="padding-bottom: 25px;"> 
                    <div class="col-md-4 col-lg-3 col-xl-2">
                        <div class="pull-left" style="margin-left: 15px" >
                            <label>Select Group: </label>
                            <select class="selectstyle" id="groupsel" name="groupsel" style="width: 140px;">
                                <option value="salesplan">Sales Plan</option>
                                <option value="billto">Bill To</option>
                                <option value="shipto">Ship To</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-2">
                        <div class="pull-left" style="margin-left: 15px" >
                            <label>Enter ID:</label>
                            <input name='groupid' class='selectstyle' id='groupid'/>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12 col-lg-2 col-xl-2">
                        <div class="pull-left" style="margin-left: 15px" >
                            <button id="loaddata" type="button" class="btn btn-primary" onclick="gettable();">Load Data</button>
                        </div>
                    </div>
                </div>

                <!--Scorecard summary data by month/qtr/r12-->
                <div class="hidewrapper hidden">
                    <div class="row">


                        <!--populate from ajax call in gettable function-->
                        <div id="audithistorycontainer"></div>


                    </div>
                </div>







            </section>
        </section>


        <script>

            function gettable() {
                var groupsel = $('#groupsel').val();
                var groupid = $('#groupid').val();

                //ajax for audit history data
                $.ajax({
                    url: 'globaldata/audithistorydata.php',
                    data: {groupsel: groupsel, groupid: groupid}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#audithistorycontainer").html(ajaxresult);
                        $('.hidewrapper').removeClass('hidden');
                    }
                });

            }

            function getsalesplandata(salesplannum, custgroup) { //billtopost comes from url
                if (typeof salesplannum !== 'undefined') {

                    var salesplan = salesplannum;
                    var custgroup = custgroup;
                } else {
                    var salesplan = $('#groupsel').val();
                    var custgroup = $('#groupid').val();
                }
                fillsalesplanval(salesplan, custgroup);
                cleanurl(); //clean the URL of post data
            }


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

            function fillsalesplanval(salesplannum, custgroup) {  //fill item input text
                debugger;
                document.getElementById("groupsel").value = custgroup;
                document.getElementById("groupid").value = salesplannum;
            }

            function cleanurl() { //clean the URL if called from another page
                var clean_uri = location.protocol + "//" + location.host + location.pathname;
                window.history.replaceState({}, document.title, clean_uri);
            }

            $(document).ready(function () {
                if (window.location.href.indexOf("salesplan") > -1) {

                    //Place this in the document ready function to determine if there is search variables in the URL.  
                    //Must clean the URL after load to prevent looping
                    var salesplannum = GetUrlValue('salesplan');
                    var custgroup = 'salesplan';
                    getsalesplandata(salesplannum, custgroup); //pass the 
                    gettable(); //call the gettable function if the salesplan and item are populated 
                } else if (window.location.href.indexOf("billto") > -1) {
                    var salesplannum = GetUrlValue('billto');
                    var custgroup = 'billto';
                    getsalesplandata(salesplannum, custgroup); //pass the 
                    gettable(); //call the gettable function if the salesplan and item are populated 
                } else if (window.location.href.indexOf("shipto") > -1) {
                    var salesplannum = GetUrlValue('shipto');
                    var custgroup = 'shipto';
                    getsalesplandata(salesplannum, custgroup); //pass the 
                    gettable(); //call the gettable function if the salesplan and item are populated 
                }
            });



            $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            $("#history").addClass('active'); //add active strip to audit on vertical nav
        </script>

    </body>
</html>
