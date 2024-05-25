<?php include "header.php"; ?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Update Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <?php
                include 'config.php'; // Include the database configuration

                $post_id = $_GET['id']; // Get the post ID from the URL parameter

                $sql = "SELECT post.post_id, post.title, post.description, post.post_img, category.category_name, post.category
                        FROM post
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id
                        WHERE post.post_id = {$post_id}";

                $result = mysqli_query($conn, $sql) or die('Query Failed: ' . mysqli_error($conn)); // Execute the query and handle errors

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <!-- Form for show edit-->
                        <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-group">
                                <input type="hidden" name="post_id" class="form-control" value="<?php echo $row['post_id']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputTitle">Title</label>
                                <input type="text" name="post_title" class="form-control" id="exampleInputTitle" value="<?php echo $row['title']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDescription">Description</label>
                                <textarea name="post_description" class="form-control" required rows="5"><?php echo $row['description']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCategory">Category</label>
                                <select class="form-control" name="category">
                                    <option value="" disabled>Select Category</option>
                                    <?php
                                    $sql1 = "SELECT * FROM category";
                                    $result1 = mysqli_query($conn, $sql1) or die('Query Failed!');

                                    if(mysqli_num_rows($result1) > 0){
                                        while($cat_row = mysqli_fetch_assoc($result1)){
                                            $selected = ($cat_row['category_id'] == $row['category']) ? "selected" : "";
                                            echo "<option value='{$cat_row['category_id']}' $selected>{$cat_row['category_name']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputImage">Post image</label>
                                <input type="file" name="new_image">
                                <img src="upload/<?php echo $row['post_img']; ?>" height="150px">
                                <input type="hidden" name="old-image" value="<?php echo $row['post_img']; ?>">
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update">
                        </form>
                        <!-- Form End -->
                        <?php
                    }
                } else {
                    echo "No records found for the provided post ID.";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
