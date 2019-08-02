<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    ?>
    <head>
        <title>Change Log</title>
        <?php include_once 'headerincludes.php'; ?>
    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>
        <?php
        include_once 'connection/connection_details.php';
        include_once 'globaldata/openchangelogs.php';
        include_once 'globaldata/completedchangelogs.php';

        $compcount = count($completedlogsarray);
        $opencount = count($openlogsarray);
        ?>

        <section id="content"> 
            <section class="main padder"> 


                <div class="row"style="margin-top: 20px;">
                    
                    <div class="col-sm-6 portlet ui-sortable">
                        <section class="panel portlet-item" style="opacity: 1;"> 
                            <header class="panel-heading bg-info" style="font-size: 20px"> Change Log Open Tasks <i class="fa fa-question-circle pull-right" data-toggle='tooltip' data-title='Open requests sorted by priority' data-placement='top' data-container='body' ></i></header> 
                            <section class="panel-body"> 

                                <?php foreach ($openlogsarray as $key => $value) { ?>
                                    <article class="media"> 
                                        <div class="pull-left thumb-small">
                                            <span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-muted"></i><i class="fa-stack-1x text-white" style="font-family: calibri;"><?php echo $openlogsarray[$key]['changelog_priority']; ?></i>  </span> 
                                        </div> 
                                        <div class="media-body"> 
                                            <div class="pull-right media-mini text-center text-muted"> 
                                                <strong class="h4"><?php echo $openlogsarray[$key]['changelog_reqdate']; ?></strong><br> 
                                                <small class="label bg-light">Request Date</small> 
                                            </div> 
                                            <a href="#" class="h4"><?php echo $openlogsarray[$key]['changelog_description']; ?></a> 
                                            <small class="block"><?php echo $openlogsarray[$key]['changelog_comment']; ?></small> 
                                        </div> 
                                    </article> 
                                    <?php if ($key + 1 <> $opencount) { ?>
                                        <div class="line pull-in"></div> 
                                    <?php } ?>

                                <?php }
                                ?>

                            </section> 
                        </section>
                    </div>
                    
                    <div class="col-sm-6 portlet ui-sortable">
                        <section class="panel portlet-item" style="opacity: 1;"> 
                            <header class="panel-heading bg-success" style="font-size: 20px"> Change Log Completed Tasks <i class="fa fa-question-circle pull-right" data-toggle='tooltip' data-title='Completed requests sorted by most recent completion date' data-placement='top' data-container='body' ></i></header> 
                            <section class="panel-body"> 

                                <?php foreach ($completedlogsarray as $key => $value) { ?>
                                    <article class="media"> 
                                        <div class="pull-left thumb-small">
                                            <span class="fa-stack fa-lg"> <i class="fa fa-circle fa-stack-2x text-success"></i> <i class="fa fa-check fa-stack-1x text-white"></i> </span>
                                        </div> 
                                        <div class="media-body"> 
                                            <div class="pull-right media-mini text-center text-muted"> 
                                                <strong class="h4"><?php echo $completedlogsarray[$key]['changelog_completedate']; ?></strong><br> 
                                                <small class="label bg-light">Completed Date</small> 
                                            </div> 
                                            <a href="#" class="h4"><?php echo $completedlogsarray[$key]['changelog_description']; ?></a> 
                                            <small class="block"><?php echo $completedlogsarray[$key]['changelog_comment']; ?></small> 
                                        </div> 
                                    </article> 
                                    <?php if ($key + 1 <> $compcount) { ?>
                                        <div class="line pull-in"></div> 
                                    <?php } ?>

                                <?php }
                                ?>

                            </section> 
                        </section>
                    </div>
                
                </div>
            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            $("#changelog").addClass('active'); //add active strip to audit on vertical nav
        </script>

    </body>
</html>
