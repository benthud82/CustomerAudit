<?php
include_once '../connection/connection_details.php';
$uppersearchterm = strtoupper($_POST['searchterm']);

$salesplan = $conn1->prepare("SELECT DISTINCT
                                    B.SALESPLAN, A.BILLTONUM, A.BILLTONAME,  A.TOTR12LINES,A.TOTR12SALES
                                FROM
                                    custaudit.customerscores_billto A
                                        join
                                    custaudit.salesplan B ON BILLTO = BILLTONUM
                                WHERE
                                    (UPPER(A.BILLTONAME) like ('%$uppersearchterm%') or A.BILLTONUM like ('%$uppersearchterm%'))
                                ORDER BY A.TOTR12LINES DESC;");
$salesplan->execute();
$salesplansearcharray = $salesplan->fetchAll(pdo::FETCH_ASSOC);



if (count($salesplansearcharray) <= 0) {
    echo 'No Matches';
} else { //show matches 
    ?>
    <table class="table table-striped m-b-none text-small"> 
        <thead> 
            <tr class="text-center"> 
                <th class="text-center">Sales Plan</th> 
                <th class="text-center">Bill-to Number</th> 
                <th class="text-center">Bill-to Name</th> 
                <th class="text-center">12 Month Lines</th> 
                <th class="text-center">12 Month Sales</th> 
            </tr> 
        </thead> 
        <tbody> 
            <?php foreach ($salesplansearcharray as $key => $value) {
                ?>
                <tr class="text-center" >
                    <td data-container="body" data-toggle="tooltip" data-title="Audit Salesplan" data-placement="top" > 
                        <a style="cursor: pointer" href="salesplancheck.php?salesplan=<?php echo $salesplansearcharray[$key]['SALESPLAN']; ?>"> 
                            <?php echo $salesplansearcharray[$key]['SALESPLAN']; ?>
                        </a>
                    </td> 
                    <td data-container="body" data-toggle="tooltip" data-title="Audit Bill-To" data-placement="top" > 
                        <a style="cursor: pointer" href="billtocheck.php?billto=<?php echo $salesplansearcharray[$key]['BILLTONUM']; ?>"> 
                            <?php echo $salesplansearcharray[$key]['BILLTONUM']; ?>
                        </a>
                    </td> 
                    <td><?php echo $salesplansearcharray[$key]['BILLTONAME']; ?></td> 
                    <td><?php echo number_format($salesplansearcharray[$key]['TOTR12LINES'], 0, '.', ','); ?></td> 
                    <td><?php echo '$' . number_format($salesplansearcharray[$key]['TOTR12SALES'], 0); ?></td> 

                </tr>
                <?php
            }
        }

        ?>






    </tbody> 
</table>
