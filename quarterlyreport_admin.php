<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Large Customer Quarterly Report</title>
        <?php include_once 'headerincludes.php'; ?>
    </head>

    <body style="">
        <?php
        include_once 'horizontalnav.php';
        ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>
        <section id="content"> 
            <section class="main padder"> 
                <div id="right-panel" class="right-panel">

                    <div class="content mt-3">
                        <!--Left side filtering-->
                        <div class="col-md-3">
                            <p style="font-size:12px;"><strong>Data to include on quarterly report:</strong></p>
                            <form>
                                <label style="font-size:12px;">
                                    <input type="checkbox" name="rec-type" value="main" id="main" /> Main</label>
                                <br>
                                <label style="font-size:12px;">
                                    <input type="checkbox" name="rec-type" value="side" id="side" /> Side</label>
                                <br>
                                <label style="font-size:12px;">
                                    <input type="checkbox" name="rec-type" value="dessert" id="dessert" /> Dessert</label>
                                <br>
                            </form>
                        </div>
                        <!--Recipe cards-->
                        <div class="col-md-9">
                            <div id="ctn_qtrdata"></div>
                        </div>
                    </div>
                </div>
            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});


            $(document).ready(function () {
                getqtrdata();
            });
            
            function getqtrdata() {
                $.ajax({
                    url: 'globaldata/recipelisting.php',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#ctn_qtrdata").html(ajaxresult);
                    }
                });
            }
            
            var $filterCheckboxes = $('input[type="checkbox"]');
            $filterCheckboxes.on('change', function () {
                var selectedFilters = {};
                $filterCheckboxes.filter(':checked').each(function () {
                    if (!selectedFilters.hasOwnProperty(this.name)) {
                        selectedFilters[this.name] = [];
                    }
                    selectedFilters[this.name].push(this.value);
                });
                // create a collection containing all of the filterable elements
                var $filteredResults = $('.card');
                // loop over the selected filter name -> (array) values pairs
                $.each(selectedFilters, function (name, filterValues) {
                    // filter each .flower element
                    $filteredResults = $filteredResults.filter(function () {
                        var matched = false,
                                currentFilterValues = $(this).data('category').split(' ');
                        // loop over each category value in the current .flower's data-category
                        $.each(currentFilterValues, function (_, currentFilterValue) {
                            // if the current category exists in the selected filters array
                            // set matched to true, and stop looping. as we're ORing in each
                            // set of filters, we only need to match once
                            if ($.inArray(currentFilterValue, filterValues) != -1) {
                                matched = true;
                                return false;
                            }
                        });
                        // if matched is true the current .flower element is returned
                        return matched;
                    });
                });
                $('.card').hide().filter($filteredResults).fadeIn();
            });

            $("#modules").addClass('active');
        </script>


    </body>
</html>
