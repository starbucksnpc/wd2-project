<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>


<?php 

    if(isset($_POST['search'])) {

        if($_POST['search'] == '') {
            echo "<div class='alert alert-danger bg-danger text-white text-center'>
            Enter search keyword first</div>";
        } else{
            $search = $_POST['search'];

            $data = $conn->prepare("SELECT * FROM posts WHERE title LIKE '%$search%' AND status = 1");

            $data->execute();

            $rows = $data->fetchAll(PDO::FETCH_OBJ);
            
            if($data->rowCount() == 0 ) {
                echo "<div class='alert alert-danger bg-danger text-white text-center'>
                No results found.</div>";
            }
        }
    }

?>

<div class="row gx-4 gx-lg-5 justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-7">
    <?php if(count($rows) > 0) : ?>
        <div class='alert alert-dark bg-dark text-white text-center'> There are  <?php echo count($rows); ?> posts matching your search. </div>

        <?php foreach ($rows as $row) : ?>

            <!-- Post preview-->
            <div class="post-preview">
                <a href="posts/post.php?post_id=<?php echo $row->id; ?>">
                    <h2 class="post-title"><?php echo $row->title; ?></h2>
                    <h3 class="post-subtitle"><?php echo $row->subtitle; ?></h3>
                </a>
            
                <!-- html image tag -->
                <?php if (!empty($row->img)) : ?>
                    <img src="images/<?php echo htmlspecialchars($row->img); ?>" alt="<?php echo htmlspecialchars($row->title); ?>" style="width:100%;max-width:600px;">
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
            <!-- <div class='alert alert-danger bg-danger text-white text-center'>
            No results found.</div> -->

        <?php endif; ?>
        <!-- Pager-->

    </div>
</div>


<?php require "includes/footer.php"; ?>
