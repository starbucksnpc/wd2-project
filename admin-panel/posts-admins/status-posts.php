
<?php require "../../config/config.php"; ?>

<?php

if (isset($_GET['id']) AND isset($_GET['status'])) {
  $id = $_GET['id'];
  $status = $_GET['status'];


  // Second query
  if ($status == 0) {
    
 
      $update = $conn->prepare("UPDATE posts SET status = 1 WHERE id = '$id'");

      $update->execute();

      header('location: http://localhost:31337/project/admin-panel/posts-admins/show-posts.php');
    
  } else {
    $update = $conn->prepare("UPDATE posts SET status = 0 WHERE id = '$id'");

    $update->execute();

    header('location: http://localhost:31337/project/admin-panel/posts-admins/show-posts.php');
  }



} else {
  header('location: http://localhost:31337/project/404.php');
}

?>
