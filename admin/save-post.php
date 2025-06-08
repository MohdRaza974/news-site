<?php
include 'config.php';

if(isset($_FILES['fileToUpload'])){
    $errors = array();

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_temp_name = $_FILES['fileToUpload']['temp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_extension = strtolower(end(explode('.',$file_name)));
    $extension = array("jpeg", "jpg", "png");

    if(in_array($file_extension ,$extension)  === false){
        $errors[] = "Wrong file extension. Please upload png or jpg file.";
    }

    if(filesize($file_extension) > 20,97,152){
        $errors[] = "The file size has exceeed the limit. It should be maximum 2mb";
    }

    if(empty($errors[]) === true){
        move_uploaded_file($file_temp_name,'upload'. $file_name);
    } else {
        print_r($errors);
        die();
    }
}

$post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
$post_desc = mysqli_real_escape_string($conn, $_POST['postdesc']);
$post_category = mysqli_real_escape_string($conn, $_POST['category']);
$post_date = date('d M, Y');
$post_author = $_SESSION['user_id'];
?>