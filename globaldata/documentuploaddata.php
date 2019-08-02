<?php
include_once '../connection/connection_details.php';
$var_numtype = $_POST['numtype'];
//$var_custnum = $_POST['customnumber'];

switch ($var_numtype) {
    case 'salesplan':
        $var_custnum = $_POST['salesplan'];
        break;
    case 'billto':
        $var_custnum = intval($_POST['billto']);
        break;
    case 'shipto':
        $var_custnum = intval($_POST['shipto']);
        break;
    case 'itemcode':
        $var_custnum = intval($_POST['itemcode']);
        break;

    case 'custom':
        $var_custnum = $_POST['customnumber'];
        break;

    default:
        break;
}

//are any documents already attached?
$docsloaded = $conn1->prepare("SELECT 
    *
FROM
    custaudit.custaudit_uploads
WHERE
    upload_custid = '$var_custnum'"
        . " ORDER BY upload_date DESC;");
$docsloaded->execute();
$docsloadedarray = $docsloaded->fetchAll(pdo::FETCH_ASSOC);
$doccount = count($docsloadedarray);
?>
<div class="hidewrapper">
    <section class="panel" id="documentuploadwrapper" style="margin-bottom: 50px; margin-top: 20px;"> 
        <header class="panel-heading bg bg-inverse h2">Document Uploads<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_documentload"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
        <div id="salesplansummary" class="panel-body" style="background: #efefef">

            <div class="row">
                <div class="col-lg-4">
                    <form action="" method="post" enctype="multipart/form-data" target="_blank" id="uploadform" style="display: -webkit-inline-box;">
                        Select File to Upload:
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="button" class="btn btn-success" id="upload_submit" name="" value="Upload" />
                        <input type="text" name="upload_custid" id="upload_custid" class="form-control hidden" value="<?php echo $var_custnum ?>"/>  
                        <input type="text" name="upload_custtype" id="upload_custtype" class="form-control hidden" value="<?php echo $var_numtype ?>"/>  
                    </form>

                </div>
                <div class="col-lg-8" style="border-left-style: solid; border-left: thick double #ab5252;">
                    <?php
                    if ($doccount == 0) {
                        echo 'No documents loaded';
                    } else {
                        ?>
                        <div class="divtable"  style=''>
                            <div class='divtableheader'>
                                <div class='divtabletitle width16_66' style="cursor: default">ID</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Type</div>
                                <div class='divtabletitle width16_66' style="cursor: default">File Name</div>
                                <div class='divtabletitle width16_66' style="cursor: default">File Type</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Upload Date</div>
                                <div class='divtabletitle width16_66' style="cursor: default">Uploaded By</div>
                            </div>

                            <?php
                            foreach ($docsloadedarray as $key2 => $value) {
                                ?>

                                <div class='divtablerow '>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top; "> <?php echo $docsloadedarray[$key2]['upload_custid']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo $docsloadedarray[$key2]['upload_custtype']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top; text-align: left;  "> <a href="uploads/<?php echo $docsloadedarray[$key2]['upload_filename']; ?>" target="_blank"> <?php echo $docsloadedarray[$key2]['upload_filename']; ?></a> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top;"> <?php echo $docsloadedarray[$key2]['upload_filetype']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top; "> <?php echo $docsloadedarray[$key2]['upload_date']; ?> </div>
                                    <div class='divtabledata width16_66' style="vertical-align: text-top; "> <?php echo $docsloadedarray[$key2]['upload_tsm']; ?> </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div> 

                </div>
            </div>
        </div>
    </section>
</div>
