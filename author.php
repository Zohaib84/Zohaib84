<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    include 'config.php';

                    $auth_id = isset($_GET['aid']) ? $_GET['aid'] : null;
$auth_id = mysqli_real_escape_string($conn, $auth_id); // Sanitize input

$sql_author = "SELECT * FROM post JOIN user
             ON post.author = user.user_id
             WHERE post.author = '{$auth_id}'";

$result_author = mysqli_query($conn, $sql_author);

if (!$result_author) {
  // Query failed, handle the error
  die("Error executing query: " . mysqli_error($conn));
}

$row_author = mysqli_fetch_assoc($result_author);


                    if ($row_author) {
                        echo "<h2 class='page-heading'>Posts by " . $row_author['username'] . "</h2>";

                        // Calculate offset
                        $limit = 3;
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;

                        // Fetch posts by the author with pagination
                        $sql_posts = "SELECT post.post_id, post.title,
                                post.description, post.post_img,
                                category.category_name, user.username, post.category, post.post_date
                                FROM post
                                LEFT JOIN category ON post.category = category.category_id
                                LEFT JOIN user ON post.author = user.user_id
                                WHERE post.author = {$auth_id}
                                ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";

                        $result_posts = mysqli_query($conn, $sql_posts);

                        if (mysqli_num_rows($result_posts) > 0) {
                            while ($row = mysqli_fetch_assoc($result_posts)) {
                                ?>
                                <div class="post-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a class="post-img" href="single.php?aid=<?php echo $row['post_id']; ?>"><img src="admin/upload/<?php echo $row['post_img']; ?>" alt=""/></a>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="inner-content clearfix">
                                                <h3><a href='single.php?aid=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a></h3>
                                                <div class="post-information">
                                                    <span>
                                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                                        <a href='category.php'><?php echo $row['category_name']; ?></a>
                                                    </span>
                                                    <span>
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                        <?php echo $row['username']; ?>
                                                    </span>
                                                    <span>
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        <?php echo date('d M, Y', strtotime($row['post_date'])); ?>
                                                    </span>
                                                </div>
                                                <p class="description">
                                                    <?php echo substr($row['description'], 0, 125) . "..."; ?>
                                                </p>
                                                <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>Read more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<h2>No Records Found</h2>";
                        }

                        // Display pagination links
                        // Assuming $total_records contains the total number of posts by the author
                        if ($total_records > $limit) {
                            $total_pages = ceil($total_records / $limit);

                            echo "<ul class='pagination admin-pagination'>";

                            // Previous page link
                            if ($page > 1) {
                                echo "<li><a href='author.php?aid={$auth_id}&page=".($page - 1)."'>Prev</a></li>";
                            }

                            // Page links
                            for ($i = 1; $i <= $total_pages; $i++) {
                                $active_class = ($i == $page) ? "active" : "";
                                echo "<li class='$active_class'><a href='author.php?aid={$auth_id}&page=$i'>$i</a></li>";
                            }

                            // Next page link
                            if ($page < $total_pages) {
                                echo "<li><a href='author.php?aid={$auth_id}&page=".($page + 1)."'>Next</a></li>";
                            }

                            echo "</ul>";
                        }
                    } else {
                        echo "<h2>No Author Found</h2>";
                    }
                    ?>

                </div><!-- /post-container -->
            </div><!-- /col-md-8 -->
            <?php include 'sidebar.php'; ?>
        </div><!-- /row -->
    </div><!-- /container -->
</div><!-- /main-content -->
<?php include 'footer.php'; ?>
