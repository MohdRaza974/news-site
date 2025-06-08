<?php
include 'config.php';

if (empty($_FILES['new-image']['name'])) {
    $file_name = $_POST['old-image'];
} else {
    $errors = array();

    $file_name = $_FILES['new-image']['name'];
    $file_size = $_FILES['new-image']['size'];
    $file_temp_name = $_FILES['new-image']['tmp_name'];
    $file_type = $_FILES['new-image']['type'];

    $temp = explode('.', $file_name);
    $file_extension = strtolower(end($temp));

    $allowed_extensions = array("jpeg", "jpg", "png");

    if (!in_array($file_extension, $allowed_extensions)) {
        $errors[] = "Wrong file extension. Please upload png or jpg file.";
    }

    if ($file_size > 2097152) {
        $errors[] = "The file size has exceeded the limit (2MB).";
    }

    if (empty($errors)) {
        $upload_dir = 'upload/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        if (!move_uploaded_file($file_temp_name, $upload_dir . $file_name)) {
            $errors[] = "Failed to move uploaded file.";
        }
    }

    if (!empty($errors)) {
        print_r($errors);
        die();
    }
}

$post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
$post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
$post_category = mysqli_real_escape_string($conn, $_POST['category']);
$post_description = mysqli_real_escape_string($conn, $_POST['postdesc']);

$sql = "UPDATE post 
        SET title = '{$post_title}', 
            description = '{$post_description}', 
            category = {$post_category}, 
            post_img = '{$file_name}' 
        WHERE post_id = {$post_id}";

$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: {$hostname}/admin/post.php");
} else {
    echo "<div class='alert alert-danger'>Update failed: " . mysqli_error($conn) . "</div>";
}
?>