<?php include "header.php"; ?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Posts</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-post.php">add post</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>Sr.No.</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Author</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php

                        include "config.php";
                        $limit = 3;
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;
                        $sql = "SELECT * FROM post ORDER BY post_id LIMIT {$offset}, {$limit}";
                        $result = mysqli_query($conn, $sql) or die('Query Failed!');
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td class='<?php echo $row['post_id'] ?>'><?php echo $row['post_id'] ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['category'] ?></td>
                                    <td><?php echo $row['post_date'] ?></td>
                                    <td><?php echo $row['author'] ?></td>
                                    <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id'] ?>'><i
                                                class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id'] ?>'><i
                                                class='fa fa-trash-o'></i></a></td>
                                </tr>
                                <!-- <tr>
                              <td class='id'>1</td>
                              <td>Lorem ipsum dolor sit amet</td>
                              <td>Html</td>
                              <td>01 Nov, 2019</td>
                              <td>Admin</td>
                              <td class='edit'><a href='update-post.php'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php'><i class='fa fa-trash-o'></i></a></td>
                          </tr> -->
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                $sql1 = "SELECT * FROM post";
                $result1 = mysqli_query($conn, $sql1) or die("Connection Failed");

                if (mysqli_num_rows($result1) > 0) {
                    $total_records = mysqli_num_rows($result1);



                    $total_pages = ceil($total_records / $limit);

                    echo "<ul class='pagination admin-pagination'>";
                    if ($page > 1) {
                        echo '<li><a href="users.php?page=' . ($page - 1) . '">Previous</a></li>';

                    }
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                        echo '<li class="' . $active . '"><a href="users.php?page=' . $i . '">' . $i . '</a></li>';

                    }
                    if ($total_pages > $page) {
                        echo '<li><a href="users.php?page=' . ($page + 1) . '">Next</a></li>';

                    }
                    echo "</ul>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>