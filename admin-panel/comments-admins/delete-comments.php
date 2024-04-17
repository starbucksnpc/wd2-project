<?php require "../../config/config.php"; ?>

<?php

    if(isset($_GET['comment_id'])) {
        $id = filter_input(INPUT_GET, 'comment_id', FILTER_VALIDATE_INT);

  // sanitize
  if (!is_numeric($id)) {
    header("Location: http://localhost:31337/project/404.php");
    exit;
  }


        $delete = $conn->prepare("DELETE FROM comments WHERE id = :id");
        $delete->execute([
                ':id' => $id
            ]);

        
       //echo "<div class='alert alert-danger text-center role='alert'> Successfully deleted. </div>";
        header('location: http://localhost:31337/project/admin-panel/comments-admins/show-comments.php');
    } else {
        header('location: http://localhost:31337/project/404.php');
    }

?>