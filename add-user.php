<?php
include "header.php";

if(isset($_POST['save'])){
    include 'config.php';  // Database connection open

    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $user = mysqli_real_escape_string($conn,$_POST['user']);
    $password = mysqli_real_escape_string($conn,password_hash($_POST['password'], PASSWORD_DEFAULT)); // Using password_hash() for better security
    $role = mysqli_real_escape_string($conn,$_POST['role']);

    // Pass query if user already exist
    $sql = "SELECT username FROM user WHERE username = '{$user}'";
    $result = mysqli_query($conn, $sql) or die('Query Failed!');

    // Run if else condition for user
    if(mysqli_num_rows($result) > 0){
        echo "<p style='color:red; text-align:center; margin: 10px 0;'>User name already exists</p>";
    } else {
        $sql1 = "INSERT INTO user(first_name, last_name, username, password, role)
                VALUES('{$fname}', '{$lname}','{$user}','{$password}', '{$role}' )";
        // If condition to run the Query
        if(mysqli_query($conn, $sql1)){
            header("location: {$hostname}/admin/add-user.php");
            exit(); // Ensure script stops execution after redirection
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add User</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                    </div>
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="user" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label>User Role</label>
                        <select class="form-control" name="role" required>
                            <option value="0">Normal User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    <input type="submit" name="save" class="btn btn-primary" value="Save" />
                </form>
                <!-- Form End-->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
