<?php require "../includes/navbar.php"; ?>
<?php require "../config/config.php"; ?>

<?php

    if(isset($_GET['del_id'])) {
        $id = $_GET['del_id'];

        $select = $conn->query("SELECT * FROM posts WHERE id = '$id'");
        $select->execute();
        $posts = $select->fetch(PDO::FETCH_OBJ);

        if($_SESSION['user_id'] !== $posts->user_id) {
            // header('location: http://localhost:31337/project/index.php');
            echo "yoyoyo?"; 
        }
        else {

            unlink("images/" . $posts->img . "");

            $delete = $conn->prepare("DELETE FROM posts WHERE id = :id");
            $delete->execute([
                ':id' => $id
            ]);
            echo "Successfully deleted.";

        }

        header('location: http://localhost:31337/project/index.php');
        // echo "are you?";
    }

?>