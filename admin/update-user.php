<?php include "header.php";

$user_id = $_GET['id'];

include "config.php";
$sql = "SELECT * FROM user WHERE user_id = {$user_id}";
$result = mysqli_query($conn, $sql) or die('Query Failed!');
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div id="admin-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="admin-heading">Modify User Details</h1>
                    </div>
                    <div class="col-md-offset-4 col-md-4">
                        <!-- Form Start -->
                        <form action="update.php" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="user_id" class="form-control" value="<?php echo $row['user_id'] ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name'] ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name'] ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $row['username'] ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Role</label>
                                <select class="form-control" name="role" value="<?php echo $row['role']; ?>">
                                    <?php 
                                    if($row['role'] == 0){
                                        echo "<option selected value='0'>Normal User</option>";
                                        echo "<option value='1'>Admin User</option>";

                                    } else {
                                        echo "<option value='0'>Normal User</option>";
                                        echo "<option selected value='1'>Admin User</option>";

                                    }
                                    ?>
                                    
                                    
                                </select>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                        </form>
                        <!-- /Form -->
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}
?>
<?php include "footer.php"; ?>