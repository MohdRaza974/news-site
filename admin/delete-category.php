<?php
include 'config.php';
include 'user-restriction.php';

$cat_id = $_GET["id"];

$sql = "DELETE FROM category WHERE category_id = '{$cat_id}'";

if (mysqli_query($conn, $sql)) {
    header("Location: {$hostname}/admin/category.php");
}

mysqli_close($conn);
?>