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


if(isset($_POST['submit']) AND isset($_GET['post_id'])) {
    //the id of the post and the username for the who posted the comment
    $id = $_GET['post_id'];
    $user_name = $_SESSION['username'];
    $comment = $_POST['comment'];

    $insert = $conn->prepare("INSERT INTO comments (id_post_comment, user_name_comment, comment) VALUES (:id_post_comment, :user_name_comment, :comment)");

    $insert->execute([
        ':id_post_comment' => $id,
        ':user_name_comment' => $user_name,
        ':comment' => $comment,

    ]);

    header("location: http://localhost:31337/project/posts/post.php?post_id=".$id."");
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



<section>
          <div class="container my-5 py-5">
            <div class="row d-flex justify-content-center">
              <div class="col-md-12 col-lg-10 col-xl-8">
                <h3 class="mb-5">Comments</h3>

                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-start align-items-center">
                    
                        <div>
                            <h6 class="fw-bold text-primary">Lily Coleman<h8 class="p-3 text-black">(Jun 2020)</h8></h6>
                            
                        </div>
                        </div>

                        <p class="mt-3 mb-4 pb-2">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip consequat.
                        </p>
                   

                        <hr class="my-4" />

                        <div class="d-flex flex-start align-items-center">
                        <div>
                            <h6 class="fw-bold text-primary">Lily Coleman<h8 class="p-3 text-black">(Jun 2020)</h8></h6>
                            
                        </div>
                        </div>

                        <p class="mt-3 mb-4 pb-2">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip consequat.
                        </p>

                 
                  </div>
                  <form method="POST" action="post.php?post_id=<?php echo $id; ?>">

                        <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">

                            <div class="d-flex flex-start w-100">
                            
                                <div class="form-outline w-100">
                                    <textarea class="form-control" id="" placeholder="write message" rows="4"
                                     name="comment"></textarea>
                                
                                </div>
                            </div>
                            <div class="float-end mt-2 pt-1">
                                <button type="submit" name="submit" class="btn btn-primary btn-sm mb-3">Post comment</button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </section>


<?php require "../includes/footer.php"; ?>