<?php
include_once '../connection/connection_details.php';
$var_userid = $_POST['userid'];


$recentconn = $conn1->prepare("SELECT * FROM custaudit.customerauditlogin ORDER BY customeraudit_datetime DESC LIMIT 5;");
$recentconn->execute();
$recentconnarray = $recentconn->fetchAll(pdo::FETCH_ASSOC);


foreach ($recentconnarray as $key => $value) {
    ?>
    <li class="list-group-item alternate"> 
        <div class="media"> 
            <div class="media-body"> 
                <div class="h5"><?php echo $recentconnarray[$key]['customeraudit_TSM'] . ' | <span class=" small text-muted">' . $recentconnarray[$key]['customeraudit_datetime'] ?>  </span></div>
            </div>
        </div>
    </li> 
    <?php
} 

