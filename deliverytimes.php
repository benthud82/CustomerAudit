<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Box Delivery Times</title>
        <?php include_once 'headerincludes.php'; ?>
        <style>
            /* Toggle switch styling */
            .switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 34px;
                vertical-align: middle;
                margin-bottom: 0;
            }
            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: .4s;
                border-radius: 34px;
            }
            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                transition: .4s;
                border-radius: 50%;
            }
            input:checked + .slider {
                background-color: #dc3545;
            }
            input:focus + .slider {
                box-shadow: 0 0 1px #dc3545;
            }
            input:checked + .slider:before {
                transform: translateX(26px);
            }
            .toggle-label {
                margin-left: 10px;
                font-weight: normal;
            }
        </style>
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
                        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <label>Enter Salesplan</label>
                            <input type="text" name="salesplan" id="salesplan" class="form-control" placeholder="" tabindex="0"/>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <label>Quarter Selection</label>
                            <select id="quarterSelector" class="form-control" tabindex="0">
                                <option value="">Select Quarter</option>
                                <!-- Quarters will be populated via JavaScript -->
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <label>Start Date</label>
                            <input type="date" name="startdate" id="startdate" class="form-control" tabindex="0"/>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <label>End Date</label>
                            <input type="date" name="enddate" id="enddate" class="form-control" tabindex="0"/>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <button id="loaddata" type="button" class="btn btn-primary" onclick="gettable();" style="margin: 23px 0px 0px 0px;" tabindex="0">Load Data</button>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <div style="margin: 23px 0px 0px 0px;" class="d-flex align-items-center">
                                <label class="switch">
                                    <input type="checkbox" id="toggleLateOnly" checked>
                                    <span class="slider"></span>
                                </label>
                                <span class="toggle-label">Show Late Shipments Only</span>
                            </div>
                        </div>
                    </div>
                    <div id="dateError" class="row hidden" style="padding-bottom: 10px;">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <div class="alert alert-danger">
                                <strong>Error:</strong> Custom date ranges must be 96 days or less and within the last 2 years. Quarter selections are allowed if available in the dropdown.
                            </div>
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
            
            // Set default date values
            $(document).ready(function() {
                // Populate the quarter dropdown
                populateQuarterDropdown();
                
                // Check for URL parameters first
                var hasUrlParams = window.location.href.indexOf("salesplan") > -1;
                console.log("Has URL params:", hasUrlParams);
                
                if (hasUrlParams) {
                    // If we have URL parameters, let getsalesplandata handle it
                    var salesplannum = GetUrlValue('salesplan');
                    console.log("Salesplan value from URL:", salesplannum);
                    if (salesplannum) {
                        getsalesplandata(salesplannum);
                        gettable(); // Call the gettable function
                    }
                } else {
                    // Only set default dates if we're not coming from another page
                    console.log("Setting default dates (no URL params)");
                    // Set end date to today
                    var today = new Date();
                    var endDateStr = today.toISOString().split('T')[0];
                    $('#enddate').val(endDateStr);
                    
                    // Set start date to 90 days ago
                    var startDate = new Date();
                    startDate.setDate(today.getDate() - 90);
                    var startDateStr = startDate.toISOString().split('T')[0];
                    $('#startdate').val(startDateStr);
                }
                
                // Add event listener for the toggle switch
                $('#toggleLateOnly').on('change', function() {
                    if ($('#salesplan').val()) {
                        gettable();
                    }
                });
                
                // Add event listeners for date inputs
                $('#startdate, #enddate').on('change', function() {
                    validateDateRange();
                    // Clear quarter selection when dates are manually changed
                    $('#quarterSelector').val('');
                });
                
                // Add event listener for quarter selection
                $('#quarterSelector').on('change', function() {
                    setDatesByQuarter($(this).val());
                });
            });
            
            // Function to populate the quarter dropdown
            function populateQuarterDropdown() {
                var today = new Date();
                var currentYear = today.getFullYear();
                var currentMonth = today.getMonth() + 1; // JavaScript months are 0-based
                
                var dropdown = $('#quarterSelector');
                dropdown.empty();
                dropdown.append('<option value="">Select Quarter</option>');
                
                // Determine which quarters are complete based on current date
                var completedQuarters = [];
                
                // Check the previous 2 years plus current year
                for (var year = currentYear; year >= currentYear - 2; year--) {
                    // For the current year, only include completed quarters
                    if (year === currentYear) {
                        if (currentMonth >= 4) completedQuarters.push({ year: year, quarter: 1 }); // Q1 (Jan-Mar)
                        if (currentMonth >= 7) completedQuarters.push({ year: year, quarter: 2 }); // Q2 (Apr-Jun)
                        if (currentMonth >= 10) completedQuarters.push({ year: year, quarter: 3 }); // Q3 (Jul-Sep)
                        // Q4 is only complete if we're in the next year
                    } 
                    // For previous years, include all quarters
                    else {
                        completedQuarters.push({ year: year, quarter: 1 });
                        completedQuarters.push({ year: year, quarter: 2 });
                        completedQuarters.push({ year: year, quarter: 3 });
                        completedQuarters.push({ year: year, quarter: 4 });
                    }
                }
                
                // Sort quarters in descending order (most recent first)
                completedQuarters.sort(function(a, b) {
                    if (a.year !== b.year) return b.year - a.year;
                    return b.quarter - a.quarter;
                });
                
                // Add options to dropdown
                completedQuarters.forEach(function(q) {
                    var label = 'Q' + q.quarter + ' ' + q.year;
                    var value = q.year + '-' + q.quarter;
                    dropdown.append('<option value="' + value + '">' + label + '</option>');
                });
            }
            
            // Function to set start and end dates based on quarter selection
            function setDatesByQuarter(quarterValue) {
                if (!quarterValue) return;
                
                var parts = quarterValue.split('-');
                var year = parseInt(parts[0]);
                var quarter = parseInt(parts[1]);
                
                var startDate, endDate;
                
                switch (quarter) {
                    case 1: // Q1: Jan-Mar
                        startDate = year + '-01-01';
                        endDate = year + '-03-31';
                        break;
                    case 2: // Q2: Apr-Jun
                        startDate = year + '-04-01';
                        endDate = year + '-06-30';
                        break;
                    case 3: // Q3: Jul-Sep
                        startDate = year + '-07-01';
                        endDate = year + '-09-30';
                        break;
                    case 4: // Q4: Oct-Dec
                        startDate = year + '-10-01';
                        endDate = year + '-12-31';
                        break;
                }
                
                $('#startdate').val(startDate);
                $('#enddate').val(endDate);
                
                // Validate the date range
                validateDateRange();
            }
            
            // Function to validate date range
            function validateDateRange() {
                var startDate = new Date($('#startdate').val());
                var endDate = new Date($('#enddate').val());
                
                // Calculate date difference in days
                var timeDiff = endDate - startDate;
                var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                
                // Check if start date is more than 2 years ago
                var twoYearsAgo = new Date();
                twoYearsAgo.setFullYear(twoYearsAgo.getFullYear() - 2);
                
                // Check if the current selection is a valid quarter
                var isQuarterSelection = false;
                var quarterValue = $('#quarterSelector').val();
                
                if (quarterValue) {
                    // This is a quarter selection, check if it's a valid quarter
                    var parts = quarterValue.split('-');
                    var year = parseInt(parts[0]);
                    var quarter = parseInt(parts[1]);
                    
                    var quarterStartDate, quarterEndDate;
                    switch (quarter) {
                        case 1: // Q1: Jan-Mar
                            quarterStartDate = new Date(year, 0, 1); // Jan 1
                            quarterEndDate = new Date(year, 2, 31); // Mar 31
                            break;
                        case 2: // Q2: Apr-Jun
                            quarterStartDate = new Date(year, 3, 1); // Apr 1
                            quarterEndDate = new Date(year, 5, 30); // Jun 30
                            break;
                        case 3: // Q3: Jul-Sep
                            quarterStartDate = new Date(year, 6, 1); // Jul 1
                            quarterEndDate = new Date(year, 8, 30); // Sep 30
                            break;
                        case 4: // Q4: Oct-Dec
                            quarterStartDate = new Date(year, 9, 1); // Oct 1
                            quarterEndDate = new Date(year, 11, 31); // Dec 31
                            break;
                    }
                    
                    // Check if the dates match the quarter dates (allow 1 day difference for timezone issues)
                    var startDiff = Math.abs(startDate.getTime() - quarterStartDate.getTime());
                    var endDiff = Math.abs(endDate.getTime() - quarterEndDate.getTime());
                    
                    if (startDiff <= 86400000 && endDiff <= 86400000) { // 86400000 ms = 1 day
                        isQuarterSelection = true;
                    }
                }
                
                // If it's a quarter selection, only validate the 2-year limit and use 96-day limit
                // Otherwise, validate the 90-day limit and 2-year limit for custom date ranges
                var isValid = isQuarterSelection ? 
                    (startDate >= twoYearsAgo && daysDiff <= 96) : 
                    (daysDiff <= 90 && daysDiff >= 0 && startDate >= twoYearsAgo);
                
                if (!isValid) {
                    $('#dateError').removeClass('hidden');
                    $('#loaddata').prop('disabled', true);
                } else {
                    $('#dateError').addClass('hidden');
                    $('#loaddata').prop('disabled', false);
                }
                
                return isValid;
            }
            
            function gettable() {
                if (!validateDateRange()) {
                    return;
                }
                
                $('#hidewrapper').addClass('hidden'); 
                //fill the tnt table
                var salesplan = $('#salesplan').val();
                var showLateOnly = $('#toggleLateOnly').is(':checked') ? 1 : 0;
                var startDate = $('#startdate').val();
                var endDate = $('#enddate').val();
                
                oTable4 = $('#dt_deldetail').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[5, "desc"]],
                    "scrollX": true,
                    'sAjaxSource': "globaldata/data_deliverytimes.php?salesplan=" + salesplan + "&late=" + showLateOnly + "&start_date=" + startDate + "&end_date=" + endDate,
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ],
                    "columnDefs": [
                        {
                            "targets": 9, // Tracer column index
                            "render": function (data, type, row) {
                                // For display and filter/search, render HTML as-is
                                if (type === 'display' || type === 'filter') {
                                    return data;
                                }
                                // For sorting/type detection, remove HTML
                                return data ? data.replace(/<[^>]*>/g, '') : data;
                            }
                        }
                    ],
                    "initComplete": function(settings, json) {
                        // Add hover effect for UPS tracking links - target all tracking links
                        $('#dt_deldetail').on('mouseenter', 'a[href*="ups.com/track"]', function() {
                            $(this).css({
                                'background-color': '#f0f0f0', 
                                'box-shadow': '0 1px 3px rgba(0,0,0,0.1)',
                                'transform': 'translateY(-1px)'
                            });
                        }).on('mouseleave', 'a[href*="ups.com/track"]', function() {
                            $(this).css({
                                'background-color': '#f8f8f8',
                                'box-shadow': 'none',
                                'transform': 'translateY(0)'
                            });
                        });
                    }
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

            //parse URL to pull variable defined
            function GetUrlValue(VarSearch) {
                console.log("Searching for URL parameter:", VarSearch);
                var SearchString = window.location.search.substring(1);
                console.log("Search string:", SearchString);
                var VariableArray = SearchString.split('&');
                console.log("Variable array:", VariableArray);
                
                // More robust parsing
                for (var i = 0; i < VariableArray.length; i++) {
                    var KeyValuePair = VariableArray[i].split('=');
                    console.log("Checking pair:", KeyValuePair[0], "vs", VarSearch);
                    
                    // Trim any whitespace and make sure we're doing an exact match
                    if (KeyValuePair[0].trim() === VarSearch.trim()) {
                        // Decode the URL component to handle special characters
                        var value = KeyValuePair[1] ? decodeURIComponent(KeyValuePair[1]) : '';
                        console.log("Found value:", value);
                        return value;
                    }
                }
                
                console.log("Parameter not found:", VarSearch);
                return "";
            }

            //billtopost comes from url
            function getsalesplandata(salesplannum) {
                // Log the complete URL for debugging
                console.log("Complete URL:", window.location.href);
                
                // First, capture all URL parameters before cleaning the URL
                var startDateParam = null;
                var endDateParam = null;
                var quarterParam = null;
                
                // If date parameters are in the URL, capture them first
                if (window.location.href.indexOf("start_date") > -1 && window.location.href.indexOf("end_date") > -1) {
                    startDateParam = GetUrlValue('start_date');
                    endDateParam = GetUrlValue('end_date');
                    console.log("Captured date parameters before cleanurl:", startDateParam, endDateParam);
                }
                
                // If quarter parameter is in the URL, capture it
                if (window.location.href.indexOf("quarter=") > -1) {
                    quarterParam = GetUrlValue('quarter');
                    console.log("Captured quarter parameter before cleanurl:", quarterParam);
                } else {
                    console.log("No quarter parameter found in URL. All URL parts:", window.location.search.substring(1).split('&'));
                }
                
                // Get salesplan
                if (typeof salesplannum !== 'undefined') {
                    var salesplan = salesplannum;
                } else {
                    var salesplan = $('#salesplan').val();
                }
                
                // Fill salesplan value
                fillsalesplanval(salesplan);
                
                // Clean the URL (this will remove all parameters)
                cleanurl();
                
                // Now set the date values if they were in the URL
                if (startDateParam) {
                    console.log("Setting start date after cleanurl:", startDateParam);
                    $('#startdate').val(startDateParam);
                }
                if (endDateParam) {
                    console.log("Setting end date after cleanurl:", endDateParam);
                    $('#enddate').val(endDateParam);
                }
                
                // Set quarter selection if it was in the URL
                if (quarterParam && quarterParam !== '') {
                    console.log("Setting quarter after cleanurl:", quarterParam);
                    $('#quarterSelector').val(quarterParam);
                    
                    // After setting the quarter, we may need to trigger any events that 
                    // happen when a quarter is selected (like validating date range)
                    validateDateRange();
                }
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
