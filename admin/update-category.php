<?php
include "header.php";
include 'user-restriction.php';
include "config.php";

$user_id = isset(($_GET['id'])) ? ($_GET['id']) : 0;

// Handle form submission
if (isset($_POST['submit'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['cat_id']);
    $category_name = mysqli_real_escape_string($conn, $_POST['cat_name']);

    $sql1 = "UPDATE category SET category_name = '{$category_name}' WHERE category_id = {$category_id}";
    $result1 = mysqli_query($conn, $sql1);

    if ($result1) {
        header("Location: category.php"); // redirect after success
        exit;
    } else {
        echo "<div class='alert alert-danger'>Update Failed.</div>";
    }
}

// Fetch category data to display in form
$sql = "SELECT * FROM category WHERE category_id = {$user_id}";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Update Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $user_id; ?>" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="cat_id" class="form-control" value="<?php echo $row['category_id']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name']; ?>" required>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                </form>
            </div>
        </div>
    </div>
</div>
<?php
}
include "footer.php";
?>
