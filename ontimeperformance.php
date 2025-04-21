<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>On-Time Performance Tracking</title>
        <?php include_once 'headerincludes.php'; ?>
        <style>
            .search-container {
                background-color: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                margin-bottom: 25px;
            }
            
            .results-header {
                background: linear-gradient(to right, #f8f9fa, white);
                padding: 15px 20px;
                border-radius: 8px 8px 0 0;
                border-left: 4px solid #007bff;
                margin-bottom: 20px;
                font-size: 1.5em;
                color: #333;
            }
            
            #salesplanDisplay {
                font-weight: bold;
                color: #007bff;
            }
            
            #resultsContainer {
                padding: 20px;
                background-color: #f8f9fa;
                border-radius: 8px;
            }
            
            /* Enhanced styling for the salesplan stats card */
            #salesplanSummary {
                margin-bottom: 30px !important;
                background: white !important;
                border-radius: 8px !important;
                box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
                padding: 0 !important;
                border-left: 4px solid #007bff !important;
                overflow: hidden !important;
                position: relative !important;
            }
            
            #salesplanSummary::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 5px;
                background: linear-gradient(to right, #007bff, #00c6ff);
            }
            
            .date-range-info {
                font-size: 0.85em;
                color: #666;
                margin-top: 10px;
                text-align: right;
                font-style: italic;
            }
            
            .dashboard-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 20px;
            }
            
            .metric-card {
                background: white;
                border-radius: 8px;
                box-shadow: 0 3px 10px rgba(0,0,0,0.08);
                padding: 20px;
                transition: all 0.3s ease;
                cursor: pointer;
                position: relative;
                overflow: hidden;
            }
            
            .metric-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            }
            
            .metric-card:before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
            }
            
            .metric-card.performance-good:before {
                background: #2ecc71;
            }
            
            .metric-card.performance-warning:before {
                background: #f39c12;
            }
            
            .metric-card.performance-danger:before {
                background: #e74c3c;
            }
            
            .billto-header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 15px;
                padding-bottom: 10px;
                border-bottom: 1px solid #eee;
                font-size: 1.1em;
            }
            
            .billto-number {
                font-weight: bold;
                color: #333;
            }
            
            .salesplan-tag {
                background: rgba(0, 123, 255, 0.1);
                color: #007bff;
                padding: 2px 8px;
                border-radius: 4px;
                font-size: 0.85em;
            }
            
            .metrics-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }
            
            .metric-item {
                text-align: center;
                padding: 10px 5px;
            }
            
            .metric-value {
                font-size: 1.6em;
                font-weight: bold;
                margin: 5px 0;
            }
            
            .metric-label {
                font-size: 0.85em;
                color: #777;
            }
            
            .progress-container {
                margin-top: 15px;
            }
            
            .progress-label {
                display: flex;
                justify-content: space-between;
                margin-bottom: 5px;
            }
            
            .progress-title {
                font-size: 0.9em;
                font-weight: 500;
            }
            
            .progress-percentage {
                font-weight: bold;
            }
            
            .progress-bar-container {
                width: 100%;
                height: 8px;
                background: #eee;
                border-radius: 4px;
                overflow: hidden;
            }
            
            .progress-bar {
                height: 100%;
                border-radius: 4px;
            }
            
            .progress-good {
                background: #2ecc71;
            }
            
            .progress-warning {
                background: #f39c12;
            }
            
            .progress-danger {
                background: #e74c3c;
            }
            
            .metric-value.good {
                color: #2ecc71;
            }
            
            .metric-value.warning {
                color: #f39c12;
            }
            
            .metric-value.danger {
                color: #e74c3c;
            }
            
            .loading-container {
                text-align: center;
                padding: 40px 20px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            }
            
            .loading-text {
                margin-top: 15px;
                color: #777;
            }
            
            .no-data-container {
                text-align: center;
                padding: 40px 20px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            }
            
            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
                transition: all 0.3s ease;
            }
            
            .btn-primary:hover {
                background-color: #0069d9;
                border-color: #0062cc;
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            }
            
            .dashboard-controls {
                background: white;
                padding: 12px 20px;
                border-radius: 8px;
                box-shadow: 0 3px 10px rgba(0,0,0,0.08);
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                flex-wrap: wrap;
            }
            
            .controls-title {
                margin: 0;
                padding-right: 15px;
                white-space: nowrap;
                font-size: 16px;
                font-weight: 600;
                color: #333;
                border-right: 1px solid #eee;
                margin-right: 20px;
            }
            
            .control-group {
                margin-right: 20px;
                white-space: nowrap;
                margin-bottom: 5px;
                margin-top: 5px;
            }
            
            .control-group:last-child {
                margin-right: 0;
                margin-left: auto;
            }
            
            .btn-control {
                padding: 8px 12px;
                font-size: 12px;
                height: 36px;
                border-radius: 4px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.12);
                transition: all 0.2s ease;
                margin-right: 3px;
                border: 1px solid #d4d4d4;
            }
            
            .btn-control:hover {
                transform: translateY(-1px);
                box-shadow: 0 3px 5px rgba(0,0,0,0.15);
            }
            
            .btn-control:last-child {
                margin-right: 0;
            }
            
            .btn-group .btn-control {
                box-shadow: none;
                margin-right: 0;
                border-right: none;
            }
            
            .btn-group .btn-control:first-child {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }
            
            .btn-group .btn-control:last-child {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                border-right: 1px solid #d4d4d4;
            }
            
            .btn-group .btn-control:not(:first-child):not(:last-child) {
                border-radius: 0;
            }
            
            .btn-group {
                box-shadow: 0 1px 3px rgba(0,0,0,0.12);
                border-radius: 4px;
                margin-right: 0;
            }
            
            .btn-primary.btn-control {
                background-color: #007bff;
                border-color: #007bff;
                color: white;
            }
            
            .btn-primary.btn-control:hover {
                background-color: #0069d9;
                border-color: #0062cc;
            }
            
            .btn-success.btn-control {
                background-color: #28a745;
                border-color: #28a745;
                color: white;
            }
            
            .btn-success.btn-control:hover {
                background-color: #218838;
                border-color: #1e7e34;
            }
            
            .btn-default.btn-control {
                background-color: #f8f9fa;
                border-color: #d4d4d4;
                color: #333;
            }
            
            .btn-default.btn-control:hover {
                background-color: #e2e6ea;
                border-color: #c8c8c8;
            }

            /* Toast Notification Styles */
            .toast-container {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 9999;
                pointer-events: none;
            }

            .toast {
                background: white;
                border-radius: 8px;
                box-shadow: 0 8px 24px rgba(0,0,0,0.15);
                padding: 20px 30px;
                margin-bottom: 10px;
                min-width: 350px;
                max-width: 450px;
                display: flex;
                align-items: center;
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.3s ease-in-out;
                pointer-events: auto;
                border: none;
            }

            .toast.show {
                opacity: 1;
                transform: translateY(0);
            }

            .toast.success {
                border-left: 4px solid #28a745;
            }

            .toast.error {
                border-left: 4px solid #dc3545;
            }

            .toast.warning {
                border-left: 4px solid #ffc107;
            }

            .toast i {
                margin-right: 15px;
                font-size: 24px;
            }

            .toast.success i {
                color: #28a745;
            }

            .toast.error i {
                color: #dc3545;
            }

            .toast.warning i {
                color: #ffc107;
            }

            .toast-content {
                flex-grow: 1;
            }

            .toast-title {
                font-weight: 600;
                margin-bottom: 4px;
                color: #212529;
                font-size: 1.1em;
            }

            .toast-message {
                color: #6c757d;
                font-size: 0.95em;
            }

            .toast-close {
                margin-left: 15px;
                cursor: pointer;
                color: #adb5bd;
                transition: color 0.2s ease;
                padding: 5px;
                border-radius: 50%;
                background: transparent;
                border: none;
            }

            .toast-close:hover {
                color: #343a40;
                background: rgba(0,0,0,0.05);
            }

            .toast-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                opacity: 0;
                transition: opacity 0.3s ease-in-out;
                z-index: 9998;
                pointer-events: none;
            }

            .toast-backdrop.show {
                opacity: 1;
                pointer-events: auto;
            }
        </style>
    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>

        <!-- Toast Notification Container -->
        <div class="toast-container"></div>

        <section id="content"> 
            <section class="main padder" style="padding-top: 100px; margin-left: 100px;"> 

                <!--Options to select sales plan-->
                <div class="search-container">
                    <div class="row"> 
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
                            <input type="date" name="startDate" id="startDate" class="form-control" tabindex="0"/>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <label>End Date</label>
                            <input type="date" name="endDate" id="endDate" class="form-control" tabindex="0"/>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <button id="loaddata" type="button" class="btn btn-primary" onclick="loadOntimeData();" style="margin: 23px 0px 0px 0px;" tabindex="0">Load Data</button>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <button type="button" class="btn btn-info" onclick="openUPSHolidayModal();" style="margin: 23px 0px 0px 0px;" tabindex="0">
                                <i class="fa fa-calendar"></i> UPS Holidays
                            </button>
                        </div>
                    </div>
                    <div id="dateError" class="row hidden" style="padding-bottom: 10px;">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <div class="alert alert-danger">
                                <strong>Error:</strong> Custom date ranges must be 90 days or less and within the last 2 years. Quarter selections are allowed if available in the dropdown.
                            </div>
                        </div>
                    </div>
                </div>

                <div id="resultsContainer" class="hidden">
                    <h3 class="results-header">On-Time Performance for Salesplan: <span id="salesplanDisplay"></span></h3>
                    
                    <!-- Summary Card for Entire Salesplan -->
                    <div id="salesplanSummary" class="card" style="margin-bottom: 20px; background: linear-gradient(to right, #f8f9fa, white); border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); padding: 0; border-left: 4px solid #007bff; overflow: hidden;">
                        <div style="padding: 15px 20px; border-bottom: 1px solid #eaeaea;">
                            <h4 style="margin: 0; color: #333; font-weight: 600;">
                                <i class="fa fa-bar-chart" style="color: #007bff; margin-right: 8px;"></i> Salesplan Overall Performance
                            </h4>
                            <div class="date-range-info">Data for period: <span id="displayStartDate"></span> to <span id="displayEndDate"></span></div>
                        </div>
                        <div style="padding: 20px;" class="shipment-statistics-container">
                            <!-- Loading spinner - shown by default, hidden when data loads -->
                            <div id="summaryLoadingSpinner" class="text-center" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; background-color: rgba(255, 255, 255, 0.8); display: flex; justify-content: center; align-items: center; z-index: 10;">
                                <div>
                                    <i class="fa fa-spinner fa-spin" style="font-size: 3em; color: #3498db;"></i>
                                    <p style="margin-top: 10px; color: #555;">Loading data...</p>
                                </div>
                            </div>
                            
                            <!-- Content that will be hidden while loading -->
                            <div id="summaryStatisticsContent" style="position: relative; opacity: 0; transition: opacity 0.3s;">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-3 text-center" style="padding: 15px 10px; border-right: 1px dashed #e0e0e0;">
                                                <div style="font-size: 0.9em; color: #777; margin-bottom: 5px;">Total Shipments</div>
                                                <h2 id="totalShipCount" style="margin: 0; font-weight: bold; font-size: 2.5em; color: #333;">0</h2>
                                            </div>
                                            <div class="col-md-3 text-center" style="padding: 15px 10px; border-right: 1px dashed #e0e0e0;">
                                                <div style="font-size: 0.9em; color: #777; margin-bottom: 5px;">On-Time Shipments</div>
                                                <h2 id="totalOntimeCount" style="margin: 0; font-weight: bold; font-size: 2.5em; color: #2ecc71;">0</h2>
                                            </div>
                                            <div class="col-md-3 text-center" style="padding: 15px 10px; border-right: 1px dashed #e0e0e0;">
                                                <div style="font-size: 0.9em; color: #777; margin-bottom: 5px;">Late Shipments</div>
                                                <h2 id="totalLateCount" style="margin: 0; font-weight: bold; font-size: 2.5em; color: #e74c3c;">0</h2>
                                            </div>
                                            <div class="col-md-3 text-center" style="padding: 15px 10px;">
                                                <div style="font-size: 0.9em; color: #777; margin-bottom: 5px;">Customer Experience</div>
                                                <h2 id="overallExperience" style="margin: 0; font-weight: bold; font-size: 2.5em;">0%</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="border-left: 1px solid #eaeaea; padding-left: 25px;">
                                        <div style="height: 80px; position: relative;">
                                            <div style="position: absolute; width: 100%; bottom: 0;">
                                                <div style="margin-bottom: 8px; display: flex; justify-content: space-between;">
                                                    <span style="font-size: 0.95em; font-weight: 500; color: #555;">Customer Experience</span>
                                                    <span id="performancePercentageDisplay" style="font-weight: bold; font-size: 1.1em;">0%</span>
                                                </div>
                                                <div style="width: 100%; height: 12px; background: #eee; border-radius: 6px; overflow: hidden; box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);">
                                                    <div id="performanceProgressBar" style="height: 100%; width: 0%; border-radius: 6px; transition: width 0.5s;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right" style="margin-top: 20px;">
                                            <button type="button" class="btn btn-info btn-sm" onclick="viewDeliveryTimes()" style="border-radius: 4px; padding: 8px 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                                <i class="fa fa-truck"></i> View All Delivery Times
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dashboard-controls">
                        <h4 class="controls-title">Dashboard Controls</h4>
                        
                        <div class="control-group">
                            <div class="btn-group" role="group" aria-label="View Toggle">
                                <button type="button" class="btn btn-primary btn-control active" id="cardViewBtn" onclick="toggleView('card')">
                                    <i class="fa fa-th"></i> Card View
                                </button>
                                <button type="button" class="btn btn-default btn-control" id="tableViewBtn" onclick="toggleView('table')">
                                    <i class="fa fa-table"></i> Table View
                                </button>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <button type="button" class="btn btn-default btn-control" onclick="sortDashboard('customerExperience', 'desc')">
                                <i class="fa fa-sort-amount-desc"></i> Highest Performance
                            </button>
                            <button type="button" class="btn btn-default btn-control" onclick="sortDashboard('customerExperience', 'asc')">
                                <i class="fa fa-sort-amount-asc"></i> Lowest Performance
                            </button>
                            <button type="button" class="btn btn-default btn-control" onclick="sortDashboard('shipCount', 'desc')">
                                <i class="fa fa-sort-numeric-desc"></i> Highest Volume
                            </button>
                        </div>
                        
                        <div class="control-group">
                            <button type="button" class="btn btn-success btn-control" onclick="exportToExcel()">
                                <i class="fa fa-file-excel-o"></i> Export to Excel
                            </button>
                            <button type="button" class="btn btn-info btn-control" onclick="viewDeliveryTimes()">
                                <i class="fa fa-truck"></i> View Delivery Times
                            </button>
                        </div>
                    </div>
                    
                    <div id="dashboard-container">
                        <!-- Dashboard cards will be inserted here -->
                    </div>

                    <div id="table-container" class="hidden" style="background: white; border-radius: 8px; box-shadow: 0 3px 10px rgba(0,0,0,0.08); overflow: hidden;">
                        <table class="table table-hover" style="margin-bottom: 0;">
                            <thead style="background-color: #007bff; color: white;">
                                <tr>
                                    <th>Sales Plan</th>
                                    <th>Bill To #</th>
                                    <th class="text-center">Ship Count</th>
                                    <th class="text-center">On-Time Count</th>
                                    <th class="text-center">Late Count</th>
                                    <th class="text-center">Customer Experience</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- Table data will be inserted here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal for drill-down details -->
                <div id="detailsModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #007bff; color: white;">
                                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                                <h4 class="modal-title">Performance Details for Bill To: <span id="modalBillTo"></span></h4>
                            </div>
                            <div class="modal-body">
                                <div id="modalLoading" class="text-center" style="padding: 20px;">
                                    <i class="fa fa-spinner fa-spin fa-3x"></i>
                                    <p style="margin-top: 15px;">Loading details...</p>
                                </div>
                                <div id="modalContent" class="hidden">
                                    <div class="row" style="margin-bottom: 15px;">
                                        <div class="col-md-9">
                                            <div class="alert alert-info">
                                                <strong>Sales Plan:</strong> <span id="modalSalesPlan"></span>
                                                <span class="pull-right">
                                                    <strong>Overall Customer Experience:</strong> <span id="modalOverallExperience"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <button type="button" class="btn btn-success" onclick="exportShipToExcel()">
                                                <i class="fa fa-file-excel-o"></i> Export to Excel
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover" style="margin-bottom: 0;">
                                            <thead style="background-color: #f4f4f4;">
                                                <tr>
                                                    <th>Ship To #</th>
                                                    <th class="text-center">Ship Count</th>
                                                    <th class="text-center">On-Time Count</th>
                                                    <th class="text-center">Late Count</th>
                                                    <th class="text-center">Customer Experience</th>
                                                </tr>
                                            </thead>
                                            <tbody id="modalTableBody">
                                                <!-- Ship to data will be inserted here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="modalNoData" class="hidden text-center" style="padding: 20px;">
                                    <i class="fa fa-info-circle fa-3x" style="color: #5bc0de;"></i>
                                    <p style="margin-top: 15px;">No ship-to locations found for this bill-to.</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for UPS Holiday Management -->
                <div id="upsHolidayModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #17a2b8; color: white;">
                                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                                <h4 class="modal-title">UPS Holiday Management</h4>
                            </div>
                            <div class="modal-body">
                                <!-- Add Holiday Form -->
                                <div class="add-holiday-section" style="margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
                                    <form id="holidayForm" class="form-inline">
                                        <div class="form-group">
                                            <label for="holidayDate" class="sr-only">Holiday Date</label>
                                            <input type="date" class="form-control" id="holidayDate" required>
                                        </div>
                                        <div class="form-group" style="margin-left: 10px;">
                                            <label for="holidayDesc" class="sr-only">Holiday Description</label>
                                            <input type="text" class="form-control" id="holidayDesc" placeholder="Holiday Description" maxlength="45" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="margin-left: 10px;">
                                            <i class="fa fa-plus"></i> Add Holiday
                                        </button>
                                    </form>
                                </div>

                                <!-- Holiday Table -->
                                <div class="table-responsive">
                                    <table class="table table-hover" id="holidayTable">
                                        <thead style="background-color: #f8f9fa;">
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th style="width: 100px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="holidayTableBody">
                                            <!-- Holiday data will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Status Messages -->
                                <div id="holidayStatus" class="alert" style="display: none; margin-top: 15px;"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div id="deleteConfirmModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #dc3545; color: white;">
                                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                                <h4 class="modal-title">Confirm Delete</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this holiday?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- JavaScript for data loading and display -->
                <script>
                    // Store the data globally so we can re-sort without fetching again
                    var dashboardData = [];
                    var currentSortField = 'customerExperience';
                    var currentSortDirection = 'desc';
                    var currentView = 'card'; // Default view
                    var shipToData = []; // Store ship-to data for export
                    var currentBillTo = '';
                    var currentSalesPlan = '';
                    
                    // Initialize page when document is ready
                    $(document).ready(function() {
                        // Populate the quarter dropdown
                        populateQuarterDropdown();
                        
                        // Set end date to today
                        var today = new Date();
                        var endDateStr = today.toISOString().split('T')[0];
                        $('#endDate').val(endDateStr);
                        
                        // Set start date to 90 days ago
                        var startDate = new Date();
                        startDate.setDate(today.getDate() - 90);
                        var startDateStr = startDate.toISOString().split('T')[0];
                        $('#startDate').val(startDateStr);
                        
                        // Add event listeners for date inputs
                        $('#startDate, #endDate').on('change', function() {
                            validateDateRange();
                            // Clear quarter selection when dates are manually changed
                            $('#quarterSelector').val('');
                        });
                        
                        // Add event listener for quarter selection
                        $('#quarterSelector').on('change', function() {
                            setDatesByQuarter($(this).val());
                        });

                        // Add holiday form submission handler
                        $('#holidayForm').on('submit', function(e) {
                            e.preventDefault();
                            
                            var formData = {
                                holiday_date: $('#holidayDate').val(),
                                holiday_desc: $('#holidayDesc').val()
                            };
                            
                            $.ajax({
                                url: 'globaldata/add_ups_holiday.php',
                                type: 'POST',
                                data: formData,
                                dataType: 'json',
                                success: function(response) {
                                    if (response.success) {
                                        // Reset form
                                        $('#holidayForm')[0].reset();
                                        // Reload holidays
                                        loadHolidays();
                                        // Show success message
                                        showStatusMessage('success', 'Holiday added successfully');
                                    } else {
                                        showStatusMessage('danger', response.message);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    showStatusMessage('danger', 'Failed to add holiday: ' + error);
                                }
                            });
                        });

                        // Delete confirmation handling
                        $('#confirmDeleteBtn').click(function() {
                            if (holidayToDelete) {
                                $.ajax({
                                    url: 'globaldata/delete_ups_holiday.php',
                                    type: 'POST',
                                    data: { holiday_date: holidayToDelete },
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            loadHolidays();
                                            showStatusMessage('success', 'Holiday deleted successfully');
                                        } else {
                                            showStatusMessage('danger', response.message);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        showStatusMessage('danger', 'Failed to delete holiday: ' + error);
                                    }
                                });
                                $('#deleteConfirmModal').modal('hide');
                                holidayToDelete = null;
                            }
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
                        
                        $('#startDate').val(startDate);
                        $('#endDate').val(endDate);
                        
                        // Validate the date range
                        validateDateRange();
                    }
                    
                    // Function to validate date range
                    function validateDateRange() {
                        var startDate = new Date($('#startDate').val());
                        var endDate = new Date($('#endDate').val());
                        
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
                        
                        // If it's a quarter selection, only validate the 2-year limit
                        // Otherwise, validate both the 90-day limit and 2-year limit
                        var isValid = isQuarterSelection ? 
                            (startDate >= twoYearsAgo) : 
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
                    
                    // Global number formatting function
                    function formatNumber(num) {
                        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                    
                    function loadOntimeData() {
                        var salesplan = document.getElementById('salesplan').value.trim();
                        
                        if (salesplan === '') {
                            alert('Please enter a Sales Plan number.');
                            return;
                        }
                        
                        if (!validateDateRange()) {
                            return;
                        }
                        
                        var startDate = document.getElementById('startDate').value;
                        var endDate = document.getElementById('endDate').value;
                        
                        // Update date range display (show as selected, no formatting)
                        document.getElementById('displayStartDate').textContent = startDate;
                        document.getElementById('displayEndDate').textContent = endDate;
                        
                        // Reset summary card values
                        document.getElementById('totalShipCount').textContent = '0';
                        document.getElementById('totalOntimeCount').textContent = '0';
                        document.getElementById('totalLateCount').textContent = '0';
                        document.getElementById('overallExperience').textContent = '0%';
                        document.getElementById('overallExperience').style.color = '#333';
                        document.getElementById('performancePercentageDisplay').textContent = '0%';
                        document.getElementById('performancePercentageDisplay').style.color = '#333';
                        document.getElementById('performanceProgressBar').style.width = '0%';
                        document.getElementById('performanceProgressBar').style.backgroundColor = '#ccc';
                        
                        // Show the summary loading spinner
                        showSummaryLoadingSpinner();
                        
                        // Show loading indicator and container
                        document.getElementById('dashboard-container').innerHTML = `
                            <div class="loading-container">
                                <i class="fa fa-spinner fa-spin fa-3x"></i>
                                <p class="loading-text">Loading performance data...</p>
                            </div>
                        `;
                        document.getElementById('table-container').classList.add('hidden');
                        document.getElementById('dashboard-container').classList.remove('hidden');
                        document.getElementById('resultsContainer').classList.remove('hidden');
                        document.getElementById('salesplanDisplay').textContent = salesplan;
                        
                        // Set card view button as active
                        document.getElementById('cardViewBtn').classList.add('active');
                        document.getElementById('cardViewBtn').classList.add('btn-primary');
                        document.getElementById('cardViewBtn').classList.remove('btn-default');
                        document.getElementById('tableViewBtn').classList.remove('active');
                        document.getElementById('tableViewBtn').classList.remove('btn-primary');
                        document.getElementById('tableViewBtn').classList.add('btn-default');
                        currentView = 'card';
                        
                        // AJAX call to get data
                        $.ajax({
                            url: 'globaldata/data_ontimeperformance.php',
                            data: { 
                                salesplan: salesplan,
                                start_date: startDate,
                                end_date: endDate
                            },
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                // Store data globally
                                dashboardData = data;
                                // Display with default sorting (highest performance first)
                                sortDashboard('customerExperience', 'desc');
                            },
                            error: function(xhr, status, error) {
                                document.getElementById('dashboard-container').innerHTML = `
                                    <div class="no-data-container">
                                        <i class="fa fa-exclamation-circle fa-3x" style="color: #e74c3c;"></i>
                                        <p class="loading-text">Error loading data. Please try again.</p>
                                    </div>
                                `;
                                console.log(error);
                            }
                        });
                    }
                    
                    function toggleView(view) {
                        currentView = view;
                        
                        if (view === 'card') {
                            // Update button states
                            document.getElementById('cardViewBtn').classList.add('active');
                            document.getElementById('cardViewBtn').classList.add('btn-primary');
                            document.getElementById('cardViewBtn').classList.remove('btn-default');
                            document.getElementById('tableViewBtn').classList.remove('active');
                            document.getElementById('tableViewBtn').classList.remove('btn-primary');
                            document.getElementById('tableViewBtn').classList.add('btn-default');
                            
                            // Show cards, hide table
                            document.getElementById('dashboard-container').classList.remove('hidden');
                            document.getElementById('table-container').classList.add('hidden');
                        } else {
                            // Update button states
                            document.getElementById('tableViewBtn').classList.add('active');
                            document.getElementById('tableViewBtn').classList.add('btn-primary');
                            document.getElementById('tableViewBtn').classList.remove('btn-default');
                            document.getElementById('cardViewBtn').classList.remove('active');
                            document.getElementById('cardViewBtn').classList.remove('btn-primary');
                            document.getElementById('cardViewBtn').classList.add('btn-default');
                            
                            // Show table, hide cards
                            document.getElementById('table-container').classList.remove('hidden');
                            document.getElementById('dashboard-container').classList.add('hidden');
                        }
                        
                        // Re-display data with current sort
                        sortDashboard(currentSortField, currentSortDirection);
                    }
                    
                    function sortDashboard(field, direction) {
                        // Update global sorting variables
                        currentSortField = field;
                        currentSortDirection = direction;
                        
                        // If we have data, sort and display it
                        if (dashboardData.length > 0) {
                            // Sort the data
                            dashboardData.sort(function(a, b) {
                                var aValue, bValue;
                                
                                // Convert to appropriate types for comparison
                                if (field === 'customerExperience' || field === 'shipCount' || 
                                    field === 'ontimeCount' || field === 'lateCount') {
                                    aValue = parseFloat(a[field]);
                                    bValue = parseFloat(b[field]);
                                } else {
                                    aValue = a[field];
                                    bValue = b[field];
                                }
                                
                                // Sort based on direction
                                if (direction === 'asc') {
                                    return aValue - bValue;
                                } else {
                                    return bValue - aValue;
                                }
                            });
                            
                            // Calculate and update the overall summary
                            updateSalesPlanSummary(dashboardData);
                            
                            // Display the sorted data in the current view
                            if (currentView === 'card') {
                                displayDashboard(dashboardData);
                                animateSortEffect();
                            } else {
                                displayTable(dashboardData);
                            }
                        }
                    }
                    
                    function animateSortEffect() {
                        // Add a subtle animation to indicate sorting has occurred
                        $('.metric-card').css('opacity', '0.7');
                        setTimeout(function() {
                            $('.metric-card').css('opacity', '1');
                        }, 300);
                    }
                    
                    function displayTable(data) {
                        var tableBody = document.getElementById('tableBody');
                        
                        // Clear previous data
                        tableBody.innerHTML = '';
                        
                        if (data.length === 0) {
                            tableBody.innerHTML = '<tr><td colspan="7" class="text-center">No data found for the specified Sales Plan.</td></tr>';
                            return;
                        }
                        
                        // Populate table with data
                        data.forEach(function(row) {
                            var customerExperience = parseFloat(row.customerExperience);
                            var performanceClass = '';
                            
                            if (customerExperience >= 90) {
                                performanceClass = 'metric-good';
                            } else if (customerExperience >= 75) {
                                performanceClass = 'metric-warning';
                            } else {
                                performanceClass = 'metric-danger';
                            }
                            
                            var tr = document.createElement('tr');
                            tr.style.cursor = 'pointer';
                            
                            tr.innerHTML = `
                                <td>${row.SALESPLAN}</td>
                                <td>${row.BILLTO}</td>
                                <td class="text-center">${formatNumber(row.shipCount)}</td>
                                <td class="text-center">${formatNumber(row.ontimeCount)}</td>
                                <td class="text-center">${formatNumber(row.lateCount)}</td>
                                <td class="text-center"><span class="${performanceClass}">${row.customerExperience}%</span></td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-info" onclick="viewDeliveryTimesForRow(event, '${row.SALESPLAN}')">
                                        <i class="fa fa-truck"></i> Delivery Times
                                    </button>
                                </td>
                            `;
                            
                            // Add click event for drill-down
                            tr.addEventListener('click', function() {
                                showDetails(row.BILLTO, row.SALESPLAN);
                            });
                            
                            tableBody.appendChild(tr);
                        });
                    }
                    
                    function displayDashboard(data) {
                        var container = document.getElementById('dashboard-container');
                        
                        // Clear previous data
                        container.innerHTML = '';
                        
                        if (data.length === 0) {
                            container.innerHTML = `
                                <div class="no-data-container">
                                    <i class="fa fa-search fa-3x" style="color: #777;"></i>
                                    <p class="loading-text">No data found for the specified Sales Plan.</p>
                                </div>
                            `;
                            return;
                        }
                        
                        // Create dashboard grid
                        var dashboardGrid = document.createElement('div');
                        dashboardGrid.className = 'dashboard-grid';
                        
                        // Populate dashboard with cards
                        data.forEach(function(row) {
                            var customerExperience = parseFloat(row.customerExperience);
                            var performanceClass = '';
                            var cardPerformanceClass = '';
                            
                            if (customerExperience >= 90) {
                                performanceClass = 'good progress-good';
                                cardPerformanceClass = 'performance-good';
                            } else if (customerExperience >= 75) {
                                performanceClass = 'warning progress-warning';
                                cardPerformanceClass = 'performance-warning';
                            } else {
                                performanceClass = 'danger progress-danger';
                                cardPerformanceClass = 'performance-danger';
                            }
                            
                            var card = document.createElement('div');
                            card.className = 'metric-card ' + cardPerformanceClass;
                            card.dataset.billto = row.BILLTO; // Store for future drill-down
                            card.dataset.percentage = row.customerExperience; // Store for sorting
                            
                            card.innerHTML = `
                                <div class="billto-header">
                                    <div class="billto-number">Bill To: ${row.BILLTO}</div>
                                    <div class="salesplan-tag">${row.SALESPLAN}</div>
                                </div>
                                
                                <div class="metrics-grid">
                                    <div class="metric-item">
                                        <div class="metric-value">${formatNumber(row.shipCount)}</div>
                                        <div class="metric-label">Total Shipments</div>
                                    </div>
                                    <div class="metric-item">
                                        <div class="metric-value ${performanceClass.split(' ')[0]}">${row.customerExperience}%</div>
                                        <div class="metric-label">Customer Experience</div>
                                    </div>
                                    <div class="metric-item">
                                        <div class="metric-value">${formatNumber(row.ontimeCount)}</div>
                                        <div class="metric-label">On-Time</div>
                                    </div>
                                    <div class="metric-item">
                                        <div class="metric-value">${formatNumber(row.lateCount)}</div>
                                        <div class="metric-label">Late</div>
                                    </div>
                                </div>
                                
                                <div class="progress-container">
                                    <div class="progress-label">
                                        <span class="progress-title">On-Time Performance</span>
                                        <span class="progress-percentage ${performanceClass.split(' ')[0]}">${row.customerExperience}%</span>
                                    </div>
                                    <div class="progress-bar-container">
                                        <div class="progress-bar ${performanceClass.split(' ')[1]}" style="width: ${customerExperience}%"></div>
                                    </div>
                                </div>
                                
                                <div style="text-align: center; margin-top: 10px;">
                                    <button class="btn btn-xs btn-info" onclick="viewDeliveryTimesForCard(event, '${row.SALESPLAN}')">
                                        <i class="fa fa-truck"></i> View Delivery Times
                                    </button>
                                </div>
                            `;
                            
                            // Add click event for drill-down functionality
                            card.addEventListener('click', function() {
                                showDetails(row.BILLTO, row.SALESPLAN);
                            });
                            
                            dashboardGrid.appendChild(card);
                        });
                        
                        container.appendChild(dashboardGrid);
                    }

                    function exportToExcel() {
                        if (dashboardData.length === 0) {
                            alert('No data available to export.');
                            return;
                        }
                        
                        var salesplan = document.getElementById('salesplanDisplay').textContent;
                        var filename = 'OnTimePerformance_' + salesplan + '_' + formatDate(new Date()) + '.csv';
                        
                        // Create form data to post
                        var formData = new FormData();
                        formData.append('data', JSON.stringify(dashboardData));
                        formData.append('salesplan', salesplan);
                        formData.append('type', 'billto');
                        formData.append('filename', filename);
                        
                        // Post to Excel export script
                        fetch('globaldata/export_excel.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Export failed');
                            }
                            return response.blob();
                        })
                        .then(blob => {
                            // Create download link and click it
                            var url = window.URL.createObjectURL(blob);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.click();
                            window.URL.revokeObjectURL(url);
                            document.body.removeChild(a);
                        })
                        .catch(error => {
                            console.error('Error exporting data:', error);
                            alert('Error exporting data. Please try again.');
                        });
                    }
                    
                    function exportShipToExcel() {
                        if (shipToData.length === 0) {
                            alert('No ship-to data available to export.');
                            return;
                        }
                        
                        var billto = currentBillTo;
                        var salesplan = currentSalesPlan;
                        var filename = 'ShipToPerformance_BillTo_' + billto + '_' + formatDate(new Date()) + '.csv';
                        
                        // Create form data to post
                        var formData = new FormData();
                        formData.append('data', JSON.stringify(shipToData));
                        formData.append('billto', billto);
                        formData.append('salesplan', salesplan);
                        formData.append('type', 'shipto');
                        formData.append('filename', filename);
                        
                        // Post to Excel export script
                        fetch('globaldata/export_excel.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Export failed');
                            }
                            return response.blob();
                        })
                        .then(blob => {
                            // Create download link and click it
                            var url = window.URL.createObjectURL(blob);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.click();
                            window.URL.revokeObjectURL(url);
                            document.body.removeChild(a);
                        })
                        .catch(error => {
                            console.error('Error exporting data:', error);
                            alert('Error exporting data. Please try again.');
                        });
                    }
                    
                    function formatDate(date) {
                        var year = date.getFullYear();
                        var month = ('0' + (date.getMonth() + 1)).slice(-2);
                        var day = ('0' + date.getDate()).slice(-2);
                        return year + month + day;
                    }
                    
                    // Format date for display (YYYY-MM-DD to MMM DD, YYYY)
                    function formatDisplayDate(dateStr) {
                        var date = new Date(dateStr);
                        var options = { year: 'numeric', month: 'short', day: 'numeric' };
                        return date.toLocaleDateString('en-US', options);
                    }
                    
                    function showDetails(billto, salesplan) {
                        currentBillTo = billto;
                        currentSalesPlan = salesplan;
                        
                        // Update modal title with billto
                        document.getElementById('modalTitle').textContent = 'Ship-To Details for Bill-To: ' + billto;
                        
                        // Show loading state
                        document.getElementById('modalLoading').classList.remove('hidden');
                        document.getElementById('modalContent').classList.add('hidden');
                        document.getElementById('modalNoData').classList.add('hidden');
                        
                        // Show the modal
                        $('#detailsModal').modal('show');
                        
                        // Get date range values
                        var startDate = document.getElementById('startDate').value;
                        var endDate = document.getElementById('endDate').value;
                        
                        // Fetch ship-to level data
                        $.ajax({
                            url: 'globaldata/data_shiptodetails.php',
                            data: { 
                                billto: billto, 
                                salesplan: salesplan,
                                start_date: startDate,
                                end_date: endDate
                            },
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                // Store data globally for export
                                shipToData = data;
                                
                                // Hide loading indicator
                                document.getElementById('modalLoading').classList.add('hidden');
                                
                                if (data.length === 0) {
                                    // Show no data message
                                    document.getElementById('modalNoData').classList.remove('hidden');
                                } else {
                                    // Display data in modal
                                    populateModalTable(data);
                                    document.getElementById('modalContent').classList.remove('hidden');
                                }
                            },
                            error: function(xhr, status, error) {
                                // Hide loading indicator
                                document.getElementById('modalLoading').classList.add('hidden');
                                
                                // Show error message
                                document.getElementById('modalNoData').classList.remove('hidden');
                                document.getElementById('modalNoData').innerHTML = `
                                    <i class="fa fa-exclamation-triangle fa-3x" style="color: #e74c3c;"></i>
                                    <p style="margin-top: 15px;">Error loading ship-to details. Please try again.</p>
                                `;
                                console.log(error);
                            }
                        });
                    }
                    
                    function populateModalTable(data) {
                        var tableBody = document.getElementById('modalTableBody');
                        
                        // Clear previous data
                        tableBody.innerHTML = '';
                        
                        // Populate table with ship-to data
                        data.forEach(function(row) {
                            var customerExperience = parseFloat(row.customerExperience);
                            var performanceClass = '';
                            
                            if (customerExperience >= 90) {
                                performanceClass = 'metric-good';
                            } else if (customerExperience >= 75) {
                                performanceClass = 'metric-warning';
                            } else {
                                performanceClass = 'metric-danger';
                            }
                            
                            var tr = document.createElement('tr');
                            
                            tr.innerHTML = `
                                <td>${row.SHIPTO}</td>
                                <td class="text-center">${formatNumber(row.shipCount)}</td>
                                <td class="text-center">${formatNumber(row.ontimeCount)}</td>
                                <td class="text-center">${formatNumber(row.lateCount)}</td>
                                <td class="text-center"><span class="${performanceClass}">${row.customerExperience}%</span></td>
                            `;
                            
                            tableBody.appendChild(tr);
                        });
                    }
                    
                    // Function to update the salesplan summary card
                    function updateSalesPlanSummary(data) {
                        // Calculate totals
                        var totalShipCount = 0;
                        var totalOntimeCount = 0;
                        var totalLateCount = 0;
                        
                        data.forEach(function(row) {
                            totalShipCount += parseInt(row.shipCount);
                            totalOntimeCount += parseInt(row.ontimeCount);
                            totalLateCount += parseInt(row.lateCount);
                        });
                        
                        // Calculate overall customer experience
                        var overallExperience = 0;
                        if (totalShipCount > 0) {
                            overallExperience = (totalOntimeCount / totalShipCount) * 100;
                            overallExperience = overallExperience.toFixed(2);
                        }
                        
                        // Format numbers with commas but no decimals
                        function formatNumber(num) {
                            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                        
                        // Update the display
                        document.getElementById('totalShipCount').textContent = formatNumber(totalShipCount);
                        document.getElementById('totalOntimeCount').textContent = formatNumber(totalOntimeCount);
                        document.getElementById('totalLateCount').textContent = formatNumber(totalLateCount);
                        document.getElementById('overallExperience').textContent = overallExperience + '%';
                        document.getElementById('performancePercentageDisplay').textContent = overallExperience + '%';
                        
                        // Set color based on performance
                        var performanceClass = '';
                        var performanceColor = '';
                        
                        if (overallExperience >= 90) {
                            performanceClass = 'good';
                            performanceColor = '#2ecc71';
                        } else if (overallExperience >= 75) {
                            performanceClass = 'warning';
                            performanceColor = '#f39c12';
                        } else {
                            performanceClass = 'danger';
                            performanceColor = '#e74c3c';
                        }
                        
                        // Only change the color of the overall experience display
                        document.getElementById('overallExperience').style.color = performanceColor;
                        document.getElementById('performancePercentageDisplay').style.color = performanceColor;
                        document.getElementById('performanceProgressBar').style.width = overallExperience + '%';
                        document.getElementById('performanceProgressBar').style.backgroundColor = performanceColor;
                        
                        // Hide the spinner and show the content
                        hideSummaryLoadingSpinner();
                    }
                    
                    // Function to show the summary loading spinner
                    function showSummaryLoadingSpinner() {
                        document.getElementById('summaryLoadingSpinner').style.display = 'flex';
                        document.getElementById('summaryStatisticsContent').style.opacity = '0';
                    }
                    
                    // Function to hide the summary loading spinner
                    function hideSummaryLoadingSpinner() {
                        document.getElementById('summaryLoadingSpinner').style.display = 'none';
                        document.getElementById('summaryStatisticsContent').style.opacity = '1';
                    }
                    
                    // Function to navigate to delivery times page
                    function viewDeliveryTimes() {
                        var salesplan = document.getElementById('salesplanDisplay').textContent;
                        var startDate = document.getElementById('startDate').value;
                        var endDate = document.getElementById('endDate').value;
                        
                        // Get quarter value
                        var quarterValue = $('#quarterSelector').val();
                        console.log("Quarter value being passed:", quarterValue);
                        
                        // Build URL with all parameters
                        var url = 'deliverytimes.php?salesplan=' + encodeURIComponent(salesplan) + 
                            '&start_date=' + encodeURIComponent(startDate) + 
                            '&end_date=' + encodeURIComponent(endDate);
                        
                        // Only add quarter parameter if a quarter is selected
                        if (quarterValue && quarterValue !== '') {
                            url += '&quarter=' + encodeURIComponent(quarterValue);
                        }
                        
                        console.log("Opening URL:", url);
                        window.open(url, '_blank');
                    }
                    
                    // Function for card view - stop event propagation to prevent modal from opening
                    function viewDeliveryTimesForCard(event, salesplan) {
                        event.stopPropagation();
                        var startDate = document.getElementById('startDate').value;
                        var endDate = document.getElementById('endDate').value;
                        
                        // Get quarter value
                        var quarterValue = $('#quarterSelector').val();
                        console.log("Quarter value being passed:", quarterValue);
                        
                        // Build URL with all parameters
                        var url = 'deliverytimes.php?salesplan=' + encodeURIComponent(salesplan) + 
                            '&start_date=' + encodeURIComponent(startDate) + 
                            '&end_date=' + encodeURIComponent(endDate);
                        
                        // Only add quarter parameter if a quarter is selected
                        if (quarterValue && quarterValue !== '') {
                            url += '&quarter=' + encodeURIComponent(quarterValue);
                        }
                        
                        console.log("Opening URL:", url);
                        window.open(url, '_blank');
                    }
                    
                    // Function for table view - stop event propagation to prevent modal from opening
                    function viewDeliveryTimesForRow(event, salesplan) {
                        event.stopPropagation();
                        var startDate = document.getElementById('startDate').value;
                        var endDate = document.getElementById('endDate').value;
                        
                        // Use jQuery to get the quarter selector value
                        var quarterValue = $('#quarterSelector').val();
                        console.log("Quarter value being passed:", quarterValue);
                        
                        // Build URL with all parameters
                        var url = 'deliverytimes.php?salesplan=' + encodeURIComponent(salesplan) + 
                            '&start_date=' + encodeURIComponent(startDate) + 
                            '&end_date=' + encodeURIComponent(endDate);
                        
                        // Only add quarter parameter if a quarter is selected
                        if (quarterValue && quarterValue !== '') {
                            url += '&quarter=' + encodeURIComponent(quarterValue);
                        }
                        
                        console.log("Opening URL:", url);
                        window.open(url, '_blank');
                    }

                    // UPS Holiday Management Functions
                    function openUPSHolidayModal() {
                        $('#upsHolidayModal').modal('show');
                        loadHolidays();
                        // Reset form and status message
                        $('#holidayForm')[0].reset();
                        $('#holidayStatus').hide();
                    }

                    function loadHolidays() {
                        $.ajax({
                            url: 'globaldata/get_ups_holidays.php',
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                var tbody = $('#holidayTableBody');
                                tbody.empty();
                                
                                data.forEach(function(holiday) {
                                    var row = `
                                        <tr>
                                            <td>${holiday.upsholiday_date}</td>
                                            <td>${holiday.ups_holiday_desc}</td>
                                            <td>
                                                <button class="btn btn-xs btn-danger" onclick="deleteHoliday('${holiday.upsholiday_date}')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    `;
                                    tbody.append(row);
                                });
                            },
                            error: function(xhr, status, error) {
                                showStatusMessage('error', 'Failed to load holidays: ' + error);
                            }
                        });
                    }

                    // Delete holiday handling
                    var holidayToDelete = null;

                    function deleteHoliday(date) {
                        holidayToDelete = date;
                        $('#deleteConfirmModal').modal('show');
                    }

                    // Status message handling
                    function showStatusMessage(type, message) {
                        var statusDiv = $('#holidayStatus');
                        statusDiv.removeClass('alert-success alert-danger alert-warning')
                            .addClass('alert-' + type)
                            .html(message)
                            .show();
                        
                        // Auto-hide after 3 seconds
                        setTimeout(function() {
                            statusDiv.fadeOut();
                        }, 3000);
                    }
                </script>
            </section>
        </section>
    </body>
</html> 