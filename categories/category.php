<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php


if (isset($_GET['cat_id'])) {
    $id = filter_input(INPUT_GET, 'cat_id', FILTER_VALIDATE_INT);

  // sanitize
  if (!is_numeric($id)) {
    header("Location: http://localhost:31337/project/404.php");
    exit;
  }


    $posts = $conn->prepare("SELECT posts.id AS id, posts.title AS title, posts.subtitle AS subtitle, posts.user_name AS user_name, posts.created_at AS created_at, posts.category_id AS category_id, posts.status AS status FROM categories 
    JOIN posts ON categories.id = posts.category_id 
    WHERE posts.category_id = '$id' AND status = 1");
    $posts->execute();
    $rows = $posts->fetchAll(PDO::FETCH_OBJ);

// Check if post with the given id exists
if (!$rows) {
    header("Location: http://localhost:31337/project/404.php");
    exit;
}

} else {
    header("location: http://localhost:31337/project/404.php");
}






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
        <!-- Pager-->

    </div>
</div>




<?php require "../includes/footer.php"; ?>