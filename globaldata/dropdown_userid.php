<?php
include_once 'connection/connection_details.php';

$var_userid = $_SESSION['MYUSER'];
$mygroupdata = $_GET['group'];

//find group
//$mygroup = $conn1->prepare("SELECT customeraudit_users_GROUP
//                            FROM custaudit.customeraudit_users
//                            WHERE customeraudit_users_ID = '$var_userid'");
//$mygroup->execute();
//$mygrouparray = $mygroup->fetchAll(pdo::FETCH_ASSOC);
//$mygroupdata = $mygrouparray[0]['customeraudit_users_GROUP'];


$users = $conn1->prepare("SELECT * FROM custaudit.customeraudit_users WHERE customeraudit_users_GROUP = '$mygroupdata';");
$users->execute();
$usersarray = $users->fetchAll(pdo::FETCH_ASSOC);
?>


<select name = 'assignedtsm_<?php echo strtolower($mygroupdata)?>' class = "form-control" id = 'assignedtsm_<?php echo strtolower($mygroupdata)?>' tabindex = "4">
    <option value="0">Select TSM...</option>
    <?php foreach($usersarray as $user): ?>
        <option value="<?= $user['customeraudit_users_ID']; ?>"><?php echo $user['customeraudit_users_ID'] . ' | ' . $user['customeraudit_users_FIRSTNAME'] . ' ' . $user['customeraudit_users_LASTNAME']; ?></option>
    <?php endforeach; ?>
</select>
