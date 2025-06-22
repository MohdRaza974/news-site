<?php 
include "header.php";
include 'user-restriction.php';

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>Category Name</label>
                 <?php 
                    include "config.php";

                    if(isset($_POST['submit'])){
                        $cat_name = mysqli_real_escape_string($conn, $_POST['cat']);
                        $sql = "INSERT INTO category(category_name) VALUES ('{$cat_name}')";
                        $result = mysqli_query($conn, $sql);
                        if($result){
                            header("Location: {$hostname}/admin/category.php");
                        } else {
                            echo "Category Creation Failed!";
                        }
                    }
                 ?>
                        <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                </form>
                <!-- /Form End -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>