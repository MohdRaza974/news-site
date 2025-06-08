<?php
include 'config.php';

if (isset($_FILES['fileToUpload'])) {
    $errors = array();

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_temp_name = $_FILES['fileToUpload']['tmp_name']; // fixed key
    $file_type = $_FILES['fileToUpload']['type'];

    $temp = explode('.', $file_name); // fix for PHP 8+
    $file_extension = strtolower(end($temp)); // now safe

    $extension = array("jpeg", "jpg", "png");

    if (in_array($file_extension, $extension) === false) {
        $errors[] = "Wrong file extension. Please upload png or jpg file.";
    }

    if ($file_size > 2097152) { // also corrected this line to check file size, not extension
        $errors[] = "The file size has exceed the limit. It should be maximum 2mb";
    }


    if ($_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
        move_uploaded_file($file_temp_name, 'upload/' . $file_name);
    } else {
        echo "Upload failed with error code: " . $_FILES['fileToUpload']['error'];
    }

}
session_start();
$post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
$post_desc = mysqli_real_escape_string($conn, $_POST['postdesc']);
$post_category = mysqli_real_escape_string($conn, $_POST['category']);
$post_date = date('d M, Y');
$post_author = $_SESSION['user_id'];

$sql = "INSERT INTO post(title, description, category, post_date, author, post_img) VALUES ('{$post_title}', '{$post_desc}', {$post_category}, '{$post_date}', {$post_author}, '{$file_name}');";
$sql .= "UPDATE category SET post = post + 1 WHERE category_id = '{$post_category}'";

if (mysqli_multi_query($conn, $sql)) {
    header("Location: {$hostname}/admin/post.php");
} else {
    echo "<div class='alert alert-danger'>Query failed</div>";
}
?>