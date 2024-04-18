<?php require "../includes/header.php";
require "../config/config.php";

if (isset ($_GET['del_id'])) {
    $id = $_GET['del_id'];

    // Deleting image

    $select = $conn->query("SELECT * FROM posts WHERE id = '$id'");
    $select->execute();
    $posts = $select->fetch(PDO::FETCH_OBJ);


        if(!empty($posts->img)){
            unlink("images/" . $posts->img);
        }
        // Query

        $update = $conn->prepare("UPDATE posts SET img = NULL WHERE id = :id");
        $update->execute([':id' => $id]);



    // User a header here

    // header("");
    // exit;

    echo "<div class='alert alert-danger text-center role='alert'> Image deleted successfully. </div>";



} else {

    // User a header here

    // header("");
    // exit;

}

require "../includes/footer.php";