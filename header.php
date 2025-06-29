<?php
include "config.php";
$path = $_SERVER['PHP_SELF'];
$filename = basename($path);

switch ($filename) {
    case 'single.php':
        if (isset($_GET['id'])) {
            $sql_title = "SELECT * FROM post WHERE post_id = {$_GET['id']}";
            $result_title = mysqli_query($conn, $sql_title) or die("Query Failed: Post");
            $row_title = mysqli_fetch_assoc($result_title);
            $page_title = $row_title['title'];
        } else {
            $page_title = "No record found";
        }
        break;
    case 'category.php':
        if (isset($_GET['cid'])) {
            $sql_category = "SELECT category.category_name FROM post 
            JOIN category ON post.category = category.category_id
             WHERE category_id = {$_GET['cid']}";
            $result_category = mysqli_query($conn, $sql_category) or die("Query Failed: Category");
            $row_category = mysqli_fetch_assoc($result_category);
            $page_category = $row_category['category_name'] . " News";
        } else {
            $page_category = "No record found";
        }
        break;
    case 'author.php':
        if(isset($_GET['aid'])){
            $sql_author = "SELECT user.first_name, user.last_name FROM post JOIN user ON post.author = user.user_id WHERE user_id = {$_GET['aid']}";
            $result_author = mysqli_query($conn, $sql_author) or die("Query Failed: Author");
            $row_author = mysqli_fetch_assoc($result_author);
            $page_author = "News By " . $row_author['first_name']. " " .$row_author['last_name'];
        } else {
            $page_author = "No record found";
        }
        break;
    case 'search.php':
        if(isset($_GET['search'])) {
            $search_term1 = $_GET['search']; 
        } else {
            $searchterm1 = "No search records found";
        }
        break;

    default:
        $page_home = "News Site";
        break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>
        <?php 
        if(isset($page_title)) {
            echo ucfirst($page_title);
        } elseif (isset($page_category)){
            echo ucfirst($page_category);
        } elseif (isset($page_author)){
            echo ucfirst($page_author);
        } elseif (isset($search_term1)){
            echo $search_term1;
        } else {
            echo $page_home;
        }
        ?>
</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <a href="index.php" id="logo"><img src="images/news.jpg"></a>
                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class='menu'>

                        <?php
                        include "config.php";
                        $sql = "SELECT * FROM category WHERE post > 0";
                        $result = mysqli_query($conn, $sql) or die("Query Failed : Category");
                        if (mysqli_num_rows($result) > 0) {
                            $active = "";
                            echo "<li><a href='{$hostname}'>Home</a></li>";

                            while ($row = mysqli_fetch_assoc($result)) {
                                if (isset($_GET['cid'])) {
                                    $cat_id = $_GET['cid'];
                                
                                    if ($row['category_id'] == $cat_id) {
                                        $active = "active";
                                    } else {
                                        $active = "";
                                    }
                                }

                                echo "<li><a class='{$active}' href='category.php?cid={$row['category_id']}'>{$row['category_name']}</a></li>";
                            } ?>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->