<?php
include 'config.php';
include 'user-restriction.php';

$user_id = $_GET['id'];

$sql = "DELETE FROM user WHERE user_id = {$user_id}";
$result = mysqli_query($conn, $sql) or die('Query Failed!');

header("Location: {$hostname}/admin/users.php");
mysqli_close($conn);
?>