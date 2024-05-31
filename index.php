<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    include 'config.php';
                    $limit = 3;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }
                    else {
                        $page = 1;
                    }
                    $offset = ($page - 1) * $limit;

                    // SQL query to fetch posts with pagination
                    $sql = "SELECT post.post_id, post.title,
                            post.description, post.post_img, post.author,
                            category.category_name, user.username, post.category, post.post_date
                            FROM post
                            LEFT JOIN category ON post.category = category.category_id
                            LEFT JOIN user ON post.author = user.user_id
                            ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";

                    $result = mysqli_query($conn, $sql) or die('Query Failed: ' . mysqli_error($conn));

                    if (mysqli_num_rows($result) > 0) {
                        $serial = $offset + 1; // Counter for serial number
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>"><img src="admin/upload/<?php echo $row['post_img']; ?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href='single.php?id=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?cid=<?php echo $row['category']; ?>'><?php echo $row['category_name']; ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?aid=<?php echo $row['author']; ?>'><?php echo $row['username']; ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo date('d M, Y', strtotime($row['post_date'])); ?>
                                        </span>
                                    </div>
                                    <p class="description">
                                        <?php echo substr($row['description'], 0, 125) . "..."; ?>

                                    </p>
                                    <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    else {
                        echo "<h2>No Record Found</h2>";
                    }
                    ?>

                </div><!-- /post-container -->

                <?php
                // Display pagination links
                $total_records = 0; // You need to set this to the actual total number of records
                if ($total_records > $limit) {
                    $total_pages = ceil($total_records / $limit);

                    echo "<ul class='pagination admin-pagination'>";

                    // Previous page link
                    if ($page > 1) {
                        echo "<li><a href='index.php?page=".($page - 1)."'>Prev</a></li>";
                    }

                    // Page links
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active_class = ($i == $page) ? "active" : "";
                        echo "<li class='$active_class'><a href='index.php?page=$i'>$i</a></li>";
                    }

                    // Next page link
                    if ($page < $total_pages) {
                        echo "<li><a href='index.php?page=".($page + 1)."'>Next</a></li>";
                    }

                    echo "</ul>";
                }
                ?>

            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
