<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

if (isset($_GET['del_id'])) {
    $id = filter_input(INPUT_GET, 'del_id', FILTER_VALIDATE_INT);

    // sanitize
    if (!is_numeric($id)) {
        echo "<meta http-equiv='refresh' content='0;url=http://localhost:31337/project/404.php'>";
        exit;
    }

    $select = $conn->prepare("SELECT * FROM posts WHERE id = :id");
    $select->bindParam(':id', $id);
    $select->execute();
    $posts = $select->fetch(PDO::FETCH_OBJ);

    
    if ($_SESSION['user_id'] !== $posts->user_id) {
        echo "<meta http-equiv='refresh' content='0;url=http://localhost:31337/project/404.php'>";
    } else {

        $img = $posts->img;
        if (!empty($img)) { // if images exist

            unlink('C:/xampp/htdocs/project/posts/images' . $img);
        }

        $delete = $conn->prepare("DELETE FROM posts WHERE id = :id");
        $delete->execute([
            ':id' => $id
        ]);
    }
    echo "<div class='alert alert-danger text-center role='alert'> Successfully deleted. </div>";
    // header('location: http://localhost:31337/project/index.php');
} else {
    header('location: http://localhost:31337/project/404.php');
}

?>