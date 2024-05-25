<?php
include 'config.php';

// Image Upload Code
if(isset($_FILES['fileToUpload'])) {
    $errors = array(); // Corrected variable name from $error to $errors
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size  = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_ext = strtolower(end(explode('.', $file_name)));
    $extensions = array('jpeg', 'png', 'jpg');
    if(!in_array($file_ext, $extensions)) { // Corrected the condition to check if extension is not in the array
        $errors[] = 'This extension file is not allowed, Please upload jpeg, jpg and png file';
    }
    // file size is not more than 2MB
    if($file_size > 2097152) {
        $errors[] = 'File size must be 2mb or less';
    }
    if(empty($errors)) { // Corrected variable name from $error to $errors
        move_uploaded_file($file_tmp, "upload/".$file_name); // Corrected folder name from "uploads" to "upload"
    } else {
        print_r($errors); // Corrected variable name from $error to $errors
        die();
    }
}

// Other form data

$title = mysqli_real_escape_string($conn, $_POST['post_title']);
$description = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$date = date("d, M, Y"); // Corrected function name from dat to date
$author = $_SESSION['user_id'];

// Insert query for post table
$sql = "INSERT INTO post(title, description, category, post_date, author, post_img)
        VALUES('{$title}', '{$description}', '{$category}', '{$date}', '{$author}', '{$file_name}')"; // Corrected variable name from discription to description
$sql .= "; UPDATE category SET post = post + 1 WHERE category_id = {$category}";

// When two commands run in one variable, use multi-query

if(mysqli_multi_query($conn, $sql)) {
    header("location: {$hostname}/admin/post.php");
} else {
    echo "<div class='alert alert-danger'>Query Failed.</div>"; // Corrected class name from alert danger to alert-danger
}
?>
