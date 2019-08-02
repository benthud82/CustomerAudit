<?php

include 'sessioninclude.php';
include_once 'connection/connection_details.php';

$var_userid = $_SESSION['MYUSER'];
$var_custid = ($_POST['upload_custid']);
$var_custtype = trim(strtoupper($_POST['upload_custtype']));

//$filetest = ($_POST['formData']);


$today = date('Y-m-d');
$target_dir = "uploads/";
$target_basename = basename($_FILES["file"]["name"]);
$target_file = $target_dir . $target_basename;
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

$columns = 'upload_custid, upload_custtype, upload_filename, upload_filetype, upload_date, upload_tsm';

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["file"]["size"] > 10000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
//if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
//&& $imageFileType != "gif" ) {
//    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//    $uploadOk = 0;
//}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$sql = "INSERT INTO custaudit.custaudit_uploads ($columns) VALUES ('$var_custid', '$var_custtype', '$target_basename', '$imageFileType', '$today', '$var_userid');";
$query = $conn1->prepare($sql);
$query->execute();
