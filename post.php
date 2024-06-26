<?php include "header.php"; ?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Posts</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-post.php">Add Post</a>
            </div>
            <div class="col-md-12">
                <?php
                include 'config.php'; // Include the database configuration

                $limit = 3; // Number of records per page

                $sql = "SELECT COUNT(*) AS total FROM post"; // Count total records
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $total_records = $row['total'];

                // Calculate the offset based on the current page number
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                // Create left join post table with category and user table
                $sql = "SELECT * FROM post
          LEFT JOIN category ON post.category = category.category_id
          LEFT JOIN user ON post.author = user.user_id
          ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";

                $result = mysqli_query($conn, $sql) or die('Query Failed: ' . mysqli_error($conn));

                if (mysqli_num_rows($result) > 0) {
                ?>
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Author</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php
                        $serial = $offset + 1; // Counter for serial number
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td class="id"><?php echo $serial++; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['post_date']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td class="edit"><a href="update-post.php?id=<?php echo $row['post_id']; ?>"><i class="fa fa-edit"></i></a></td>
                            <td class="delete"><a href="delete-post.php?id=<?php echo $row['post_id']; ?>"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else {
                    echo "<p>No posts found</p>";
                }

                // Display pagination links
                if ($total_records > $limit) {
                    $total_pages = ceil($total_records / $limit);

                    echo "<ul class='pagination admin-pagination'>";

                    // Previous page link
                    if ($page > 1) {
                        echo "<li><a href='post.php?page=".($page - 1)."'>Prev</a></li>";
                    }

                    // Page links
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active_class = ($i == $page) ? "active" : "";
                        echo "<li class='$active_class'><a href='post.php?page=$i'>$i</a></li>";
                    }

                    // Next page link
                    if ($page < $total_pages) {
                        echo "<li><a href='post.php?page=".($page + 1)."'>Next</a></li>";
                    }

                    echo "</ul>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
