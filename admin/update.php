<?php
if (isset($_POST['submit'])) {
    include "config.php";

    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $user_fname = mysqli_real_escape_string($conn, $_POST['f_name']);
    $user_lname = mysqli_real_escape_string($conn, $_POST['l_name']);
    $user_username = mysqli_real_escape_string($conn, $_POST['username']);
    $user_role = mysqli_real_escape_string($conn, $_POST['role']);
    // $user_password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $sql = "UPDATE user SET first_name = '{$user_fname}', last_name = '{$user_lname}', username = '{$user_username}', role = '{$user_role}'
    WHERE user_id = {$user_id}";
    $result = mysqli_query($conn, $sql) or die('Query Failed!');

    header('Location: http://localhost/news-site/admin/users.php');
    mysqli_close($conn);
}
?>