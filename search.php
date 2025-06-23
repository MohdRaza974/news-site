<?php include 'header.php';
include "config.php";
$search_term = $_GET['search'];
?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <h2 class="page-heading">Search : <?php echo $search_term ?></h2>
                    <?php
                    $limit = 3;
                    $page = isset($_GET['page']) ? mysqli_real_escape_string($conn, $_GET['page']) : 1;
                    $offset = ($page - 1) * $limit;
                    if (isset($_GET['search'])) {
                        $search_id = mysqli_real_escape_string($conn, $_GET['search']);
                    }
                    // After you define $search_id and before the main post query
                    // $search_query = "SELECT * FROM post WHERE post.title LIKE '%{$search_id}%'";
                    // $search_result = mysqli_query($conn, $search_query);
                    // $search_row = mysqli_fetch_assoc($search_result);

                    $sql = "SELECT post.post_id, post.title, post.post_img, post.post_date, post.author, post.description, post.category, category.category_name, user.username FROM post 
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id
                        WHERE post.title LIKE '%{$search_id}%' OR post.description LIKE '%{$search_id}%'
                        ORDER BY post.post_id DESC
                        LIMIT {$offset}, {$limit}";

                    $result = mysqli_query($conn, $sql) or die('Query Failed!');
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href="single.php?id=<?php echo $row['post_id'] ?>"><img src="admin/upload/<?php echo $row['post_img'] ?>" alt="" /></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="inner-content clearfix">
                                            <h3><a href='single.php?id=<?php echo $row['post_id'] ?>'><?php echo $row['title'] ?></a>
                                            </h3>
                                            <div class="post-information">
                                                <span>
                                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                                    <a href='category.php?cid=<?php echo $row['category'] ?>'><?php echo $row['category_name'] ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <a href='author.php?search=<?php echo $row['author'] ?>'><?php echo $row['username'] ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo $row['post_date'] ?>
                                                </span>
                                            </div>
                                            <p class="description">
                                                <?php echo substr($row['description'], 0, 150) . "..." ?>
                                            </p>
                                            <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id'] ?>'>Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } else {
                        echo "<h1>No Records Found</h1>";
                    } ?>

                    <?php
                    $sql1 = "SELECT COUNT(*) AS total_records FROM post WHERE post.title LIKE '%{$search_id}%' OR post.description LIKE '%{$search_id}%'
";
                    $result1 = mysqli_query($conn, $sql1) or die("Connection Failed");

                    if (mysqli_num_rows($result1) > 0) {
                        $row = mysqli_fetch_assoc($result1);
                        $total_records = $row['total_records'];
                        $total_pages = ceil($total_records / $limit);

                        echo "<ul class='pagination admin-pagination'>";
                        if ($page > 1) {
                            echo '<li><a href="search.php?search=' . $search_id . '&page=' . ($page - 1) . '">Previous</a></li>';
                        }
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active = ($i == $page) ? "active" : "";
                            echo '<li class="' . $active . '"><a href="search.php?search=' . $search_id . '&page=' . $i . '">' . $i . '</a></li>';
                        }
                        if ($total_pages > $page) {
                            echo '<li><a href="search.php?search=' . $search_id . '&page=' . ($page + 1) . '">Next</a></li>';
                        }
                        echo "</ul>";
                    }

                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>