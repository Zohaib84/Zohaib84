<!doctype html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN | Login</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <img class="logo" src="images/news.jpg">
                        <h3 class="heading">Admin</h3>
                        <!-- Form Start -->
                        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <input type="submit" name="login" class="btn btn-primary" value="login" />
                        </form>
                        <!-- /Form  End -->

                        <?php
      if(isset($_POST['login'])) {
          // If the login form is submitted
          include 'config.php'; // Include the database connection configuration
          $username = mysqli_real_escape_string($conn, $_POST['username']); // Escape the username to prevent SQL injection
          $password = md5($_POST['password']); // Hash the password using MD5 (not recommended for secure applications)
          $sql = "SELECT user_id, username, role FROM your_table_name WHERE username = '{$username}' AND password = '{$password}'";
          // Formulate the SQL query to check if the provided username and password match a record in the database
          $result = mysqli_query($conn, $sql) or die("Connection Failed"); // Execute the query

          if(mysqli_num_rows($result) > 0) {
              // If a record is found with the provided username and password
              while($row = mysqli_fetch_assoc($result)) {
                  // Start a session
                  session_start();
                  // Store relevant user information in session variables
                  $_SESSION["username"] = $row["username"];
                  $_SESSION["user_id"] = $row["user_id"];
                  $_SESSION["user_role"] = $row["role"];
                  // Redirect the user to a dashboard or home page
                  header("location: {$hostname}/admin/users.php");
              }
          } else {
              // If no record is found with the provided username and password
              echo '<div class="alert alert-danger">Username or Password is incorrect</div>';
          }
      }
  ?>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
