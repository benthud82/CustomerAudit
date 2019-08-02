
<header id="header" class="navbar"  style="border-radius: 0px;position: fixed; width: 100%; top: 0; z-index: 1030;">

    <?php if (isset($_SESSION['MYUSER'])) { ?>
    <div class="pull-right btn btn-sm btn-info" style="margin:10px 30px 0px 0px; padding: 6px 10px;" id="userid"><?php echo $_SESSION['MYUSER']; ?></div>  <a href="logout.php" ><div class="pull-right btn btn-sm btn-danger" style="margin:10px 30px 0px 0px" id="btn_logout"> LOGOUT </div></a>
    <?php } else { ?>
        <a href="signin.php" ><div class="pull-right btn btn-sm btn-danger" style="margin:10px 30px 0px 0px"> LOGIN </div></a>
    <?php } ?>

    <a class="navbar-brand" href="dashboard.php"> <img src="../HSILogo.png" alt="HSI" height="32" width="32" style="display: inline"></a> 

    <button type="button" class="btn btn-link pull-left nav-toggle visible-xs" data-toggle="class:slide-nav slide-nav-left" data-target="body"> 
        <i class="fa fa-bars fa-lg text-default"></i> 
    </button> 

    <?php include 'popularbuttons_header.php'; ?>

</header>