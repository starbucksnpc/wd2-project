<?php require "../../config/config.php"; ?>

<?php


if (!isset($_SESSION['adminname'])) {
    header("location: http://localhost:31337/project/admin-panel/admins/login-admins.php");
  }
  

if (isset($_GET['comment_id']) AND isset($_GET['status_comment'])) {
  $id = $_GET['comment_id'];
  $status = $_GET['status_comment'];


  // Second query
  if ($status == 0) {
    
 
      $update = $conn->prepare("UPDATE comments SET status_comment = 1 WHERE id = '$id'");

      $update->execute();

      header('location: http://localhost:31337/project/admin-panel/comments-admins/show-comments.php');
    
  } else {
    $update = $conn->prepare("UPDATE comments SET status_comment = 0 WHERE id = '$id'");

    $update->execute();

    header('location: http://localhost:31337/project/admin-panel/comments-admins/show-comments.php');
}



} else {
  header('location: http://localhost:31337/project/404.php');
}

?>
