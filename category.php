<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <?php
                  $sql1 = "Select * from category where category_id = {$cat_id}";
                  $result = mysqli_query($conn, $sql1) or die('Query Failed:');
                  $row1 = mysqli_fetch_assoc($result);

                   ?>
                    <h2 class="page-heading"><?php echo $row1['category_name']; ?></h2>
                    <?php
                    include 'config.php';
                    if(isset($_GET['cid'])){
                        $cat_id = $_GET['cid'];
                    }
                    //calculate offset code
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
                            post.description, post.post_img,
                            category.category_name, user.username, post.category, post.post_date
                            FROM post
                            LEFT JOIN category ON post.category = category.category_id
                            LEFT JOIN user ON post.author = user.user_id
                            where post.category = {$cat_id}
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
                                                    <a href='category.php'><?php echo $row['category_name']; ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <a href='author.php'><?php echo $row['username']; ?></a>
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
                        echo "<li><a href='index.php?cid='.$cat_id.'&page=".($page - 1)."'>Prev</a></li>";
                    }

                    // Page links
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active_class = ($i == $page) ? "active" : "";
                        echo "<li class='$active_class'><a href='index.php?cid='.$cat_id.'&page=$i'>$i</a></li>";
                    }

                    // Next page link
                    if ($page < $total_pages) {
                        echo "<li><a href='index.php?cid='.$cat_id.'&page=".($page + 1)."'>Next</a></li>";
                    }

                    echo "</ul>";
                }
                ?>

            </div><!-- /col-md-8 -->

            <div class="col-md-4">
                <?php include 'sidebar.php'; ?>
            </div><!-- /col-md-4 -->

        </div><!-- /row -->
    </div><!-- /container -->
</div><!-- /main-content -->

<?php include 'footer.php'; ?>
