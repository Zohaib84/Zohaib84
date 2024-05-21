<?php
include 'config.php';

$user_id = $_GET['id'];
$sql = "DELETE FROM user WHERE user_id = {$user_id}";

if(mysqli_query($conn, $sql)){
    header("location: {$hostname}/admin/users.php");
} else {
    echo "<p style='color:red; margin: 10px 0;'>Can't delete the user record</p>";
}

mysqli_close($conn);
?>
