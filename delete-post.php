<?php
include 'config.php';

$post_id = $_GET['id'];
$cat_id = $_GET['catid'];

// Delete post query
$delete_post_sql = "DELETE FROM post WHERE post_id = {$post_id}";

// Update category query
$update_category_sql = "UPDATE category SET post = post - 1 WHERE category_id = {$cat_id}";

// Execute the delete post query
if(mysqli_query($conn, $delete_post_sql) && mysqli_query($conn, $update_category_sql)) {
    header("location: {$hostname}/admin/post.php");
} else {
    echo "Query Failed: " . mysqli_error($conn);
}
?>
