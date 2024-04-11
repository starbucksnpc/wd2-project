<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

if (isset($_GET['up_id'])) {
    $id = $_GET['up_id'];

    if (!isset($_SESSION['adminname'])) {
        header("location: http://localhost:31337/project/admin-panel/admins/login-admins.php");
    }

    // First query to fetch the existing user details
    $select = $conn->query("SELECT * FROM users WHERE id = '$id'");
    $select->execute();
    $rows = $select->fetch(PDO::FETCH_OBJ);


    // Second query
    if (isset($_POST['submit'])) {
        if ($_POST['username'] == '') {
            echo "<div class='alert alert-danger text-center role='alert'> Enter data into the inputs. </div>";
        } else {


            $username = $_POST['username'];



            $update = $conn->prepare("UPDATE users SET username = :username WHERE id = '$id'");

            $update->execute([
                ':username' => $username,

            ]);

            //header('location: http://localhost:31337/project/admin-panel/users-admins/show-users.php');
        }
    }
} else {
    header('location: http://localhost:31337/project/404.php');
}

?>



<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Update Users</h5>
                <form method="POST" action="update-users.php?up_id=<?php echo $rows->id; ?>" enctype="multipart/form-data">
                    <!-- Email input -->

                    
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" value="<?php echo $rows->username; ?>" name="username" id="form2Example1" class="form-control" placeholder="username" />

                    </div>


                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Update</button>


                </form>

            </div>
        </div>
    </div>
</div>
<?php require "../layouts/footer.php"; ?>