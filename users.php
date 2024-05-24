<?php include "header.php"; ?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">Add User</a>
            </div>
            <div class="col-md-12">
                <?php
                include 'config.php';

                $limit = 3; // Number of records per page

                $sql = "SELECT COUNT(*) AS total FROM user"; // Count total records
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $total_records = $row['total'];

                // Calculate the offset based on the current page number
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                $sql = "SELECT * FROM user ORDER BY user_id DESC LIMIT $limit OFFSET $offset";
                $result = mysqli_query($conn, $sql) or die('Query Failed: ' . mysqli_error($conn));

                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php
                            $serial = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td class='id'><?php echo $serial++; ?></td>
                                    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo ($row['role'] == 1) ? "Admin" : "Student"; ?></td>
                                    <td class='edit'><a href='update-user.php?id=<?php echo $row["user_id"]; ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-user.php?id=<?php echo $row["user_id"]; ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php
                }

                // Display pagination links
                if ($total_records > $limit) {
      $total_pages = ceil($total_records / $limit);

      echo "<ul class='pagination admin-pagination'>";

      // Previous page link
      if ($page > 1) {
          echo "<li><a href='users.php?page=".($page - 1)."'>Prev</a></li>";
      }

      // Page links
      for ($i = 1; $i <= $total_pages; $i++) {
          $active_class = ($i == $page) ? "active" : "";
          echo "<li class='$active_class'><a href='users.php?page=$i'>$i</a></li>";
      }

      // Next page link
      if ($page < $total_pages) {
          echo "<li><a href='users.php?page=".($page + 1)."'>Next</a></li>";
      }

      echo "</ul>";
  }
?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
