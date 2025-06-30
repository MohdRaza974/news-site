<?php
include 'config.php';

if (isset($_FILES['fileToUpload'])) {
    $errors = array();  

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_temp_name = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];

    $temp = explode('.', $file_name);
    $file_extension = strtolower(end($temp));

    $allowed_extensions = array("jpeg", "jpg", "png");

    if (!in_array($file_extension, $allowed_extensions)) {
        $errors[] = "Wrong file extension. Please upload png or jpg file.";
    }

    if ($file_size > 2097152) {
        $errors[] = "The file size has exceeded the limit. It should be maximum 2MB.";
    }

    if (empty($errors)) {
        if ($_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
            $image_name = time() . "-" . basename($file_name);
            $image_upload_path = "upload/" . $image_name;

            if (move_uploaded_file($file_temp_name, $image_upload_path)) {
                $image_save = $image_name;
            } else {
                $errors[] = "Failed to upload the file.";
            }
        } else {
            $errors[] = "Upload failed with error code: " . $_FILES['fileToUpload']['error'];
        }
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>{$error}</div>";
        }
        exit;
    }
}

session_start();
$post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
$post_desc = mysqli_real_escape_string($conn, $_POST['postdesc']);
$post_category = mysqli_real_escape_string($conn, $_POST['category']);
$post_date = date('d M, Y');
$post_author = $_SESSION['user_id'];

$sql = "INSERT INTO post(title, description, category, post_date, author, post_img) 
        VALUES ('{$post_title}', '{$post_desc}', {$post_category}, '{$post_date}', {$post_author}, '{$image_save}');";
$sql .= "UPDATE category SET post = post + 1 WHERE category_id = '{$post_category}'";

if (mysqli_multi_query($conn, $sql)) {
    header("Location: {$hostname}/admin/post.php");
} else {
    echo "<div class='alert alert-danger'>Query failed</div>";
}
