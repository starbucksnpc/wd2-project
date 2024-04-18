<?php require "../config/config.php"; ?>


<?php
// 로그인이 되어 있는지 확인하세요
if (!isset($_SESSION['adminname'])) {
    // header("Location: http://localhost:31337/project/admin-panel/admins/login-admins.php");
    // exit; 
    echo "<meta http-equiv='refresh' content='0;url=http://localhost:31337/project/admin-panel/admins/login-admins.php'>";

}

// title ... list
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'title';


$query = "SELECT * FROM pages ORDER BY $sort_by";
$result = $conn->query($query);


?>

<div class="row gx-4 gx-lg-5 justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-7">
   

        <?php foreach ($rows as $row) : ?>

            <!-- Post preview-->
            <div class="post-preview">
                <a href="http://localhost:31337/project/posts/post.php?post_id=<?php echo $row->id; ?>">
                    <h2 class="post-title"><?php echo $row->title; ?></h2>
                    <h3 class="post-subtitle"><?php echo $row->subtitle; ?></h3>
                </a>
            
                <!-- html image tag -->
                <?php if (!empty($row->img)) : ?>
                    <img src="http://localhost:31337/project/images/<?php echo htmlspecialchars($row->img); ?>" alt="<?php echo htmlspecialchars($row->title); ?>" style="width:100%;max-width:600px;">
                <?php endif; ?>

                <p class="post-meta">
                    Posted by
                    <a href="#!"><?php echo $row->user_name; ?></a>
                    <?php echo date('M', strtotime($row->created_at)) . ' ' . date('d', strtotime($row->created_at)) . ', ' . date('Y', strtotime($row->created_at)); ?>
                </p>
            </div>
            <!-- Divider-->
            <hr class="my-4" />
        <?php endforeach; ?>
        <?php else :?>
            <div class='alert alert-danger bg-danger text-white text-center'>
            No results found.</div>

        <?php endif; ?>
        <!-- Pager-->

    </div>
</div>


<?php require "includes/footer.php"; ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page List</title>
    <!-- 필요한 스타일시트를 여기에 포함하세요 -->
</head>
<body>
    <h1>Page List</h1>
    <p>Sort by:
        <a href="?sort_by=title">Title</a> |
        <a href="?sort_by=created_at">Created At</a> |
        <a href="?sort_by=updated_at">Updated At</a>
    </p>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><?php echo $row['updated_at']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <!-- 필요한 스크립트를 여기에 포함하세요 -->
</body>
</html>