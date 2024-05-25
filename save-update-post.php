<?php
include 'config.php';

// Initialize $file_name variable
$file_name = '';

// Check if new image file is uploaded
if(!empty($_FILES['new_image']['name'])) {
    $errors = array(); // Corrected variable name from $error to $errors
    $file_name = $_FILES['new_image']['name'];
    $file_size  = $_FILES['new_image']['size'];
    $file_tmp = $_FILES['new_image']['tmp_name'];
    $file_type = $_FILES['new_image']['type'];
    $file_ext = strtolower(end(explode('.', $file_name)));
    $extensions = array('jpeg', 'png', 'jpg');

    // Check if file extension is allowed
    if(!in_array($file_ext, $extensions)) {
        $errors[] = 'This extension file is not allowed, Please upload jpeg, jpg and png file';
    }
    // Check if file size is within limits
    if($file_size > 2097152) {
        $errors[] = 'File size must be 2mb or less';
    }

    // If no errors, move uploaded file to destination folder
    if(empty($errors)) {
        move_uploaded_file($file_tmp, "upload/".$file_name); // Corrected folder name from "uploads" to "upload"
    } else {
        print_r($errors); // Print errors and terminate script
        die();
    }
}

// Prepare SQL query to update post
$sql = "UPDATE post
        SET title = '{$_POST["post_title"]}',
            category = '{$_POST["category"]}',
            post_img = '{$file_name}'
        WHERE post_id = {$_POST["post_id"]}";

$result = mysqli_query($conn, $sql);
if($result){
    header("location: {$hostname}/admin/post.php");
} else {
    echo "Query Failed: " . mysqli_error($conn);
}
?>
