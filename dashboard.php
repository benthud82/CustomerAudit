<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>My Dashboard</title>
        <?php include_once 'headerincludes.php'; ?>
    </head>
    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>
        <?php
        include_once 'connection/connection_details.php';
        include 'globaldata/dashboard_auditcount.php'; //pulls over score increase and count of audits for user 
        ?>

        <section id="content"> 
            <section class="main padder"> 
                <div class="hidewrapper">
                    <section class="panel" id="section_scoreavg" style="margin-bottom: 50px; margin-top: 20px;"> 
                        <header class="panel-heading bg bg-inverse h3">30 Day Score Averages<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_scoreavg"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                        <div id="graphcont_scoreavg" class="panel-body" style="background: #efefef">
                            <div id="scoretrend"></div>
                            <div id="graph_scoreavg"  class="page-break" style="width: 100%">
                                <div class="printrotate " id="charts padded">
                                    <div id="container_scoreavg" class="largecustchartstyle "></div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="row" style="padding-bottom: 25px; padding-top: 20px;">
                    <!--My Score Impact-->
                    <div class="col-sm-12 col-xl-4">
                        <div class="hidewrapper">
                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                <header class="panel-heading bg-inverse"> My Personal Score Impact <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_myscoreimpact"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                <div class="panel-body">
                                    <ul class="list-group"> 
                                        <div id="scoreimpact_me">
                                            <div class="col-md-4 "> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"><strong>Salesplan <i class="fa fa-question-circle helpclick" style="cursor: pointer" id="help_sp_me" data-toggle='tooltip' data-title='Click for Audit Detail' data-placement='top' data-container='body'  ></i></strong></div> 
                                                    </header>
                                                    <div class="panel-body pull-in text-center"> 
                                                        <div class="inline"> 
                                                            <div class="easypiechart easyPieChart" data-percent="<?php echo $IMPACT_MNTH_me_SP ?>" data-bar-color="#5cb85c" style="width: 130px; height: 130px; line-height: 130px;"> 
                                                                <span class="h2 text-center" style="display:inline-block"><?php echo $IMPACT_MNTH_me_SP ?></span>
                                                                <div class="easypie-text text-muted text-center">score inc / dec</div> 
                                                                <canvas width="130" height="130"></canvas>
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </section> 
                                            </div>
                                        </div>

                                        <div id="scoreimpact_group">
                                            <div class="col-md-4 "> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"><strong>Bill-to <i class="fa fa-question-circle helpclick" style="cursor: pointer" id="help_bt_me" data-toggle='tooltip' data-title='Click for Audit Detail' data-placement='top' data-container='body'  ></i></strong></div> 
                                                    </header>
                                                    <div class="panel-body pull-in text-center"> 
                                                        <div class="inline"> 
                                                            <div class="easypiechart easyPieChart" data-percent="<?php echo $IMPACT_MNTH_me_BT ?>" data-bar-color="#5cb85c" style="width: 130px; height: 130px; line-height: 130px;"> 
                                                                <span class="h2 text-center" style="display:inline-block"><?php echo $IMPACT_MNTH_me_BT ?></span>
                                                                <div class="easypie-text text-muted text-center">score inc / dec</div> 
                                                                <canvas width="130" height="130"></canvas>
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </section> 
                                            </div>
                                        </div>
                                        <div id="scoreimpact_all">
                                            <div class="col-md-4 "> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"><strong>Ship-to <i class="fa fa-question-circle helpclick" style="cursor: pointer" id="help_st_me" data-toggle='tooltip' data-title='Click for Audit Detail' data-placement='top' data-container='body'  ></i></strong></div> 
                                                    </header>
                                                    <div class="panel-body pull-in text-center"> 
                                                        <div class="inline"> 
                                                            <div class="easypiechart easyPieChart" data-percent="<?php echo $IMPACT_MNTH_me_ST ?>" data-bar-color="#5cb85c" style="width: 130px; height: 130px; line-height: 130px;"> 
                                                                <span class="h2 text-center" style="display:inline-block"><?php echo $IMPACT_MNTH_me_ST ?></span>
                                                                <div class="easypie-text text-muted text-center">score inc / dec</div> 
                                                                <canvas width="130" height="130"></canvas>
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </section> 
                                            </div>
                                        </div>
                                        <div id="scoreimpact_me">
                                            <div class="col-md-4"> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"> My 30 Day Audit Goal: <strong><br><?php echo $auditcount_me_SP . ' of 10' ?></strong></div> 
                                                    </header>
                                                    <ul class="list-group"> 
                                                        <li class="list-group-item"> 
                                                            <div class="progress progress-small progress-striped active"> 

                                                                <div class="progress-bar progress-bar-success" data-toggle='tooltip' data-title='<?php echo $GOALPERC_me_SP ?>%' data-placement='top' data-container='body'  style="width: <?php echo $GOALPERC_me_SP ?>%;"></div> 
                                                            </div> 
                                                        </li> 
                                                    </ul> 
                                                </section> 
                                            </div>
                                        </div>
                                        <div id="scoreimpact_me_bt">
                                            <div class="col-md-4"> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"> My 30 Day Audit Goal: <strong><br><?php echo $auditcount_me_BT . ' of 10' ?></strong></div> 
                                                    </header>
                                                    <ul class="list-group"> 
                                                        <li class="list-group-item"> 
                                                            <div class="progress progress-small progress-striped active"> 

                                                                <div class="progress-bar progress-bar-success" data-toggle='tooltip' data-title='<?php echo $GOALPERC_me_BT ?>%' data-placement='top' data-container='body'  style="width: <?php echo $GOALPERC_me_BT ?>%;"></div> 
                                                            </div> 
                                                        </li> 
                                                    </ul> 
                                                </section> 
                                            </div>
                                        </div>
                                        <div id="scoreimpact_me_st">
                                            <div class="col-md-4"> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"> My 30 Day Audit Goal: <strong><br><?php echo $auditcount_me_ST . ' of 10' ?></strong></div> 
                                                    </header>
                                                    <ul class="list-group"> 
                                                        <li class="list-group-item"> 
                                                            <div class="progress progress-small progress-striped active"> 

                                                                <div class="progress-bar progress-bar-success" data-toggle='tooltip' data-title='<?php echo $GOALPERC_me_ST ?>%' data-placement='top' data-container='body'  style="width: <?php echo $GOALPERC_me_ST ?>%;"></div> 
                                                            </div> 
                                                        </li> 
                                                    </ul> 
                                                </section> 
                                            </div>
                                        </div>
                                    </ul> 
                                </div>
                            </section>
                        </div>
                    </div>

                    <!--My Group's Score Impact-->
                    <div class="col-sm-12 col-xl-4">
                        <div class="hidewrapper">
                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                <header class="panel-heading bg-inverse"> My Group's Score Impact<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_myscoreimpact_BT"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                <div class="panel-body">
                                    <ul class="list-group"> 
                                        <div id="scoreimpact_me_bt">
                                            <div class="col-md-4 "> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"><strong>Salesplan <i class="fa fa-question-circle helpclick" style="cursor: pointer" id="help_sp_group" data-toggle='tooltip' data-title='Click for Audit Detail' data-placement='top' data-container='body'  ></i></strong></div> 
                                                    </header>
                                                    <div class="panel-body pull-in text-center"> 
                                                        <div class="inline"> 
                                                            <div class="easypiechart easyPieChart" data-percent="<?php echo $IMPACT_MNTH_group_SP ?>" data-bar-color="#5cb85c" style="width: 130px; height: 130px; line-height: 130px;"> 
                                                                <span class="h2 text-center" style="display:inline-block"><?php echo $IMPACT_MNTH_group_SP ?></span>
                                                                <div class="easypie-text text-muted text-center">score inc / dec</div> 
                                                                <canvas width="130" height="130"></canvas>
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </section> 
                                            </div>
                                        </div>
                                        <div id="scoreimpact_group_bt">
                                            <div class="col-md-4 "> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"><strong>Bill-To <i class="fa fa-question-circle helpclick" style="cursor: pointer" id="help_bt_group" data-toggle='tooltip' data-title='Click for Audit Detail' data-placement='top' data-container='body'  ></i></strong></div> 
                                                    </header>
                                                    <div class="panel-body pull-in text-center"> 
                                                        <div class="inline"> 
                                                            <div class="easypiechart easyPieChart" data-percent="<?php echo $IMPACT_MNTH_group_BT ?>" data-bar-color="#5cb85c" style="width: 130px; height: 130px; line-height: 130px;"> 
                                                                <span class="h2 text-center" style="display:inline-block"><?php echo $IMPACT_MNTH_group_BT ?></span>
                                                                <div class="easypie-text text-muted text-center">score inc / dec</div> 
                                                                <canvas width="130" height="130"></canvas>
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </section> 
                                            </div>
                                        </div>

                                        <div id="scoreimpact_all_bt">
                                            <div class="col-md-4"> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"><strong>Ship-To <i class="fa fa-question-circle helpclick" style="cursor: pointer" id="help_st_group" data-toggle='tooltip' data-title='Click for Audit Detail' data-placement='top' data-container='body'  ></i></strong></div> 
                                                    </header>
                                                    <div class="panel-body pull-in text-center"> 
                                                        <div class="inline"> 
                                                            <div class="easypiechart easyPieChart" data-percent="<?php echo $IMPACT_MNTH_group_ST ?>" data-bar-color="#5cb85c" style="width: 130px; height: 130px; line-height: 130px;"> 
                                                                <span class="h2 text-center" style="display:inline-block"><?php echo $IMPACT_MNTH_group_ST ?></span>
                                                                <div class="easypie-text text-muted text-center">score inc / dec</div> 
                                                                <canvas width="130" height="130"></canvas>
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </section> 
                                            </div>
                                        </div>
                                        <div id="scoreimpact_group">
                                            <div class="col-md-4"> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"> My Group's 30 Day Audit Goal: <strong><br><?php echo $auditcount_group_SP . ' of 100' ?></strong></div> 
                                                    </header>
                                                    <ul class="list-group"> 
                                                        <li class="list-group-item"> 
                                                            <div class="progress progress-small progress-striped active"> 

                                                                <div class="progress-bar progress-bar-success" data-toggle='tooltip' data-title='<?php echo $GOALPERC_group_SP ?>%' data-placement='top' data-container='body'  style="width: <?php echo $GOALPERC_group_SP ?>%;"></div> 
                                                            </div> 
                                                        </li> 
                                                    </ul> 
                                                </section> 
                                            </div>
                                        </div>
                                        <div id="scoreimpact_group_bt">
                                            <div class="col-md-4"> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"> My Group's 30 Day Audit Goal: <strong><br><?php echo $auditcount_group_BT . ' of 100' ?></strong></div> 
                                                    </header>
                                                    <ul class="list-group"> 
                                                        <li class="list-group-item"> 
                                                            <div class="progress progress-small progress-striped active"> 

                                                                <div class="progress-bar progress-bar-success" data-toggle='tooltip' data-title='<?php echo $GOALPERC_group_BT ?>%' data-placement='top' data-container='body'  style="width: <?php echo $GOALPERC_group_BT ?>%;"></div> 
                                                            </div> 
                                                        </li> 
                                                    </ul> 
                                                </section> 
                                            </div>
                                        </div>
                                        <div id="scoreimpact_group_st">
                                            <div class="col-md-4"> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"> My Group's 30 Day Audit Goal: <strong><br><?php echo $auditcount_group_ST . ' of 100' ?></strong></div> 
                                                    </header>
                                                    <ul class="list-group"> 
                                                        <li class="list-group-item"> 
                                                            <div class="progress progress-small progress-striped active"> 

                                                                <div class="progress-bar progress-bar-success" data-toggle='tooltip' data-title='<?php echo $GOALPERC_group_ST ?>%' data-placement='top' data-container='body'  style="width: <?php echo $GOALPERC_group_ST ?>%;"></div> 
                                                            </div> 
                                                        </li> 
                                                    </ul> 
                                                </section> 
                                            </div>
                                        </div>
                                    </ul> 
                                </div>
                            </section>
                        </div>
                    </div>


                    <!--Overall Score Impact-->
                    <div class="col-sm-12 col-xl-4">
                        <div class="hidewrapper">
                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                <header class="panel-heading bg-inverse">Overall Score Impact <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_myscoreimpact_ST"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                <div class="panel-body">
                                    <ul class="list-group"> 
                                        <div id="scoreimpact_me_st">
                                            <div class="col-md-4 "> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"><strong>Salesplan <i class="fa fa-question-circle helpclick" style="cursor: pointer" id="help_sp_all" data-toggle='tooltip' data-title='Click for Audit Detail' data-placement='top' data-container='body'  ></i></strong></div> 
                                                    </header>
                                                    <div class="panel-body pull-in text-center"> 
                                                        <div class="inline"> 
                                                            <div class="easypiechart easyPieChart" data-percent="<?php echo $IMPACT_MNTH_all_SP ?>" data-bar-color="#5cb85c" style="width: 130px; height: 130px; line-height: 130px;"> 
                                                                <span class="h2 text-center" style="display:inline-block"><?php echo $IMPACT_MNTH_all_SP ?></span>
                                                                <div class="easypie-text text-muted text-center">score inc / dec</div> 
                                                                <canvas width="130" height="130"></canvas>
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </section> 
                                            </div>
                                        </div>
                                        <div id="scoreimpact_group_st">
                                            <div class="col-md-4 "> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"><strong>Bill-To <i class="fa fa-question-circle helpclick" style="cursor: pointer" id="help_bt_all" data-toggle='tooltip' data-title='Click for Audit Detail' data-placement='top' data-container='body'  ></i></strong></div> 
                                                    </header>
                                                    <div class="panel-body pull-in text-center"> 
                                                        <div class="inline"> 
                                                            <div class="easypiechart easyPieChart" data-percent="<?php echo $IMPACT_MNTH_all_BT ?>" data-bar-color="#5cb85c" style="width: 130px; height: 130px; line-height: 130px;"> 
                                                                <span class="h2 text-center" style="display:inline-block"><?php echo $IMPACT_MNTH_all_BT ?></span>
                                                                <div class="easypie-text text-muted text-center">score inc / dec</div> 
                                                                <canvas width="130" height="130"></canvas>
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </section> 
                                            </div>
                                        </div>

                                        <div id="scoreimpact_all_st">
                                            <div class="col-md-4"> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"><strong>Ship-To <i class="fa fa-question-circle helpclick" style="cursor: pointer" id="help_st_all" data-toggle='tooltip' data-title='Click for Audit Detail' data-placement='top' data-container='body'  ></i></strong></div> 
                                                    </header>
                                                    <div class="panel-body pull-in text-center"> 
                                                        <div class="inline"> 
                                                            <div class="easypiechart easyPieChart" data-percent="<?php echo $IMPACT_MNTH_all_ST ?>" data-bar-color="#5cb85c" style="width: 130px; height: 130px; line-height: 130px;"> 
                                                                <span class="h2 text-center" style="display:inline-block"><?php echo $IMPACT_MNTH_all_ST ?></span>
                                                                <div class="easypie-text text-muted text-center">score inc / dec</div> 
                                                                <canvas width="130" height="130"></canvas>
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </section> 
                                            </div>
                                        </div>
                                        <div id="scoreimpact_all">
                                            <div class="col-md-4"> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"> Overall 30 Day Audit Goal: <strong><br><?php echo $auditcount_all_SP . ' of 200' ?></strong></div> 
                                                    </header>
                                                    <ul class="list-group"> 
                                                        <li class="list-group-item"> 
                                                            <div class="progress progress-small progress-striped active"> 

                                                                <div class="progress-bar progress-bar-success" data-toggle='tooltip' data-title='<?php echo $GOALPERC_all_SP ?>%' data-placement='top' data-container='body'  style="width: <?php echo $GOALPERC_all_SP ?>%;"></div> 
                                                            </div> 
                                                        </li> 
                                                    </ul> 
                                                </section> 
                                            </div>
                                        </div>
                                        <div id="scoreimpact_all_bt">
                                            <div class="col-md-4"> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"> Overall 30 Day Audit Goal: <strong><br><?php echo $auditcount_all_BT . ' of 200' ?></strong></div> 
                                                    </header>
                                                    <ul class="list-group"> 
                                                        <li class="list-group-item"> 
                                                            <div class="progress progress-small progress-striped active"> 

                                                                <div class="progress-bar progress-bar-success" data-toggle='tooltip' data-title='<?php echo $GOALPERC_all_BT ?>%' data-placement='top' data-container='body'  style="width: <?php echo $GOALPERC_all_BT ?>%;"></div> 
                                                            </div> 
                                                        </li> 
                                                    </ul> 
                                                </section> 
                                            </div>
                                        </div>
                                        <div id="scoreimpact_all_st">
                                            <div class="col-md-4"> 
                                                <section class="panel"> 
                                                    <header class="panel-heading bg-white"> 
                                                        <div class="text-center h5"> Overall 30 Day Audit Goal: <strong><br><?php echo $auditcount_all_ST . ' of 200' ?></strong></div> 
                                                    </header>
                                                    <ul class="list-group"> 
                                                        <li class="list-group-item"> 
                                                            <div class="progress progress-small progress-striped active"> 

                                                                <div class="progress-bar progress-bar-success" data-toggle='tooltip' data-title='<?php echo $GOALPERC_all_ST ?>%' data-placement='top' data-container='body'  style="width: <?php echo $GOALPERC_all_ST ?>%;"></div> 
                                                            </div> 
                                                        </li> 
                                                    </ul> 
                                                </section> 
                                            </div>
                                        </div>
                                    </ul> 
                                </div>
                            </section>
                        </div>
                    </div>


                    <!--My Assigned Tasks Panel-->
                    <div class="col-md-12 col-lg-9 col-xl-10">
                        <div class="hidewrapper">
                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                <header class="panel-heading bg-danger"> My Assigned Tasks <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_asgntasks"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                <div class="panel-body">
                                    <div id="asgntaskstablecontainer" class="">
                                        <table id="asgntaskstable" class="table table-bordered table-striped" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Assigned By</th>
                                                    <th>Assigned Date</th>
                                                    <th>Assigned To TSM</th>
                                                    <th>Assigned Group</th>
                                                    <th>Customer Group</th>
                                                    <th>Customer ID</th>
                                                    <th>Item Code</th>
                                                    <th>Comment</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!--My Group's Assigned Tasks Panel-->
                        <div class="hidewrapper">
                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                <header class="panel-heading bg-warning"> My Group's Assigned Tasks <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_asgntasksgroup"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                <div class="panel-body">
                                    <div id="asgntasksgrouptablecontainer" class="">
                                        <table id="asgntasksgrouptable" class="table table-bordered table-striped" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Assigned By</th>
                                                    <th>Assigned Date</th>
                                                    <th>Assigned To TSM</th>
                                                    <th>Assigned Group</th>
                                                    <th>Customer Group</th>
                                                    <th>Customer ID</th>
                                                    <th>Item Code</th>
                                                    <th>Comment</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!--My Completed Tasks Panel-->
                        <div class="hidewrapper">
                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                <header class="panel-heading bg-inverse"> My Completed Tasks <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_comptasks"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                <div class="panel-body">
                                    <div id="comptaskstablecontainer" class="">
                                        <table id="comptaskstable" class="table table-bordered table-striped" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Assigned By</th>
                                                    <th>Assigned Date</th>
                                                    <th>Assigned To TSM</th>
                                                    <th>Assigned To Group</th>
                                                    <th>Completed Date</th>
                                                    <th>Customer Group</th>
                                                    <th>Customer ID</th>
                                                    <th>Item Code</th>
                                                    <th>Comment</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 col-xl-2">

                        <!--Most Recent Connections-->
                        <div class="hidewrapper">
                            <section class="panel portlet-item" style="opacity: 1; z-index: 0;"> 
                                <header class="panel-heading bg-info"> Most Recent Connections <i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_recentconnections"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header> 
                                <div class="panel-body">
                                    <ul class="list-group"> 
                                        <div id="recentconnections"></div>
                                    </ul> 
                                </div>
                            </section>
                        </div>
                    </div>
                    <!-- Complete Task Modal -->
                    <div id="addcommentmodal" class="modal fade " role="dialog">
                        <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Complete Task</h4>
                                </div>
                                <form class="form-horizontal" id="postitemaction">
                                    <div class="modal-body">
                                        <div class="form-group">

                                            <div class="col-md-3 hidden">
                                                <!--ID of the assigned comment to pass to postcompletetask.php-->
                                                <input type="text" name="assid" id="assid" class="form-control" placeholder="" tabindex="1"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Your User Name:</label>
                                            <div class="col-md-3">
                                                <input type="text" name="useridmodal" id="useridmodal" class="form-control" placeholder="Enter User Name..." tabindex="1"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-4 control-label">Assigned to Correct Group/TSM?:</label>
                                                <div class="switch-field col-md-3"style="padding-left: 20px;">
                                                    <input type="radio" id="switch_left" name="switch_2" value="yes" checked/>
                                                    <label for="switch_left" class="greenbackground">Yes</label>
                                                    <input type="radio" id="switch_right" name="switch_2" value="no" />
                                                    <label id="nolabel" for="switch_right">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Hidden data.  Show if assigned incorrectly-->
                                        <div class="hiddencheckboxdata hidden" id="hiddendata_reassigntask">
                                            <div class="formpadder">
                                                <h5 style="padding-bottom: 5px;" class="boldtext">Reassign this task to a different group/TSM</h5>

                                                <div class="form-group"> 
                                                    <label class="col-lg-4 control-label">Assign to Group:</label> 
                                                    <div class="col-lg-3"> 
                                                        <select name="reassign_group" id="reassign_group" class="form-control"> 
                                                            <option value="IM">Inventory Mgmt</option> 
                                                            <option value="DC">Distribution Center</option> 
                                                            <option value="SC">Supply Chain</option> 
                                                            <option value="OTHER">Other</option> 
                                                        </select> 
                                                    </div> 
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Assign to TSM:</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="reassign_TSM" id="reassign_TSM" class="form-control" placeholder="TSM ID" tabindex="6"/>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-danger btn-lg" name="submitreassign" id="submitreassign">Reassign Task</button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Taken Action:</label>
                                            <div class="col-md-8">
                                                <textarea rows="2" placeholder="Enter brief description of action taken..." class="form-control" id="comment_actiontaken" name="comment_actiontaken" tabindex="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-lg pull-left" name="submititemaction" id="submititemaction">Mark Action Complete</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!--Modal for pick detail data after bay is clicked in datatable-->
                    <div id="helpclickmodal" class="modal fade " role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Score Audit / Impact Data</h4>
                                </div>

                                <div class="modal-body" id="" style="margin: 50px;">
                                    <div id="itemdetailcontainerloading" class="loading col-sm-12 text-center hidden" >
                                        <img src="../ajax-loader-big.gif"/>
                                    </div>
                                    <div id="auditdata"></div>
                                </div>

                            </div>
                        </div>
                    </div>



                </div>
            </section>
        </section>



        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});</script>

        <script>
            $("#dash").addClass('active');
            $(document).ready(function () {
                var userid = $('#userid').text();
                //fill the my assinged tasks datatable
                oTable3 = $('#asgntaskstable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[2, "asc"]], "scrollX": true,
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                    'sAjaxSource': "globaldata/dashboard_asgntasks.php?userid=" + userid,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(8)', nRow).append("<div class='text-center'><i class='fa fa-times-circle commentclick' style='cursor: pointer;' data-toggle='tooltip' data-title='Mark as Complete' data-placement='top' data-container='body' ></i> </div>");
                    }
                });
                //fill the my group's assinged tasks datatable
                oTable5 = $('#asgntasksgrouptable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[2, "asc"]],
                    "scrollX": true,
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                    'sAjaxSource': "globaldata/dashboard_asgntasksgroup.php?userid=" + userid,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(8)', nRow).append("<div class='text-center'><i class='fa fa-times-circle commentclick_grouptask' style='cursor: pointer;' data-toggle='tooltip' data-title='Mark as Complete' data-placement='top' data-container='body' ></i> </div>");
                    }
                });

                //fill the my completed tasks datatable
                oTable4 = $('#comptaskstable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[2, "asc"]],
                    "scrollX": true,
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                    'sAjaxSource': "globaldata/dashboard_comptasks.php?userid=" + userid
                });

                //fill the most recent connection divs $recentconnections
                $.ajax({
                    url: 'globaldata/dashboard_recentconnections.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {userid: userid}, //pass userid from the userid div in the header
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#recentconnections").html(ajaxresult);
                    }
                });

                //fill the my 30 day score impact divs #myscoreimpact
                $.ajax({
                    url: 'globaldata/dashboard_myimpact.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto                     data: {userid: userid}, //pass userid from the userid div in the header
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        //                        $("#myscoreimpact").html(ajaxresult);
                    }
                });

                //Score averages graph
                var options = {
                    chart: {
                        marginTop: 50,
                        marginBottom: 135,
                        renderTo: 'container_scoreavg',
                        type: 'spline'
                    }, credits: {
                        enabled: false
                    },
                    plotOptions: {
                        spline: {
                            marker: {
                                enabled: false
                            }
                        },
                        series: {
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false,
                                verticalAlign: 'top',
                                color: '#000000',
                                connectorColor: '#000000',
                                formatter: function () {
                                    return Highcharts.numberFormat(this.y, 2) + ' %';
                                }
                            },
                            point: {
                                events: {
                                    click: function () {
                                    }
                                }
                            }
                        }
                    },
                    title: {
                        text: ' '
                    },
                    xAxis: {
                        categories: [], labels: {
                            rotation: -90,
                            y: 25,
                            align: 'right',
                            step: 5,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        },
                        legend: {
                            y: "10",
                            x: "5"
                        }

                    },
                    yAxis: {
                        title: {
                            text: 'Weekly Score Averages'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }],
                        opposite: true
                    }, tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                    this.x + ': ' + Highcharts.numberFormat(this.y, 2);
                        }
                    },
                    series: []
                };
                $.ajax({
                    url: 'globaldata/graph_scoreavg.php',
//                    data: {"salesplan": salesplan},
                    type: 'GET',
                    dataType: 'json',
                    async: 'true',
                    success: function (json) {
                        options.xAxis.categories = json[0]['data'];
                        options.series[0] = json[1];
                        options.series[1] = json[2];
                        options.series[2] = json[3];
                        chart = new Highcharts.Chart(options);
                        series = chart.series;
                    }
                });
            });

            //Trend calc and current score average info box
            $.ajax({
                url: 'globaldata/scoreavgtrend.php',
                type: 'POST',
                dataType: 'html',
//                    data: {userid: userid, itemnum: itemnum},
                success: function (result) {
                    $("#scoretrend").html(result);
                }
            });

            //jquery to show add comments modal and fill relevant fields with clicked info
            $(document).on("click", ".commentclick", function (e) {
                $('#addcommentmodal').modal('toggle');
                $('#useridmodal').val($('#userid').text());
                var tr = $(this).closest("tr");
                var rowindex = tr.index();
                var assigntask_id = oTable3.row(rowindex).data()[0];
                $('#assid').val(assigntask_id);
            });

            //jquery to show add comments modal and fill relevant fields with clicked info
            $(document).on("click", ".commentclick_grouptask", function (e) {
                $('#addcommentmodal').modal('toggle');
                $('#useridmodal').val($('#userid').text());
                var tr = $(this).closest("tr");
                var rowindex = tr.index();
                var assigntask_id = oTable5.row(rowindex).data()[0];
                $('#assid').val(assigntask_id);
            });

            //post item action button clicked
            $(document).on("click", "#submititemaction", function (event) {
                var userid = $('#userid').text();
                //                event.preventDefault();
                var assigntask_id = $('#assid').val();
                var comment = $('#comment_actiontaken').val();
                var useridmodal = $('#useridmodal').val();
                if (document.getElementById('switch_left').checked) {
                    var correct = 1;
                } else {
                    var correct = 0;
                }


                var formData = 'assigntask_id=' + assigntask_id + '&comment=' + comment + '&correct=' + correct + '&useridmodal=' + useridmodal;
                $.ajax({
                    url: 'formpost/postcompletetask.php',
                    type: 'POST',
                    data: formData,
                    success: function (result) {
                        $('#addcommentmodal').modal('hide');
                        event.preventDefault();
                    }
                });

                //redraw the table with refreshed data
                oTable3 = $('#asgntaskstable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[2, "asc"]], "scrollX": true,
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                    'sAjaxSource': "globaldata/dashboard_asgntasks.php?userid=" + userid,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(7)', nRow).append("<div class='text-center'><i class='fa fa-times-circle commentclick' style='cursor: pointer;' data-toggle='tooltip' data-title='Mark as Complete' data-placement='top' data-container='body' ></i> </div>");
                    }
                });

                //redraw the my completed tasks datatable
                oTable4 = $('#comptaskstable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[2, "asc"]],
                    "scrollX": true,
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                    'sAjaxSource': "globaldata/dashboard_comptasks.php?userid=" + userid
                });


                //fill the my group's assinged tasks datatable
                oTable5 = $('#asgntasksgrouptable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[2, "asc"]],
                    "scrollX": true,
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                    'sAjaxSource': "globaldata/dashboard_asgntasksgroup.php?userid=" + userid,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(8)', nRow).append("<div class='text-center'><i class='fa fa-times-circle commentclick_grouptask' style='cursor: pointer;' data-toggle='tooltip' data-title='Mark as Complete' data-placement='top' data-container='body' ></i> </div>");
                    }
                });
            });

            //reassign task button clicked
            $(document).on("click", "#submitreassign", function (event) {
                var userid = $('#userid').text();
                var reassign_group = $('#reassign_group').val();
                var reassign_TSM = $('#reassign_TSM').val();
                //                event.preventDefault();
                var assigntask_id = $('#assid').val();

                var formData = 'assigntask_id=' + assigntask_id + '&reassign_group=' + reassign_group + '&reassign_TSM=' + reassign_TSM;
                $.ajax({
                    url: 'formpost/postreassigntask.php',
                    type: 'POST',
                    data: formData,
                    success: function (result) {
                        $('#addcommentmodal').modal('hide');

                    }
                });

                //redraw the table with refreshed data
                oTable3 = $('#asgntaskstable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[2, "asc"]], "scrollX": true,
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                    'sAjaxSource': "globaldata/dashboard_asgntasks.php?userid=" + userid,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(7)', nRow).append("<div class='text-center'><i class='fa fa-times-circle commentclick' style='cursor: pointer;' data-toggle='tooltip' data-title='Mark as Complete' data-placement='top' data-container='body' ></i> </div>");
                    }
                });

                //redraw the my completed tasks datatable
                oTable4 = $('#comptaskstable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[2, "asc"]],
                    "scrollX": true,
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                    'sAjaxSource': "globaldata/dashboard_comptasks.php?userid=" + userid
                });

                //fill the my group's assinged tasks datatable
                oTable5 = $('#asgntasksgrouptable').DataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    //                    dom: 'frltip',
                    destroy: true,
                    "order": [[2, "asc"]],
                    "scrollX": true,
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                    'sAjaxSource': "globaldata/dashboard_asgntasksgroup.php?userid=" + userid,
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        $('td:eq(8)', nRow).append("<div class='text-center'><i class='fa fa-times-circle commentclick_grouptask' style='cursor: pointer;' data-toggle='tooltip' data-title='Mark as Complete' data-placement='top' data-container='body' ></i> </div>");
                    }
                });
            });

            //On close of action modal, clear all fields and toggle hidden
            $('.modal').on('hidden.bs.modal', function () {
                //                $('#hiddendatacheckboxim').addClass('hidden');
                $('#hiddendata_reassigntask').addClass('hidden');
                $(this).find('form')[0].reset();
            });

            //show/hide reassign box if task is assigned to wrong tsm/group
            $(document).on("click", ".switch-field", function (e) {
                if (document.getElementById('switch_left').checked) {
                    $('#hiddendata_reassigntask').addClass('hidden');
                } else {
                    $('#hiddendata_reassigntask').removeClass('hidden');
                }
            });

            $(document).on("click touchstart", ".helpclick", function (e) {
                $('#helpclickmodal').modal('toggle');
                $('#itemdetailcontainerloading').toggleClass('hidden');
                $('#divtablecontainer').addClass('hidden');
                var clickedid = $(this).attr('id');
                var userid = $('#userid').text();
                debugger;
                $.ajax({
                    url: 'globaldata/auditimpactdata.php',
                    data: {clickedid: clickedid, userid: userid},
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $('#itemdetailcontainerloading').toggleClass('hidden');
                        $('#divtablecontainer').removeClass('hidden');
                        $("#auditdata").html(ajaxresult);
                    }
                });
            });

        </script>
    </body>
</html>
