<?php
include 'config.php';

$upload_dir = 'upload/';
$errors = array();

if (empty($_FILES['new-image']['name'])) {
    $image_save = $_POST['old-image'];
} else {
    $file_name = $_FILES['new-image']['name'];
    $file_size = $_FILES['new-image']['size'];
    $file_temp_name = $_FILES['new-image']['tmp_name'];

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
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $unique_file_name = time() . '-' . basename($file_name);
        $upload_path = $upload_dir . $unique_file_name;

        if (move_uploaded_file($file_temp_name, $upload_path)) {
            $image_save = $unique_file_name;

            if (!empty($_POST['old-image']) && file_exists($upload_dir . $_POST['old-image'])) {
                unlink($upload_dir . $_POST['old-image']);
            }

        } else {
            $errors[] = "Failed to move uploaded file.";
        }
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>{$error}</div>";
        }
        exit;
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
            post_img = '{$image_save}' 
        WHERE post_id = {$post_id};";

if ($_POST['old_category'] != $_POST['category']) {
    $sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$_POST['old_category']};";
    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$_POST['category']};";
}

if (mysqli_multi_query($conn, $sql)) {
    header("Location: {$hostname}/admin/post.php");
} else {
    echo "<div class='alert alert-danger'>Update failed: " . mysqli_error($conn) . "</div>";
}
?>
