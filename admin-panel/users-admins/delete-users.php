<?php require "../../config/config.php"; ?>

<?php

if (isset($_GET['de_id'])) {
    $id = filter_input(INPUT_GET, 'de_id', FILTER_VALIDATE_INT);

    // sanitize
    if (!is_numeric($id)) {
        header("Location: http://localhost:31337/project/404.php");
        exit;
    }


    // Check if the user exists
    $check_user = $conn->prepare("SELECT id FROM users WHERE id = :id");
    $check_user->execute([':id' => $id]);
    $user_exists = $check_user->fetch();

    if (!$user_exists) {
        header("Location: http://localhost:31337/project/404.php");
        exit;
    }

    $delete = $conn->prepare("DELETE FROM users WHERE id = :id");
    $delete->execute([
        ':id' => $id
    ]);


    //echo "<div class='alert alert-danger text-center role='alert'> Successfully deleted. </div>";
    header('location: http://localhost:31337/project/admin-panel/users-admins/show-users.php');
} else {
    header('location: http://localhost:31337/project/404.php');
}

?>