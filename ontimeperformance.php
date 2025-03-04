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
        </style>
    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>

        <section id="content"> 
            <section class="main padder" style="padding-top: 100px"> 

                <!--Options to select sales plan-->
                <div class="search-container">
                    <div class="row"> 
                        <div class="col-md-4 col-sm-4 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <label>Enter Salesplan</label>
                            <input type="text" name="salesplan" id="salesplan" class="form-control" placeholder="" tabindex="0"/>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-lg-2 col-xl-2 text-center">
                            <button id="loaddata" type="button" class="btn btn-primary" onclick="loadOntimeData();" style="margin: 23px 0px 0px 0px;" tabindex="0">Load Data</button>
                        </div>
                    </div>
                </div>

                <div id="resultsContainer" class="hidden">
                    <h3 class="results-header">On-Time Performance for Salesplan: <span id="salesplanDisplay"></span></h3>
                    
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
                    
                    function loadOntimeData() {
                        var salesplan = document.getElementById('salesplan').value.trim();
                        
                        if (salesplan === '') {
                            alert('Please enter a Sales Plan number.');
                            return;
                        }
                        
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
                            data: { salesplan: salesplan },
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
                            tableBody.innerHTML = '<tr><td colspan="6" class="text-center">No data found for the specified Sales Plan.</td></tr>';
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
                                <td class="text-center">${row.shipCount}</td>
                                <td class="text-center">${row.ontimeCount}</td>
                                <td class="text-center">${row.lateCount}</td>
                                <td class="text-center"><span class="${performanceClass}">${row.customerExperience}%</span></td>
                            `;
                            
                            // Add click event for drill-down
                            tr.addEventListener('click', function() {
                                showDetailsModal(row.BILLTO, row.SALESPLAN, row.customerExperience);
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
                                        <div class="metric-value">${row.shipCount}</div>
                                        <div class="metric-label">Total Shipments</div>
                                    </div>
                                    <div class="metric-item">
                                        <div class="metric-value ${performanceClass.split(' ')[0]}">${row.customerExperience}%</div>
                                        <div class="metric-label">Customer Experience</div>
                                    </div>
                                    <div class="metric-item">
                                        <div class="metric-value">${row.ontimeCount}</div>
                                        <div class="metric-label">On-Time</div>
                                    </div>
                                    <div class="metric-item">
                                        <div class="metric-value">${row.lateCount}</div>
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
                            `;
                            
                            // Add click event for drill-down functionality
                            card.addEventListener('click', function() {
                                showDetailsModal(row.BILLTO, row.SALESPLAN, row.customerExperience);
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
                    
                    function showDetailsModal(billto, salesplan, overallExperience) {
                        // Store current values for export
                        currentBillTo = billto;
                        currentSalesPlan = salesplan;
                        
                        // Set modal title and information
                        document.getElementById('modalBillTo').textContent = billto;
                        document.getElementById('modalSalesPlan').textContent = salesplan;
                        
                        // Set overall experience with color coding
                        var experienceSpan = document.getElementById('modalOverallExperience');
                        var experienceClass = '';
                        
                        if (overallExperience >= 90) {
                            experienceClass = 'metric-good';
                        } else if (overallExperience >= 75) {
                            experienceClass = 'metric-warning';
                        } else {
                            experienceClass = 'metric-danger';
                        }
                        
                        experienceSpan.className = experienceClass;
                        experienceSpan.textContent = overallExperience + '%';
                        
                        // Show loading state
                        document.getElementById('modalLoading').classList.remove('hidden');
                        document.getElementById('modalContent').classList.add('hidden');
                        document.getElementById('modalNoData').classList.add('hidden');
                        
                        // Show the modal
                        $('#detailsModal').modal('show');
                        
                        // Fetch ship-to level data
                        $.ajax({
                            url: 'globaldata/data_shiptodetails.php',
                            data: { billto: billto, salesplan: salesplan },
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
                                <td class="text-center">${row.shipCount}</td>
                                <td class="text-center">${row.ontimeCount}</td>
                                <td class="text-center">${row.lateCount}</td>
                                <td class="text-center"><span class="${performanceClass}">${row.customerExperience}%</span></td>
                            `;
                            
                            tableBody.appendChild(tr);
                        });
                    }
                </script>
            </section>
        </section>
    </body>
</html> 