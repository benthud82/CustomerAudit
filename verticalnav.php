
<!--Need to create separate php page for nav bar-->
<nav id="nav" class="nav-primary hidden-xs nav-vertical" style="position: fixed;"> 
    <ul class="nav" data-spy="" data-offset-top="50"> 
        <!--<li id="dash"><a href="dashboard.php"><i class="fa fa-dashboard fa-lg"></i><span>Dashboard</span></a></li>--> 
        <li id="dash" class="dropdown-submenu" style="cursor: pointer;"><a href="dashboard.php"><i class="fa fa-dashboard fa-lg"></i><span>Dashboards</span></a> 
            <ul class="dropdown-menu"> 
                <li><a href="dashboard.php">Main Dashboard</a></li> 
                <li><a href="mbodashboard.php">Algorithm Dashboard</a></li> 
            </ul> 



        <li id="custlist"><a href="audit.php"><i class="fa fa-list fa-lg"></i><span>Sales Plan Listing</span></a></li> 

        <li id="reports" class="dropdown-submenu" style="cursor: pointer;"> <a ><i class="fa fa-check fa-lg"></i><span>Audit</span></a> 
            <ul class="dropdown-menu"> 
                <li><a href="salesplancheck.php">Sales Plan</a></li> 
                <li><a href="billtocheck.php">Bill To</a></li> 
                <li><a href="shiptocheck.php">Ship To</a></li> 
                <li><a href="customgroupcheck.php">Custom Group</a></li> 
            </ul> 
        </li>

        <li id="itemcheck"><a href="itemcheck.php"><i class="fa fa-cog fa-lg"></i><span>Item Check</span></a></li> 
        <li id="modules" class="dropdown-submenu" style="cursor: pointer;"> <a ><i class="fa fa-list-alt fa-lg"></i><span>Modules</span></a> 
            <ul class="dropdown-menu"> 
                <li><a href="search.php">Search</a></li> 
                <li><a href="customgroups.php">Custom Groups</a></li> 
                <li><a href="auditupload.php">Mass Audit Upload</a></li> 
                <li><a href="tntaudit.php">TNT Audit</a></li> 
                <li><a href="deliverytimes.php">Delivery Times</a></li> 
            </ul> 
        </li>
        <li id="history"><a href="audithistory.php"><i class="fa fa-check-square fa-lg"></i><span>Audit HIstory</span></a></li> 
        <li id="changelog"><a href="changelog.php"><i class="fa fa-cogs fa-lg"></i><span>Change Log</span></a></li> 
<!--        <li id="loose"><a href="loosecustaudit.php"><i class="fa fa-stack-overflow fa-lg"></i><span>Loose<br>Slotting</span></a></li> 
        <li id="case"><a href="casecustaudit.php"><i class="fa fa-cubes fa-lg"></i><span>Case<br>Slotting</span></a></li> 
        <li id="reports" class="dropdown-submenu"> <a ><i class="fa fa-th fa-lg"></i><span>Reports</span></a> 
            <ul class="dropdown-menu"> 
                <li><a href="itemquery.php">Item Query</a></li> 
                <li><a href="optimalbay.php">Optimal Bay</a></li> 
                <li><a href="">Highest Score Items</a></li> 
                <li><a href="">Empty Primary Locs</a></li> 
                <li><a href="">Item Search</a></li> 
                                <li><a href=""><b class="badge pull-right">302</b>XXXX</a></li> 
                                <li><a href="">XXXX</a></li> 
                                <li><a href=""><b class="badge bg-primary pull-right">8</b>XXXX</a></li> 
                                <li><a href=""><b class="badge pull-right">18</b>XXXX</a></li> 
                                <li><a href="">XXXX</a></li> 
            </ul> 
        </li>

        <li id="help"><a href="help.php"><i class="fa fa-question-circle fa-lg"></i><span>Help</span></a></li> -->
    </ul> 
</nav>
