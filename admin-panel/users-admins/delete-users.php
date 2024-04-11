<?php require "../../config/config.php"; ?>

<?php

    if(isset($_GET['de_id'])) {
        $id = $_GET['de_id'];

        $delete = $conn->prepare("DELETE FROM users WHERE id = :id");
        $delete->execute([
                ':id' => $id
            ]);

        
       //echo "<div class='alert alert-danger text-center role='alert'> Successfully deleted. </div>";
        header('location: http://localhost:31337/project/admin-panel/users-admins/show-users.php');
    } else {
        //header('location: http://localhost:31337/project/404.php');
    }

?>