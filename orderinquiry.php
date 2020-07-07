<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Order Inquiry</title>
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
                    <div class="col-lg-3 col-md-4">
                        <div class="pull-left" style="margin-left: 15px" >
                            <label>Select # Type:</label>
                            <select class="selectstyle" id="orderytype" name="orderytype" style="width: 100px;">
                                <option value="JDE">JDE</option>
                                <option value="WCS">WCS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="pull-left" style="margin-left: 15px" >
                            <label>Enter Invoice #:</label>
                            <input name='invoicenum' class='selectstyle' id='invoicenum'/>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <div class="pull-left" style="margin-left: 15px" >
                            <button id="loaddata" type="button" class="btn btn-primary" onclick="getjde();" style="margin-bottom: 5px;">Load Data</button>
                        </div>
                    </div>
                </div>

                <div id="maincontent" class="hidewrapper hidden" ></div>

            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            $('body').tooltip({
                selector: '[rel=tooltip]'
            });
            $("#modules").addClass('active'); //add active strip to audit on vertical nav


            function getjde() {
                var num_type = $('#orderytype').val();
                var num_invoice = $('#invoicenum').val();
                if (num_type === 'WCS') {
                    $.ajax({
                        async: false,
                        url: 'globaldata/getjde.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                        data: {num_invoice: num_invoice}, //pass salesplan, billto, shipto all through billto
                        type: 'POST',
                        dataType: 'html',
                        success: function (data) {
                            getorderdata(data);
                        }
                    });
                } else {
                    getorderdata(num_invoice);
                }


            }



            function getorderdata(jdeinvoice) {
                debugger;
                data_pend(jdeinvoice);



            }

            function data_pend(jdeinvoice) {
                debugger;
                $.ajax({
                    url: 'globaldata/search_billto.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {jde_num: jde_num}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#resultcontainer_salesplan").html(ajaxresult);
                    }
                });
            }

        </script>

    </body>
</html>


