<?php
include_once '../connection/connection_details.php';
$uppersearchterm = strtoupper($_POST['searchterm']);

$shiptosearch = $conn1->prepare("SELECT DISTINCT
                                                                A.BILLTONUM,
                                                                A.BILLTONAME,
                                                                B.SHIPTONUM,
                                                                B.SHIPTONAME,
                                                                B.TOTR12LINES,
                                                                B.TOTR12SALES
                                                            FROM
                                                                custaudit.customerscores_billto A
                                                                    JOIN
                                                                custaudit.customerscores_shipto B ON A.BILLTONUM = B.BILLTONUM
                                                            WHERE
                                                                (UPPER(B.SHIPTONAME) LIKE ('%$uppersearchterm%') or SHIPTONUM LIKE ('%$uppersearchterm%'))
                                                            ORDER BY B.TOTR12LINES DESC;");
$shiptosearch->execute();
$shiptosearcharray = $shiptosearch->fetchAll(pdo::FETCH_ASSOC);



if (count($shiptosearcharray) <= 0) {
    echo 'No Matches';
} else { //show matches 
    ?>
    <table class="table table-striped m-b-none text-small"> 
        <thead> 
            <tr class="text-center"> 
                <th class="text-center">Bill-to Number</th> 
                <th class="text-center">Bill-to Name</th> 
                <th class="text-center">Ship-to Number</th> 
                <th class="text-center">Ship-to Name</th> 
                <th class="text-center">12 Month Lines</th> 
                <th class="text-center">12 Month Sales</th> 
            </tr> 
        </thead> 
        <tbody> 
            <?php foreach ($shiptosearcharray as $key => $value) {
                ?>
                <tr class="text-center" >
                    <td data-container="body" data-toggle="tooltip" data-title="Audit Bill-To" data-placement="top" > 
                        <a style="cursor: pointer" href="billtocheck.php?billto=<?php echo $shiptosearcharray[$key]['BILLTONUM']; ?>"> 
                            <?php echo $shiptosearcharray[$key]['BILLTONUM']; ?>
                        </a>
                    </td> 
                    <td><?php echo $shiptosearcharray[$key]['BILLTONAME']; ?></td> 
                    <td data-container="body" data-toggle="tooltip" data-title="Audit Ship-To" data-placement="top" > 
                        <a style="cursor: pointer" href="shiptocheck.php?shipto=<?php echo $shiptosearcharray[$key]['SHIPTONUM']; ?>"> 
                            <?php echo $shiptosearcharray[$key]['SHIPTONUM']; ?>
                        </a>
                    </td> 
                    <td><?php echo $shiptosearcharray[$key]['SHIPTONAME']; ?></td> 
                    <td><?php echo number_format($shiptosearcharray[$key]['TOTR12LINES'], 0, '.', ','); ?></td> 
                    <td><?php echo '$' . number_format($shiptosearcharray[$key]['TOTR12SALES'], 0); ?></td> 

                </tr>
                <?php
            }
        }

        ?>






    </tbody> 
</table>
