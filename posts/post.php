<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>


<?php

if (isset($_GET['post_id'])) {
    $id = filter_input(INPUT_GET, 'post_id', FILTER_VALIDATE_INT);

  // sanitize
  if (!is_numeric($id)) {
    header("Location: http://localhost:31337/project/404.php");
    exit;
  }


    $select = $conn->prepare("SELECT * FROM posts WHERE id = :id");
    $select->bindParam(':id', $id);
    $select->execute();

    $post = $select->fetch(PDO::FETCH_OBJ);


    // Check if post with the given id exists
    if (!$post) {
        header("Location: http://localhost:31337/project/404.php");
        exit;
    }
}
?>

<!-- Page Header-->
<header class="masthead" style="background-image: url('images/<?php echo $post->img; ?>')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="post-heading">
                    <h1><?php echo $post->title; ?></h1>
                    <h2 class="subheading"><?php echo $post->subtitle; ?></h2>
                    <span class="meta">
                        Posted by
                        <a href="#!"><?php echo $post->user_name; ?></a>
                        <?php echo date('M', strtotime($post->created_at)) . ' ' . date('d', strtotime($post->created_at)) . ', ' . date('Y', strtotime($post->created_at)); ?>

                    </span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Post Content-->
<article class="mb-4">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">

                <p> <?php echo $post->body; ?> </p>
                <!-- <p>
                            Placeholder text by
                            <a href="http://spaceipsum.com/">Space Ipsum</a>
                            &middot; Images by
                            <a href="https://www.flickr.com/photos/nasacommons/">NASA on The Commons</a>
                        </p> -->
                <?php if (isset($_SESSION['user_id']) and $_SESSION['user_id'] == $post->user_id) : ?>

                    <a href="http://localhost:31337/project/posts/delete.php?del_id=<?php echo $post->id; ?>" class="btn btn-danger text-center float-end">Delete </a>

                    <a href="update.php?upd_id=<?php echo $post->id; ?>" class="btn btn-warning text-center">Update </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</article>

<?php require "../includes/footer.php"; ?>