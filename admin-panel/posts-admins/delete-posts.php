<?php require "../../config/config.php"; ?>

<?php

    if(isset($_GET['po_id'])) {
        $id = $_GET['po_id'];

        $delete = $conn->prepare("DELETE FROM posts WHERE id = :id");
        $delete->execute([
                ':id' => $id
            ]);

        
       //echo "<div class='alert alert-danger text-center role='alert'> Successfully deleted. </div>";
        header('location: http://localhost:31337/project/admin-panel/posts-admins/show-posts.php');
    } else {
        header('location: http://localhost:31337/project/404.php');
    }

?>